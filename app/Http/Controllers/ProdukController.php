<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_produk' => 'required|string|max:255',
            'sku' => 'nullable|string|unique:produks,sku',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|in:pcs,kg,lusin',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_aktif' => 'boolean',
            'berat' => 'nullable|integer|min:0',
            'dimensi' => 'nullable|string',
            'spesifikasi' => 'nullable|string',
        ]);

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $path = $gambar->store('public/produks');
            $validatedData['gambar'] = str_replace('public/', '', $path);
        }

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
            'sku' => 'nullable|string|unique:produks,sku,' . $slug,
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|in:pcs,kg,lusin',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_aktif' => 'boolean',
            'berat' => 'nullable|integer|min:0',
            'dimensi' => 'nullable|string',
            'spesifikasi' => 'nullable|string',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($produk->gambar) {
                Storage::delete('public/' . $produk->gambar);
            }

            $gambar = $request->file('gambar');
            $path = $gambar->store('public/produks');
            $validatedData['gambar'] = str_replace('public/', '', $path);
        }

        $produk->update($validatedData);

        alert()->success('Sukses', 'Produk berhasil diperbaharui');
        return redirect()->route('produk.index');
    }

    public function destroy(string $slug)
    {
        $produk = Produk::where('slug', $slug)->first();

        // Hapus gambar jika ada
        if ($produk->gambar) {
            Storage::delete('public/' . $produk->gambar);
        }

        $produk->delete();

        alert()->success('Sukses', 'Produk berhasil dihapus');
        return redirect()->route('produk.index');
    }
}
