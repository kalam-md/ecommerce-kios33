<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Produk;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function __construct()
    {
        // Set your Midtrans configuration here
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            // Jika admin, tampilkan semua data order
            $orders = Order::with(['items'])->orderBy('created_at', 'desc')->get();
        } else {
            // Jika user biasa, tampilkan hanya order milik user tersebut
            $orders = Order::with(['items'])->where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        }

        return view('order.index', compact('orders'));
    }

    public function invoices(string $order_number)
    {
        $order = Order::where('order_number', $order_number)->first();
        return view('order.invoice', compact('order'));
    }

    public function generatePDF(string $order_number)
    {
        $order = Order::where('order_number', $order_number)->first();

        $pdf = Pdf::loadView('order.invoice-pdf', compact('order'));

        // Set paper to A4
        $pdf->setPaper('A4', 'landscape');

        // Optional: Customize PDF settings
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'sans-serif'
        ]);

        // Download PDF with custom filename
        return $pdf->download('Invoice-' . $order->order_number . '.pdf');
    }

    public function checkout(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();
            $cartIds = $request->cart_ids;
            $cartItems = Keranjang::whereIn('id', $cartIds)
                ->where('user_id', $user->id)
                ->get();

            if ($cartItems->isEmpty()) {
                return response()->json(['error' => 'Keranjang kosong'], 400);
            }

            // Create order
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(10)) . '-' . now()->format('YmdHis'),
                'user_id' => $user->id,
                'total_amount' => $cartItems->sum(function ($item) {
                    return $item->harga * $item->kuantitas;
                }),
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'alamat' => $request->alamat
            ]);

            // Create order items and update stock
            foreach ($cartItems as $item) {
                $produk = Produk::find($item->produk_id);

                // Check stock availability
                if ($produk->stok < $item->kuantitas) {
                    DB::rollBack();
                    return response()->json([
                        'error' => "Stok tidak mencukupi untuk produk {$produk->nama_produk}"
                    ], 400);
                }

                // Create order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'produk_id' => $item->produk_id,
                    'quantity' => $item->kuantitas,
                    'price' => $item->harga
                ]);

                // Update product stock
                $produk->update([
                    'stok' => $produk->stok - $item->kuantitas
                ]);
            }

            // Set up Midtrans payment
            $payload = [
                'transaction_details' => [
                    'order_id' => $order->order_number,
                    'gross_amount' => (int) $order->total_amount,
                ],
                'customer_details' => [
                    'first_name' => $user->nama_lengkap,
                    'email' => $user->email,
                ],
                'item_details' => $cartItems->map(function ($item) {
                    return [
                        'id' => $item->produk_id,
                        'price' => (int) $item->harga,
                        'quantity' => $item->kuantitas,
                        'name' => $item->produk->nama_produk
                    ];
                })->toArray(),
            ];

            // Get Snap Token
            $snapToken = Snap::getSnapToken($payload);
            $order->update(['snap_token' => $snapToken]);

            // Clear cart
            Keranjang::whereIn('id', $cartIds)->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function handleCallback(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            $order = Order::where('order_number', $request->order_id)->first();

            if (!$order) {
                return response()->json(['error' => 'Order not found'], 404);
            }

            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                $order->update([
                    'status' => 'paid',
                    'payment_status' => 'paid'
                ]);
            } elseif ($request->transaction_status == 'cancel' || $request->transaction_status == 'deny' || $request->transaction_status == 'expire') {
                // Restore stock
                foreach ($order->items as $item) {
                    $produk = Produk::find($item->produk_id);
                    $produk->update([
                        'stok' => $produk->stok + $item->quantity
                    ]);
                }

                $order->update([
                    'status' => 'cancelled',
                    'payment_status' => 'failed'
                ]);
            }
        }

        return response()->json(['success' => true]);
    }

    public function cancelOrder(string $order_number)
    {
        $order = Order::where('order_number', $order_number)->first();

        try {
            DB::beginTransaction();

            // Check if order is pending
            if ($order->status !== 'pending') {
                return redirect()->back()->with('error', 'Hanya orderan pending yang dapat dibatalkan');
            }

            // Restore stock
            foreach ($order->items as $item) {
                $produk = Produk::find($item->produk_id);
                $produk->update([
                    'stok' => $produk->stok + $item->quantity
                ]);
            }

            // Update order status
            $order->update([
                'status' => 'cancelled',
                'payment_status' => 'failed'
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Order berhasil dibatalkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membatalkan order');
        }
    }

    public function payOrder(string $order_number)
    {
        $order = Order::where('order_number', $order_number)->first();

        // Check if order is pending
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya orderan pending yang dapat dibayar');
        }

        return response()->json([
            'success' => true,
            'snap_token' => $order->snap_token
        ]);
    }
}
