<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        return view('kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string'
        ]);

        $validatedData['slug'] = SlugService::createSlug(Kategori::class, 'slug', $validatedData['nama_kategori']);

        Kategori::create($validatedData);

        alert()->success('Sukses', 'Kategori berhasil ditambahkan');
        return redirect()->route('kategori.index');
    }

    public function show(string $slug)
    {
        $kategori = Kategori::where('slug', $slug)->first();
        return view('kategori.show', compact('kategori'));
    }

    public function edit(string $slug)
    {
        $kategori = Kategori::where('slug', $slug)->first();
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, string $slug)
    {
        $kategori = Kategori::where('slug', $slug)->first();

        $validatedData = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'required|string'
        ]);

        $validatedData['slug'] = SlugService::createSlug(Kategori::class, 'slug', $validatedData['nama_kategori']);

        Kategori::where('id', $kategori->id)->update($validatedData);

        alert()->success('Sukses', 'Kategori berhasil diperbaharui');
        return redirect()->route('kategori.index');
    }

    public function destroy(string $slug)
    {
        $kategori = Kategori::where('slug', $slug)->first();
        $kategori->delete();

        alert()->success('Sukses', 'Kategori berhasil dihapus');
        return redirect()->route('kategori.index');
    }
}
