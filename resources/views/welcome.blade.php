<!doctype html>

<html
  lang="en"
  class="light-style layout-menu-fixed layout-compact"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="template/"
  data-template="vertical-menu-template-free"
  data-style="light">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Toko ABC</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('template/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('template/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('template/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('template/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('template/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('template/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('template/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('template/js/config.js') }}"></script>
  </head>

  <body>
    @include('sweetalert::alert')
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar layout-without-menu">
        <div class="layout-container">
          <!-- Layout container -->
          <div class="layout-page">
            <!-- Navbar -->
  
            <nav
              class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
              id="layout-navbar">
              <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                <div class="navbar-nav align-items-center d-none d-md-block">
                    <a href="{{ url('/') }}" class="nav-item text-dark d-flex align-items-center">
                        Toko ABC
                    </a>
                </div>
  
                <ul class="flex-row navbar-nav align-items-center ms-auto">
                  <li class="nav-item me-6">
                    <a href="#tentang-kami" style="all: unset; cursor: pointer;">Tentang Kami</a>
                  </li>
                  <li class="nav-item me-6">
                    <a href="#produk" style="all: unset; cursor: pointer;">Produk</a>
                  </li>
                  <li class="nav-item me-6">
                    <a href="#kontak-kami" style="all: unset; cursor: pointer;">Kontak Kami</a>
                  </li>
                  @if (Route::has('login'))
                      @auth
                      <li class="nav-item navbar-dropdown dropdown-user dropdown">
                        <a
                          class="p-0 nav-link dropdown-toggle hide-arrow"
                          href="javascript:void(0);"
                          data-bs-toggle="dropdown">
                          <div class="avatar avatar-online">
                            <img src="{{ optional(Auth::user()->biodata)->photo ? asset('uploads/profil/' . Auth::user()->biodata->photo) : asset('template/img/avatars/1.png') }}" alt class="h-px-40 w-px-40 rounded-circle object-fit-cover" />
                          </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                          <li>
                            <a class="dropdown-item" href="#">
                              <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                  <div class="avatar avatar-online">
                                    <img src="{{ optional(Auth::user()->biodata)->photo ? asset('uploads/profil/' . Auth::user()->biodata->photo) : asset('template/img/avatars/1.png') }}" alt class="h-px-40 w-px-40 rounded-circle object-fit-cover" />
                                  </div>
                                </div>
                                <div class="flex-grow-1">
                                  <h6 class="mb-0">{{ Auth::user()->nama_lengkap }}</h6>
                                  <small class="text-muted">{{ Auth::user()->email }}</small>
                                </div>
                              </div>
                            </a>
                          </li>
                          <li>
                            <div class="my-1 dropdown-divider"></div>
                          </li>
                          <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('beranda') }}">
                              <i class="bx bx-home bx-md me-3"></i><span>Beranda</span>
                            </a>
                          </li>
                          <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('profil') }}">
                              <i class="bx bx-user bx-md me-3"></i><span>Profil</span>
                            </a>
                          </li>
                          <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('keranjang.index') }}"> 
                                <i class="bx bx-cart bx-md me-3"></i><span>Keranjang Belanja</span> 
                            </a>
                          </li>
                          <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('order.index') }}"> 
                                <i class="bx bx-history bx-md me-3"></i><span>Riwayat Belanja</span> 
                            </a>
                          </li>
                          <li>
                            <div class="my-1 dropdown-divider"></div>
                          </li>
                          <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item d-flex align-items-center">
                                    <i class="bx bx-power-off bx-md me-3"></i><span>Log Out</span>
                                </button>
                            </form>
                          </li>
                        </ul>
                      </li>
                      @else
                      <li class="nav-item me-3">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">
                            Login
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            Registrasi
                        </a>
                      </li>
                      @endauth
                  @endif
                </ul>
              </div>
            </nav>
  
            <!-- / Navbar -->
  
            <!-- Content wrapper -->
            <div class="content-wrapper">
              <!-- Content -->
  
              <div class="container-xxl flex-grow-1 container-p-y">
                <div class="mb-12 row g-6" id="tentang-kami">
                    <div class="col-12">
                        <div class="card">
                          <div class="card-body d-flex align-items-center">
                            <img src="{{ asset('template/img/elements/1.jpg') }}" alt="" class="rounded">
                            <div class="ms-6">
                                <h2 class="card-title">Selamat datang di Kios33</h2>
                                <p class="card-text">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam dolorum laudantium voluptatum dolores veritatis aperiam provident, fugiat ab facere numquam consectetur assumenda aspernatur voluptates recusandae eaque eligendi unde quod vero asperiores doloremque eum fugit nesciunt illum incidunt? Laboriosam est, cupiditate accusamus dolorum asperiores quidem, a exercitationem dolores labore iste nihil!
                                </p>
                                <p class="card-text">
                                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nihil incidunt quasi recusandae quae, autem et nesciunt atque dolorem id iusto consectetur obcaecati sed itaque animi voluptas ea, labore ex reiciendis dolore! Eum voluptatem officia voluptatibus?
                                </p>
                                <a href="#produk" class="btn btn-outline-primary">Lihat produk</a>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>

                <div class="mb-10 row" id="produk">
                    <div class="text-center d-flex flex-column justify-content-center">
                        <h4>Produk</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Non, porro. Commodi optio id ipsa suscipit hic debitis temporibus a nisi.</p>
                    </div>
                    <div class="flex-wrap gap-8 d-flex justify-content-center">
                        @foreach ($produks as $produk)
                        <div class="col-3">
                            <div class="card h-100">
                                <div id="carousel-{{ $produk->id }}" class="carousel slide" data-bs-ride="carousel" style="overflow: hidden;">
                                    <div class="carousel-inner">
                                        @foreach (json_decode($produk->gambar) as $index => $gam)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" style="height: 350px;">
                                            <img src="{{ asset('/produks/'.$gam) }}" alt="Gambar Produk" class="d-block card-img-top" style="height: 350px; width: 100%; object-fit: cover;">
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
                            <div class="card-body">
                                <h5 class="card-title">{{ $produk->nama_produk }}</h5>
                                <h6 class="card-subtitle">Rp {{ number_format($produk->harga, 0, ',', '.') }}/{{ $produk->satuan }}</h6>
                                <p class="card-text">
                                    {{ implode(' ', array_slice(explode(' ', $produk->deskripsi), 0, 8)) }}{{ str_word_count($produk->deskripsi) > 8 ? '...' : '' }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <form action="{{ route('keranjang.tambah', $produk->id) }}" method="POST" class="d-inline">
                                      @csrf
                                      <button type="submit" class="btn btn-primary">Keranjang</button>
                                    </form>
                                    <button type="button" class="btn btn-outline-primary">
                                        Lihat detail
                                    </button>
                                </div>
                            </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="row" id="kontak-kami">
                    <div class="text-center d-flex flex-column justify-content-center">
                        <h4>Kontak Kami</h4>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Non, porro. Commodi optio id ipsa suscipit hic debitis temporibus a nisi.</p>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.928533310543!2d107.26632959999999!3d-6.273128!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6983675faffd97%3A0x992b769a76054345!2sKios%20Pupuk%20H%20Rakim!5e0!3m2!1sid!2sid!4v1734888274409!5m2!1sid!2sid" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="rounded h-px-300 w-100"></iframe>
                                    </div>
                                    <div class="mt-10 col-12">
                                        <div class="row">
                                            <div class="col-8">
                                                <h5>Kios33</h5>
                                                <P>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Neque dolore aut, aspernatur qui consequatur impedit aperiam accusantium expedita esse tempore at assumenda praesentium eligendi alias tenetur, nisi, recusandae commodi possimus? Accusantium maiores tempora eaque aspernatur ducimus distinctio odit laborum dignissimos. Enim nesciunt praesentium incidunt saepe vel, dolorem optio minus sint.</P>
                                            </div>
                                            <div class="col-2">
                                                <h5>Halaman</h5>
                                                <div class="row g-2">
                                                    <a href="" class="nav-item text-dark">Tentang Kami</a>
                                                    <a href="" class="nav-item text-dark">Produk</a>
                                                    <a href="" class="nav-item text-dark">Kontak Kami</a>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <h5>Sosial Media</h5>
                                                <div class="row g-2">
                                                    <button type="button" class="btn btn-icon me-2 btn-primary">
                                                        <span class="tf-icons bx bxl-instagram bx-22px"></span>
                                                    </button>
                                                    <button type="button" class="btn btn-icon me-2 btn-success">
                                                        <span class="tf-icons bx bxl-whatsapp bx-22px"></span>
                                                    </button>
                                                    <button type="button" class="btn btn-icon me-2 btn-danger">
                                                        <span class="tf-icons bx bxl-youtube bx-22px"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
              <!-- / Content -->
  
              <!-- Footer -->
              <footer class="content-footer footer bg-footer-theme">
                <div class="container-xxl">
                  <div
                    class="py-4 footer-container d-flex align-items-center justify-content-center flex-md-row flex-column">
                    <div class="text-body">
                      ©
                      <script>
                        document.write(new Date().getFullYear());
                      </script>
                      , made with 😁 by
                      <a href="https://themeselection.com" target="_blank" class="footer-link">Akbar Maulana</a>
                    </div>
                  </div>
                </div>
              </footer>
              <!-- / Footer -->
  
              <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
          </div>
          <!-- / Layout page -->
        </div>
      </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="{{ asset('template/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('template/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('template/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('template/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('template/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('template/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('template/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('template/js/dashboards-analytics.js') }}"></script>

    <!-- Place this tag before closing body tag for github widget button. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
