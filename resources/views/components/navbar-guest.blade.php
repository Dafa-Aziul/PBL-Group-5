<div class="container-fluid position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
        <a href="" class="navbar-brand p-0">
            <h1 class="text-primary"><i class="fas fa-tools me-3"></i>CV. Razka Pratama</h1>
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
                    class="btn btn-primary rounded-pill py-2 px-4 my-3 my-lg-0 flex-shrink-0" >dashboard</a>
                @else
                <a href="{{ route('login') }}" class="btn btn-primary rounded-pill py-2 px-4 my-3 my-lg-0 flex-shrink-0"
                    >Login</a>

                @endauth
            @endif
        </div>
    </nav>

    <!-- Carousel Start -->
    <div class="header-carousel owl-carousel">
        <div class="header-carousel-item">
            <img src="{{ asset('images/asset/bengkel-1.jpg') }}" class="img-fluid w-100" alt="Bengkel Razka Pratama">
            <div class="carousel-caption">
                <div class="container">
                    <div class="row gy-0 gx-5">
                        <div class="col-lg-0 col-xl-5"></div>
                        <div class="col-xl-7 animated fadeInLeft">
                            <div class="text-sm-center text-md-end">
                                <h4 class="text-primary text-uppercase fw-bold mb-4">Selamat Datang di</h4>
                                <h1 class="display-4 text-uppercase text-white mb-4">CV. Razka Pratama</h1>
                                <p class="mb-5 fs-5">Bengkel profesional untuk truk dan mobil dengan layanan lengkap
                                    dan berkualitas. Percayakan perawatan kendaraan Anda kepada ahli kami.
                                </p>
                                <div class="d-flex justify-content-center justify-content-md-end flex-shrink-0 mb-4">
                                    <a class="btn btn-light rounded-pill py-3 px-4 px-md-5 me-2" href="#"><i
                                            class="fas fa-play-circle me-2"></i> Video Profil</a>
                                    <a class="btn btn-primary rounded-pill py-3 px-4 px-md-5 ms-2" href="#">Layanan
                                        Kami</a>
                                </div>
                                <div class="d-flex align-items-center justify-content-center justify-content-md-end">
                                    <h2 class="text-white me-2">Follow Us:</h2>
                                    <div class="d-flex justify-content-end ms-2">
                                        <a class="btn btn-md-square btn-light rounded-circle me-2" href=""><i
                                                class="fab fa-facebook-f"></i></a>
                                        <a class="btn btn-md-square btn-light rounded-circle mx-2" href=""><i
                                                class="fab fa-twitter"></i></a>
                                        <a class="btn btn-md-square btn-light rounded-circle mx-2" href=""><i
                                                class="fab fa-instagram"></i></a>
                                        <a class="btn btn-md-square btn-light rounded-circle ms-2" href=""><i
                                                class="fab fa-linkedin-in"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-carousel-item">
            <img src="{{ asset('images/asset/bengkel-2.jpg') }}" class="img-fluid w-100" alt="Layanan Bengkel">
            <div class="carousel-caption">
                <div class="container">
                    <div class="row g-5">
                        <div class="col-12 animated fadeInUp">
                            <div class="text-center">
                                <h4 class="text-primary text-uppercase fw-bold mb-4">Layanan Unggulan</h4>
                                <h1 class="display-4 text-uppercase text-white mb-4">Service Berkualitas untuk
                                    Kendaraan Anda</h1>
                                <p class="mb-5 fs-5">Dengan teknisi bersertifikat dan peralatan modern, kami
                                    memberikan solusi terbaik untuk masalah kendaraan Anda.
                                </p>
                                <!-- <div class="d-flex justify-content-center flex-shrink-0 mb-4">
                                            <a class="btn btn-light rounded-pill py-3 px-4 px-md-5 me-2" href="#"><i class="fas fa-play-circle me-2"></i> Proses Kerja</a>
                                            <a class="btn btn-primary rounded-pill py-3 px-4 px-md-5 ms-2" href="#">Booking Sekarang</a>
                                        </div> -->
                                <div class="d-flex align-items-center justify-content-center">
                                    <h2 class="text-white me-2">Follow Us:</h2>
                                    <div class="d-flex justify-content-end ms-2">
                                        <a class="btn btn-md-square btn-light rounded-circle me-2" href=""><i
                                                class="fab fa-facebook-f"></i></a>
                                        <a class="btn btn-md-square btn-light rounded-circle mx-2" href=""><i
                                                class="fab fa-twitter"></i></a>
                                        <a class="btn btn-md-square btn-light rounded-circle mx-2" href=""><i
                                                class="fab fa-instagram"></i></a>
                                        <a class="btn btn-md-square btn-light rounded-circle ms-2" href=""><i
                                                class="fab fa-linkedin-in"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->
</div>