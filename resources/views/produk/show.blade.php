@extends('layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="justify-content-between card-header d-flex align-items-center">
          <div>
            <h5 class="mb-0">{{ $produk->nama_produk }}</h5>
            <small>SKU: {{ $produk->sku }}</small>
          </div>
          <div class="mb-2 form-check form-switch">
            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
          </div>
        </div>
        <div class="card-body">
          <div class="d-flex flex-column">
            <div class="d-flex">
              <div class="d-flex align-items-center">
                <div id="carousel-{{ $produk->id }}" class="me-6 carousel slide" data-bs-ride="carousel" style="width: 350px; height: 350px; border-radius: 8px; overflow: hidden;">
                    <div class="carousel-inner">
                        @foreach (json_decode($produk->gambar) as $index => $gam)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ asset('/produks/'.$gam) }}" alt="Gambar Produk" class="d-block w-100" style="height: 350px; object-fit: cover;">
                        </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $produk->id }}" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $produk->id }}" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
              </div>
              <div class="d-flex flex-column">
                <div>
                  <h5 class="mb-1">Deskripsi</h5>
                  <span class="card-subtitle">{{ $produk->deskripsi }}</span>
                </div>
                <div class="mt-3">
                  <h5 class="mb-1">Spesifikasi</h5>
                  <span class="card-subtitle">{{ $produk->spesifikasi }}</span>
                </div>
                <div class="mt-3 row g-3">
                  <div class="col">
                    <h5 class="mb-1">Kategori</h5>
                    <span class="card-subtitle">{{ $produk->kategori->nama_kategori }}</span>
                  </div>
                  <div class="col">
                    <h5 class="mb-1">Harga</h5>
                    <span class="card-subtitle">Rp {{ number_format($produk->harga, 0, ',', '.') }}/{{ $produk->satuan }}</span>
                  </div>
                  <div class="col">
                    <h5 class="mb-1">Berat</h5>
                    <span class="card-subtitle">{{ $produk->berat }} gram</span>
                  </div>
                  <div class="col">
                    <h5 class="mb-1">Stok</h5>
                    <span class="card-subtitle">{{ $produk->stok }} Stok</span>
                  </div>
                  <div class="col">
                    <h5 class="mb-1">Dimensi</h5>
                    <span class="card-subtitle">{{ $produk->dimensi }} cm</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <a href="{{ route('produk.index') }}" class="mt-6 btn btn-outline-secondary">Kembali</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection