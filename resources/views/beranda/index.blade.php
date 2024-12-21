@extends('layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="mb-6 col-xxl-8 order-0">
      <div class="card">
        <div class="d-flex align-items-center row">
          <div class="col-sm-7">
            <div class="card-body">
              <h4 class="mb-3 card-title text-primary">Selamat datang {{ Auth::user()->nama_lengkap }}</h4>
              <p>Selamat datang di Aplikasi Penjualan Tanaman, Obat Tanaman dan Pupuk</p>
            </div>
          </div>
          <div class="text-center col-sm-5 text-sm-left">
            <div class="px-0 pb-0 card-body px-md-6">
              <img
                src="{{ asset('template/img/illustrations/man-with-laptop.png') }}"
                height="175"
                class="scaleX-n1-rtl"
                alt="View Badge User" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="order-1 col-lg-12 col-md-4">
      <div class="row">
        <div class="mb-6 col-lg-4 col-md-12 col-6">
          <div class="card h-100">
            <div class="card-body">
              <div class="mb-4 card-title d-flex align-items-start justify-content-between">
                <div class="flex-shrink-0 avatar">
                  <img
                    src="{{ asset('template/img/icons/unicons/chart-success.png') }}"
                    alt="chart success"
                    class="rounded" />
                </div>
              </div>
              <p class="mb-1">Data Akun</p>
              <h4 class="mb-3 card-title">15 Akun</h4>
            </div>
          </div>
        </div>
        <div class="mb-6 col-lg-4 col-md-12 col-6">
          <div class="card h-100">
            <div class="card-body">
              <div class="mb-4 card-title d-flex align-items-start justify-content-between">
                <div class="flex-shrink-0 avatar">
                  <img
                    src="{{ asset('template/img/icons/unicons/wallet-info.png') }}"
                    alt="wallet info"
                    class="rounded" />
                </div>
              </div>
              <p class="mb-1">Data Dokter</p>
              <h4 class="mb-3 card-title">5 Dokter</h4>
            </div>
          </div>
        </div>
        <div class="mb-6 col-lg-4 col-md-12 col-6">
          <div class="card h-100">
            <div class="card-body">
              <div class="mb-4 card-title d-flex align-items-start justify-content-between">
                <div class="flex-shrink-0 avatar">
                  <img
                    src="{{ asset('template/img/icons/unicons/chart-success.png') }}"
                    alt="chart success"
                    class="rounded" />
                </div>
              </div>
              <p class="mb-1">Data Pasien</p>
              <h4 class="mb-3 card-title">4 Pasien Terdaftar</h4>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection