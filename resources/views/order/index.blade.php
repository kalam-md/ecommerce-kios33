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
              <a href="{{ route('order.invoice', $order->order_number) }}">{{ $order->order_number }}</a>
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
              <button type="submit" class="btn btn-icon btn-info">
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