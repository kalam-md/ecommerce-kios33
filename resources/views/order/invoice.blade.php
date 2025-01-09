@extends('layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-12">
      <div class="p-8 card">
        <h5 class="mb-3">Invoice : {{ $order->order_number }}</h5>
        <div class="border rounded table-responsive border-bottom-0 border-top-0">
          <table class="table m-0">
            <thead>
              <tr>
                <th>Produk</th>
                <th>Berat</th>
                <th>Harga</th>
                <th class="text-center">Kuantitas</th>
                <th>Total Harga</th>
              </tr>
            </thead>
            <tbody>
              @foreach($order->items as $item)
              <tr>
                <td class="text-nowrap text-heading">
                  <div class="d-flex align-items-center">
                    <div id="carousel-{{ $item->produk->id }}" class="carousel slide" data-bs-ride="carousel" style="width: 100px; height: 100px; border-radius: 8px; overflow: hidden;">
                        <div class="carousel-inner">
                            @foreach (json_decode($item->produk->gambar) as $index => $gam)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ asset('/produks/'.$gam) }}" alt="Gambar Produk" class="d-block w-100" style="height: 100px; object-fit: cover;">
                            </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $item->produk->id }}" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $item->produk->id }}" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <div class="d-flex flex-column">
                      <h6 class="mb-0 text-nowrap ms-3">{{ $item->produk->nama_produk }}</h6>
                      <div class="mb-0 text-nowrap ms-3">
                        <small>Kategori : {{ $item->produk->kategori->nama_kategori }}</small>
                      </div>
                    </div>
                  </div>
                </td>
                <td class="text-nowrap">{{ $item->produk->berat }} gram</td>
                <td>Rp {{ number_format($item->price, 0, ',', '.') }}/{{ $item->produk->satuan }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="table-responsive">
          <table class="table m-0 table-borderless">
            <tbody>
              <tr>
                <td class="py-6 align-top pe-6 ps-0 text-body">
                  <p class="mb-1">
                    <span class="me-2 h6">Nama Pembeli:</span>
                    <span>{{ $order->user->nama_lengkap }}</span>
                  </p>
                  <p class="mb-1">
                    <span class="me-2 h6">Nomor Telepon:</span>
                    <span>{{ $order->user->nomor_telepon }}</span>
                  </p>
                  <p class="mb-1">
                    <span class="me-2 h6">Email:</span>
                    <span>{{ $order->user->email }}</span>
                  </p>
                  <p class="mb-1">
                    <span class="me-2 h6">Alamat:</span>
                    <span>{{ $order->alamat }}</span>
                  </p>
                </td>
                <td class="px-0 py-6 w-px-100">
                  <p class="mb-2">Subtotal:</p>
                  <p class="pb-2 mb-2 border-bottom">Tax:</p>
                  <p class="mb-0">Total:</p>
                </td>
                <td class="px-0 py-6 text-end w-px-100 fw-medium text-heading">
                  <p class="mb-2 fw-medium">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                  <p class="pb-2 mb-2 fw-medium border-bottom">0%</p>
                  <p class="mb-0 fw-medium">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
  
        <hr class="mt-0 mb-6">
        <div class="p-0 card-body">
          <div class="mb-6 row">
            <div class="col-12">
              <span class="fw-medium text-heading">Keterangan:</span>
              @if ($order->status == 'paid')
              <span>Kami sangat menghargai kepercayaan Anda dengan berbelanja di tempat kami. Semoga produk yang Anda beli memberikan manfaat dan kepuasan. Jangan ragu untuk kembali dan melihat penawaran menarik lainnya.</span>
              @elseif($order->status == 'cancelled')
              <span>Kami sangat menghargai kepercayaan Anda dengan berbelanja di tempat kami. Namun mohon maaf orderan anda gagal, silahkan order kembali.</span>
              @endif
            </div>
          </div>
          @if ($order->status == 'cancelled')
          <a href="{{ route('order.index') }}" class="btn btn-outline-secondary">Kembali</a>
          @else
          <a href="{{ route('order.pdf', $order->order_number) }}" target="_blank" class="btn btn-primary me-3">Cetak Invoice</a>
          <a href="{{ route('order.index') }}" class="btn btn-outline-secondary">Kembali</a>
          @endif
        </div>
      </div>
    </div>
  </div>  
</div>
@endsection