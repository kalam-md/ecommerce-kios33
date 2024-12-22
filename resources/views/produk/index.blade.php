@extends('layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Produk</h5>
      <a href="{{ route('produk.create') }}" class="btn btn-primary">Tambah Data Produk</a>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th class="text-center">Stok</th>
            <th class="text-center">Berat</th>
            <th>Harga</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @foreach ($produks as $produk)
          <tr>
            <td>
              <div class="d-flex align-items-center">
                  <div id="carousel-{{ $produk->id }}" class="carousel slide" data-bs-ride="carousel" style="width: 150px; height: 150px; border-radius: 8px; overflow: hidden;">
                      <div class="carousel-inner">
                          @foreach (json_decode($produk->gambar) as $index => $gam)
                          <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                              <img src="{{ asset('/produks/'.$gam) }}" alt="Gambar Produk" class="d-block w-100" style="height: 150px; object-fit: cover;">
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
                  <h6 class="mb-0 text-nowrap ms-3">{{ $produk->nama_produk }}</h6>
              </div>
            </td>
            <td>{{ $produk->kategori->nama_kategori }}</td>
            <td class="text-center">{{ $produk->stok }}</td>
            <td class="text-center">{{ $produk->berat }} gram</td>
            <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}/{{ $produk->satuan }}</td>
            <td class="text-center">
              <div class="dropdown">
                <button type="button" class="p-0 btn dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="{{ route('produk.edit', $produk->slug) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                  <form class="dropdown-item" action="{{ route('produk.destroy', $produk->slug) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" style="all: unset; cursor: pointer"><i class="bx bx-trash me-1"></i> Hapus</button>
                  </form>
                </div>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection