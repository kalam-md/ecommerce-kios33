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
                <td class="text-nowrap text-heading">{{ $item->produk->nama_produk }}</td>
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
                    <span>{{ $order->user->biodata->alamat ? $order->user->biodata->alamat : '*Belum isi alamat' }}</span>
                  </p>
                </td>
                <td class="px-0 py-6 w-px-100">
                  <p class="mb-2">Subtotal:</p>
                  <p class="mb-2">Diskon:</p>
                  <p class="pb-2 mb-2 border-bottom">Tax:</p>
                  <p class="mb-0">Total:</p>
                </td>
                <td class="px-0 py-6 text-end w-px-100 fw-medium text-heading">
                  <p class="mb-2 fw-medium">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                  <p class="mb-2 fw-medium">Rp 0</p>
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
              <span>Kami sangat menghargai kepercayaan Anda dengan berbelanja di tempat kami. Semoga produk yang Anda beli memberikan manfaat dan kepuasan. Jangan ragu untuk kembali dan melihat penawaran menarik lainnya.</span>
            </div>
          </div>
          <button type="button" class="btn btn-primary me-3">Cetak Invoice</button>
          <a href="{{ route('order.index') }}" class="btn btn-outline-secondary">Kembali</a>
        </div>
      </div>
    </div>
  </div>  
</div>
@endsection