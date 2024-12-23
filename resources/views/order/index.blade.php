@extends('layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Riwayat Belanja</h5>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Nama Produk</th>
            <th>Sub Harga</th>
            <th class="text-center">Jumlah</th>
            <th>Total Harga</th>
            <th class="text-center">Status</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @foreach ($orders as $order)
          <tr>
            <td>
              <div class="d-flex align-items-center">
                  <div id="carousel-{{ $order->order_number }}" class="carousel slide" data-bs-ride="carousel" style="width: 150px; height: 150px; border-radius: 8px; overflow: hidden;">
                      <div class="carousel-inner">
                          @foreach (json_decode($order->items->first()->produk->gambar) as $index => $gam)
                          <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                              <img src="{{ asset('/produks/'.$gam) }}" alt="Gambar Produk" class="d-block w-100" style="height: 150px; object-fit: cover;">
                          </div>
                          @endforeach
                      </div>
                      <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $order->order_number }}" data-bs-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="visually-hidden">Previous</span>
                      </button>
                      <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $order->order_number }}" data-bs-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="visually-hidden">Next</span>
                      </button>
                  </div>
                  <div class="d-flex flex-column">
                    <h6 class="mb-0 text-nowrap ms-3">{{ $order->items->first()->produk->nama_produk }}</h6>
                    <a href="{{ route('produk.show', $order->items->first()->produk->slug) }}" class="mb-0 text-nowrap ms-3">
                      <small>Lihat Produk</small>
                    </a>
                  </div>
              </div>
            </td>
            <td>Rp {{ number_format($order->items->first()->price, 0, ',', '.') }}/{{ $order->items->first()->produk->satuan }}</td>
            <td class="text-center">{{ $order->items->first()->quantity }}</td>
            <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
            <td class="text-center">
              @if ($order->status === 'pending')
                  <span class="badge bg-warning">Pending</span>
              @elseif ($order->status === 'paid')
                  <span class="badge bg-success">Sukses</span>
              @else
                  <span class="badge bg-danger">Gagal</span>
              @endif
            </td>
            <td class="text-center">
              <button type="submit" class="btn btn-icon me-2 btn-info">
                <span class="tf-icons bx bx-download bx-22px"></span>
              </button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>

@endsection