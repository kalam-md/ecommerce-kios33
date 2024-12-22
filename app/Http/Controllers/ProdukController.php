<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::with('kategori')->latest()->get();
        return view('produk.index', compact('produks'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('produk.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kategori_id' => 'required',
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|in:pcs,kg,lusin',
            'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_aktif' => 'boolean',
            'berat' => 'nullable|integer|min:0',
            'dimensi' => 'nullable|string',
            'spesifikasi' => 'nullable|string',
        ]);

        $namaProduk = explode(' ', trim($validatedData['nama_produk']));
        $namaDepan = strtoupper(substr($namaProduk[0], 0, 3)); // 3 huruf pertama dari kata pertama
        $tahun = date('Y');
        $namaBelakang = '';

        if (count($namaProduk) > 1) {
            $namaBelakang = strtoupper(substr(end($namaProduk), 0, 3)); // 3 huruf pertama dari kata terakhir
        }

        $satuan = strtoupper(substr($validatedData['satuan'], 0, 3)); // 3 huruf pertama dari satuan
        $random = strtoupper(Str::random(3)) . rand(10, 99); // 3 huruf random + 2 angka random

        $validatedData['sku'] = "{$namaDepan}{$tahun}{$namaBelakang}{$satuan}{$random}";
        $validatedData['slug'] = SlugService::createSlug(Produk::class, 'slug', $validatedData['nama_produk']);

        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $gambar) {
                $namaGambar = uniqid() . '_' . $gambar->getClientOriginalName();
                $gambar->move(public_path() . '/produks/', $namaGambar);
                $namaGambars[] = $namaGambar;
            }
        }

        $validatedData['gambar'] = json_encode($namaGambars);

        Produk::create($validatedData);

        alert()->success('Sukses', 'Produk berhasil ditambahkan');
        return redirect()->route('produk.index');
    }

    public function show(string $slug)
    {
        $produk = Produk::where('slug', $slug)->first();
        return view('produk.show', compact('produk'));
    }

    public function edit(string $slug)
    {
        $produk = Produk::where('slug', $slug)->first();
        $kategoris = Kategori::all();
        return view('produk.edit', compact('produk', 'kategoris'));
    }

    public function update(Request $request, string $slug)
    {
        $produk = Produk::where('slug', $slug)->first();

        $validatedData = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|in:pcs,kg,lusin',
            'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_aktif' => 'boolean',
            'berat' => 'nullable|integer|min:0',
            'dimensi' => 'nullable|string',
            'spesifikasi' => 'nullable|string',
        ]);

        $namaProduk = explode(' ', trim($validatedData['nama_produk']));
        $namaDepan = strtoupper(substr($namaProduk[0], 0, 3)); // 3 huruf pertama dari kata pertama
        $tahun = date('Y');
        $namaBelakang = '';

        if (count($namaProduk) > 1) {
            $namaBelakang = strtoupper(substr(end($namaProduk), 0, 3)); // 3 huruf pertama dari kata terakhir
        }

        $satuan = strtoupper(substr($validatedData['satuan'], 0, 3)); // 3 huruf pertama dari satuan
        $random = strtoupper(Str::random(3)) . rand(10, 99); // 3 huruf random + 2 angka random

        $validatedData['sku'] = "{$namaDepan}{$tahun}{$namaBelakang}{$satuan}{$random}";
        $validatedData['slug'] = SlugService::createSlug(Produk::class, 'slug', $validatedData['nama_produk']);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama dari storage
            if (!empty($produk->gambar)) {
                $gambarLama = json_decode($produk->gambar, true); // Decode ke array
                if (is_array($gambarLama)) {
                    foreach ($gambarLama as $gambar) {
                        $path = public_path('produks/' . $gambar);
                        if (file_exists($path)) {
                            unlink($path);
                        }
                    }
                }
            }

            // Upload gambar baru
            $namaGambars = []; // Array untuk menyimpan nama gambar baru
            foreach ($request->file('gambar') as $gambar) {
                $namaGambar = uniqid() . '_' . $gambar->getClientOriginalName();
                $gambar->move(public_path('produks'), $namaGambar);
                $namaGambars[] = $namaGambar;
            }

            $validatedData['gambar'] = json_encode($namaGambars);
        } else {
            // Jika tidak ada gambar baru yang diunggah, tetap gunakan gambar lama
            $validatedData['gambar'] = $produk->gambar;
        }

        $produk->update($validatedData);

        alert()->success('Sukses', 'Produk berhasil diperbaharui');
        return redirect()->route('produk.index');
    }

    public function destroy(string $slug)
    {
        $produk = Produk::where('slug', $slug)->first();

        if (!empty($produk->gambar)) {
            $gambarLama = json_decode($produk->gambar, true); // Decode ke array
            if (is_array($gambarLama)) {
                foreach ($gambarLama as $gambar) {
                    $path = public_path('produks/' . $gambar);
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
            }
        }

        $produk->delete();

        alert()->success('Sukses', 'Produk berhasil dihapus');
        return redirect()->route('produk.index');
    }
}
