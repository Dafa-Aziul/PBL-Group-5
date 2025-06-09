<div class="container-fluid position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
        <a href="" class="navbar-brand d-flex align-items-center p-0">
            <img src="/images/kopcv.jpg" alt="logocv" style="height: 30px; width: auto; margin-right: 8px" />
            <h5 class="mb-0 text-primary" style="font-size: 14px">
                CV. Razka Pratama
            </h5>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="#" class="nav-item nav-link active">Beranda</a>
                <a href="#" class="nav-item nav-link">Tentang Kami</a>
                <a href="#" class="nav-item nav-link">Layanan</a>
                <a href="#" class="nav-item nav-link">Artikel</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link" data-bs-toggle="dropdown">
                        <span class="dropdown-toggle">Halaman</span>
                    </a>
                    <div class="dropdown-menu m-0">
                        <a href="#" class="dropdown-item">Fasilitas Kami</a>
                        <a href="#" class="dropdown-item">Tim Kami</a>
                        <a href="#" class="dropdown-item">Testimonial</a>
                        <a href="#" class="dropdown-item">Penawaran</a>
                        <a href="#" class="dropdown-item">FAQ</a>
                        <a href="#" class="dropdown-item">Lacak Service</a>
                    </div>
                </div>
                <a href="#" class="nav-item nav-link">Hubungi Kami</a>
            </div>
            @if (Route::has('login'))
            @auth
            <a href="{{ route('dashboard') }}"
                class="btn btn-primary rounded-pill py-2 px-4 my-3 my-lg-0 flex-shrink-0">dashboard</a>
            @else
            <a href="{{ route('login') }}"
                class="btn btn-primary rounded-pill py-2 px-4 my-3 my-lg-0 flex-shrink-0">Login</a>

            @endauth
            @endif
        </div>
    </nav>

    <!-- Carousel Start -->
    {{-- <div class="card-carousel">
        <div class="header-carousel owl-carousel">
            <div class="header-carousel-item">
                <img src="{{ asset('images/asset/bengkel-1.jpg') }}" alt="Bengkel Razka Pratama" />
                <div class="carousel-caption d-flex align-items-center justify-content-center">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-xl-10 text-center animated fadeInLeft">
                                <h1 class="display-4 text-uppercase text-white mb-4">
                                    CV. Razka Pratama
                                </h1>
                                <p class="mb-5 fs-5 text-white">
                                    Bengkel profesional untuk truk dan mobil dengan layanan
                                    lengkap dan berkualitas. Percayakan perawatan kendaraan
                                    Anda kepada ahli kami.
                                </p>
                                <div class="d-flex justify-content-center mb-4">
                                    <a class="btn btn-light rounded-pill py-3 px-4 px-md-5 me-2" href="#">
                                        <i class="fas fa-play-circle me-2"></i> Lacak Service
                                    </a>
                                    <a class="btn btn-primary rounded-pill py-3 px-4 px-md-5 ms-2" href="#">
                                        Layanan Kami
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-carousel-item">
                <img src="{{ asset('images/asset/bengkel-2.jpg') }}" class="img-fluid w-100" alt="Layanan Bengkel" />
                <div class="carousel-caption d-flex align-items-center justify-content-center">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-xl-10 animated fadeInUp text-center">
                                <h1 class="display-4 text-uppercase text-white mb-4">
                                    Service Berkualitas untuk Kendaraan Anda
                                </h1>
                                <p class="mb-5 fs-5 text-white">
                                    Dengan teknisi bersertifikat dan peralatan modern, kami
                                    memberikan solusi terbaik untuk masalah kendaraan Anda.
                                </p>
                                <!--
        <div class="d-flex justify-content-center flex-shrink-0 mb-4">
          <a class="btn btn-light rounded-pill py-3 px-4 px-md-5 me-2" href="#"><i class="fas fa-play-circle me-2"></i> Proses Kerja</a>
          <a class="btn btn-primary rounded-pill py-3 px-4 px-md-5 ms-2" href="#">Booking Sekarang</a>
        </div>
        -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Carousel End -->
</div>
