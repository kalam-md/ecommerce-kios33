@extends('layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Keranjang Belanja</h5>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table table-hover">
        <thead>
          <tr>
            <th class="align-middle d-flex align-items-center">
              <input class="form-check-input" type="checkbox" id="selectAll">
            </th>
            <th>Nama Produk</th>
            <th>Sub Harga</th>
            <th>Jumlah</th>
            <th>Total Harga</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @foreach ($keranjangs as $keranjang)
          <tr>
            <td>
              <div class="form-check">
                <input class="form-check-input cart-checkbox" type="checkbox" 
                       data-id="{{ $keranjang->id }}"
                       data-price="{{ $keranjang->kuantitas * $keranjang->harga }}"
                       value="{{ $keranjang->id }}">
              </div>
            </td>
            <td>
              <div class="d-flex align-items-center">
                  <div id="carousel-{{ $keranjang->produk->id }}" class="carousel slide" data-bs-ride="carousel" style="width: 150px; height: 150px; border-radius: 8px; overflow: hidden;">
                      <div class="carousel-inner">
                          @foreach (json_decode($keranjang->produk->gambar) as $index => $gam)
                          <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                              <img src="{{ asset('/produks/'.$gam) }}" alt="Gambar Produk" class="d-block w-100" style="height: 150px; object-fit: cover;">
                          </div>
                          @endforeach
                      </div>
                      <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $keranjang->produk->id }}" data-bs-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="visually-hidden">Previous</span>
                      </button>
                      <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $keranjang->produk->id }}" data-bs-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="visually-hidden">Next</span>
                      </button>
                  </div>
                  <div class="d-flex flex-column">
                    <h6 class="mb-0 text-nowrap ms-3">{{ $keranjang->produk->nama_produk }}</h6>
                    <a href="{{ route('produk.show', $keranjang->produk->slug) }}" class="mb-0 text-nowrap ms-3">
                      <small>Lihat Produk</small>
                    </a>
                  </div>
              </div>
            </td>
            <td>Rp {{ number_format($keranjang->produk->harga, 0, ',', '.') }}/{{ $keranjang->produk->satuan }}</td>
            <td>
              <div class="input-group" style="width: 120px;">
                <button class="btn btn-outline-secondary btn-sm" 
                        onclick="updateQuantity('{{ $keranjang->id }}', -1)">-</button>
                <input type="number" class="text-center form-control" 
                       value="{{ $keranjang->kuantitas }}" min="1" 
                       id="quantity-{{ $keranjang->id }}" readonly>
                <button class="btn btn-outline-secondary btn-sm" 
                        onclick="updateQuantity('{{ $keranjang->id }}', 1)">+</button>
              </div>
            </td>
            <td>Rp {{ number_format($keranjang->kuantitas * $keranjang->harga, 0, ',', '.') }}</td>
            <td class="text-center">
              <form action="{{ route('keranjang.hapus', $keranjang->id) }}" method="POST">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-icon me-2 btn-danger">
                  <span class="tf-icons bx bx-trash-alt bx-22px"></span>
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
              <td colspan="3"><strong>Total dipilih:</strong></td>
              <td colspan="1">
                <strong>
                  <span id="selectedTotal">Rp 0</span>
                </strong>
              </td>
              <td class="text-center">
                <button class="m-0 btn btn-primary" id="checkoutSelected" disabled>Beli Semua</button>
              </td>
          </tr>
      </tfoot>
      </table>
    </div>
  </div>
</div>

<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>

<script>
function updateQuantity(keranjangId, change) {
    const quantityInput = document.getElementById(`quantity-${keranjangId}`);
    let newQuantity = parseInt(quantityInput.value) + change;
    
    if (newQuantity < 1) return;
    
    fetch(`/keranjang/update/${keranjangId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ kuantitas: newQuantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}
</script>

<script>
  function checkout() {
      fetch('{{ route("checkout") }}', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          }
      })
      .then(response => response.json())
      .then(data => {
          if (data.success) {
              window.snap.pay(data.snap_token, {
                  onSuccess: function(result) {
                      window.location.href = '/orders'; // Redirect to orders page
                  },
                  onPending: function(result) {
                      alert('Pembayaran pending, silakan selesaikan pembayaran');
                  },
                  onError: function(result) {
                      alert('Pembayaran gagal');
                  },
                  onClose: function() {
                      alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                  }
              });
          } else {
              alert(data.error || 'Terjadi kesalahan');
          }
      })
      .catch(error => {
          console.error('Error:', error);
          alert('Terjadi kesalahan');
      });
  }
  </script>
@endsection