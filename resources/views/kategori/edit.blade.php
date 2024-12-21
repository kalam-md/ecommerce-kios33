@extends('layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-12">
      <div class="mb-6 card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Ubah Data Kategori Produk</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('kategori.update', $kategori->slug) }}" method="POST">
            @csrf
            @method('put')
            <div class="row g-3">
              <div class="col-12">
                <label class="form-label" for="nama_kategori">Nama Kategori</label>
                <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="{{ $kategori->nama_kategori }}"/>
              </div>
              <div class="mb-6 col-12">
                <label class="form-label" for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" id="" cols="30" rows="5">{{ $kategori->deskripsi }}</textarea>
              </div>
            </div>
            <button type="submit" class="btn btn-primary me-3">Ubah</button>
            <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary">Kembali</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection