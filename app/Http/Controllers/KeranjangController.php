<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjangs = Keranjang::with('produk')
            ->where('user_id', Auth::user()->id)
            ->get();

        return view('keranjang.index', compact('keranjangs'));
    }

    public function tambah(Produk $produk)
    {
        $keranjangItem = Keranjang::where('user_id', Auth::user()->id,)
            ->where('produk_id', $produk->id)
            ->first();

        if ($keranjangItem) {
            $keranjangItem->increment('kuantitas');
        } else {
            Keranjang::create([
                'user_id' => Auth::user()->id,
                'produk_id' => $produk->id,
                'kuantitas' => 1,
                'harga' => $produk->harga
            ]);
        }

        alert()->success('Sukses', 'Produk berhasil ditambahkan ke keranjang');
        return redirect()->back();
    }

    public function update(Request $request, Keranjang $keranjang)
    {
        $request->validate([
            'kuantitas' => 'required|integer|min:1'
        ]);

        $keranjang->update([
            'kuantitas' => $request->kuantitas
        ]);

        return response()->json(['success' => true]);
    }

    public function hapus(Keranjang $keranjang)
    {
        $keranjang->delete();

        alert()->success('Sukses', 'Produk berhasil dihapus dari keranjang');
        return redirect()->back();
    }
}
