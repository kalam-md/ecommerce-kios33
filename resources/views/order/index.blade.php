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
            @can('isAdmin')
            <th>Nama Konsumen</th>
            @endcan
            <th>Kode Order</th>
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
            @can('isAdmin')
            <td>{{ $order->user->nama_lengkap }}</td>
            @endcan
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
              @if ($order->status == 'pending')
                @can('isAdmin')
                  <form action="{{ route('order.cancel', $order->order_number) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-icon btn-danger" onclick="return confirm('Apakah anda yakin ingin membatalkan order ini?')">
                        <span class="tf-icons bx bx-x bx-22px"></span>
                    </button>
                  </form>
                @endcan
                @can('isUser')
                  <button class="btn btn-icon btn-success" onclick="payOrder('{{ $order->snap_token }}')">
                    <span class="tf-icons bx bx-wallet bx-22px"></span>
                  </button>
                @endcan
              @elseif($order->status == 'paid')
              <a href="{{ route('order.pdf', $order->order_number) }}" target="_blank" class="btn btn-icon btn-info">
                <span class="tf-icons bx bx-download bx-22px"></span>
              </a>
              @else
              <button target="_blank" class="btn btn-icon btn-danger">
                <span class="tf-icons bx bx-minus bx-22px"></span>
              </button>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
  function payOrder(snapToken) {
      snap.pay(snapToken, {
          onSuccess: function(result) {
              window.location.reload();
          },
          onPending: function(result) {
              window.location.reload();
          },
          onError: function(result) {
              alert('Pembayaran gagal');
          },
          onClose: function() {
              alert('Anda menutup popup tanpa menyelesaikan pembayaran');
          }
      });
  }
</script>
@endsection