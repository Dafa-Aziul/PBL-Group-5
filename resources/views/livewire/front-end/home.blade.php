<div>
    <!-- Carousel Start -->
    <div class="card-carousel">
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
                                <div class="d-flex justify-content-center mb-4 mobile-btn-wrapper ">
                                    <a class="btn btn-light rounded-pill py-3 px-4 px-md-5 me-2 btn-custom-mobile"
                                        href="{{ route('lacakService') }}">
                                        <i class="fas fa-play-circle me-2"></i> Lacak Service
                                    </a>
                                    <a class="btn btn-primary rounded-pill py-3 px-4 px-md-5 ms-2 btn-custom-mobile"
                                        href="{{ route('layanan') }}">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->

    <!-- Services Start -->
    <div class="container-fluid service bg-light py-5">
        <div class="container py-5">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h4 class="text-primary fw-semibold">Layanan Kami</h4>
                <h1 class="display-5 fw-bold mb-3">Layanan Profesional untuk Kendaraan Anda</h1>
                <p class="text-muted">Kami menyediakan berbagai layanan perawatan dan perbaikan kendaraan dengan standar
                    tinggi. Setiap kendaraan akan mendapatkan perhatian penuh dari tim ahli kami.</p>
            </div>

            <div class="row g-4">
                <!-- Service Card 1 -->
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="card h-100 shadow-sm border-0 service-card">
                        <img src="{{ asset('images/asset/layanan6.jpg') }}" class="card-img-top rounded-top img-fluid"
                            style="height: 250px; object-fit: cover;" alt="Service Berkala">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-semibold">Service Berkala</h5>
                            <p class="card-text text-muted flex-grow-1">Perawatan rutin untuk menjaga performa kendaraan
                                Anda tetap optimal sesuai rekomendasi pabrikan.</p>
                            <a href="/layanan"
                                class="btn btn-outline-primary rounded-pill mt-3 align-self-start">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <!-- Service Card 2 -->
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="card h-100 shadow-sm border-0 service-card">
                        <img src="{{ asset('images/asset/layanan8.jpg') }}" class="card-img-top rounded-top img-fluid"
                            style="height: 250px; object-fit: cover;" alt="Perbaikan Mesin">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-semibold">Perbaikan Mesin</h5>
                            <p class="card-text text-muted flex-grow-1">Diagnosis dan perbaikan masalah mesin secara
                                komprehensif oleh teknisi ahli kami.</p>
                            <a href="/layanan"
                                class="btn btn-outline-primary rounded-pill mt-3 align-self-start">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <!-- Service Card 3 -->
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.6s">
                    <div class="card h-100 shadow-sm border-0 service-card">
                        <img src="{{ asset('images/asset/layananan3.jpg') }}" class="card-img-top rounded-top img-fluid"
                            style="height: 250px; object-fit: cover;" alt="Perbaikan Transmisi">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-semibold">Perbaikan Transmisi</h5>
                            <p class="card-text text-muted flex-grow-1">Layanan perbaikan dan perawatan sistem transmisi
                                manual maupun otomatis.</p>
                            <a href="/layanan"
                                class="btn btn-outline-primary rounded-pill mt-3 align-self-start">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <!-- Service Card 4 -->
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="card h-100 shadow-sm border-0 service-card">
                        <img src="{{ asset('images/asset/layanana1.jpg') }}" class="card-img-top rounded-top img-fluid"
                            style="height: 250px; object-fit: cover;" alt="Kelistrikan">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-semibold">Sistem Kelistrikan</h5>
                            <p class="card-text text-muted flex-grow-1">Perbaikan dan perawatan sistem kelistrikan
                                kendaraan dengan alat diagnostik modern.</p>
                            <a href="/layanan"
                                class="btn btn-outline-primary rounded-pill mt-3 align-self-start">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <!-- Service Card 5 -->
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="card h-100 shadow-sm border-0 service-card">
                        <img src="{{ asset('images/asset/layanan7.jpg') }}" class="card-img-top rounded-top img-fluid"
                            style="height: 250px; object-fit: cover;" alt="Body Repair">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-semibold">Body Repair & Cat</h5>
                            <p class="card-text text-muted flex-grow-1">Perbaikan bodi kendaraan dan pengecatan ulang
                                dengan hasil sempurna.</p>
                            <a href="/layanan"
                                class="btn btn-outline-primary rounded-pill mt-3 align-self-start">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <!-- Service Card 6 -->
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.6s">
                    <div class="card h-100 shadow-sm border-0 service-card">
                        <img src="{{ asset('images/asset/layanan9.jpg') }}" class="card-img-top rounded-top img-fluid"
                            style="height: 250px; object-fit: cover;" alt="Service Truk">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-semibold">Layanan Khusus Truk</h5>
                            <p class="card-text text-muted flex-grow-1">Spesialis perawatan dan perbaikan untuk berbagai
                                jenis truk dengan fasilitas khusus.</p>
                            <a href="/layanan"
                                class="btn btn-outline-primary rounded-pill mt-3 align-self-start">Selengkapnya</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Services End -->

    <!-- Features Start -->
    <div class="container-fluid feature feature-hover py-5 bg-light">
        <div class="container py-5">
            <div class="text-center mx-auto wow fadeInUp mb-5" data-wow-delay="0.2s" style="max-width: 800px;">
                <h4 class="text-primary">Keunggulan Kami</h4>
                <h1 class="display-5 fw-bold mb-3">Mengapa Pelanggan Memilih Kami</h1>
                <p class="text-muted">Kami berkomitmen memberikan pengalaman service terbaik dengan berbagai keunggulan
                    yang tidak Anda temukan di bengkel lain.</p>
            </div>

            <div class="row g-4">
                <!-- Item -->
                <div class="col-md-6 col-xl-3 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="bg-white rounded shadow-sm p-4 h-100 text-center feature-hover">
                        <div class="mb-3">
                            <i class="fas fa-clock fa-2x text-primary"></i>
                        </div>
                        <h5 class="fw-semibold mb-2">Layanan Cepat</h5>
                        <p class="text-muted">Proses service efisien tanpa mengorbankan kualitas pekerjaan.</p>
                        <a href="/tentang-kami"
                            class="btn btn-outline-primary rounded-pill px-4 py-2 mt-3">Selengkapnya</a>
                    </div>
                </div>

                <!-- Item -->
                <div class="col-md-6 col-xl-3 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="bg-white rounded shadow-sm p-4 h-100 text-center feature-hover">
                        <div class="mb-3">
                            <i class="fas fa-shield-alt fa-2x text-primary"></i>
                        </div>
                        <h5 class="fw-semibold mb-2">Garansi Resmi</h5>
                        <p class="text-muted">Pekerjaan kami dijamin dengan garansi resmi yang memberi ketenangan.</p>
                        <a href="/tentang-kami"
                            class="btn btn-outline-primary rounded-pill px-4 py-2 mt-3">Selengkapnya</a>
                    </div>
                </div>

                <!-- Item -->
                <div class="col-md-6 col-xl-3 wow fadeInUp" data-wow-delay="0.6s">
                    <div class="bg-white rounded shadow-sm p-4 h-100 text-center feature-hover">
                        <div class="mb-3">
                            <i class="fas fa-dollar-sign fa-2x text-primary"></i>
                        </div>
                        <h5 class="fw-semibold mb-2">Harga Kompetitif</h5>
                        <p class="text-muted">Harga terjangkau & transparan tanpa biaya tersembunyi.</p>
                        <a href="/tentang-kami"
                            class="btn btn-outline-primary rounded-pill px-4 py-2 mt-3">Selengkapnya</a>
                    </div>
                </div>

                <!-- Item -->
                <div class="col-md-6 col-xl-3 wow fadeInUp" data-wow-delay="0.8s">
                    <div class="bg-white rounded shadow-sm p-4 h-100 text-center feature-hover">
                        <div class="mb-3">
                            <i class="fas fa-mobile-alt fa-2x text-primary"></i>
                        </div>
                        <h5 class="fw-semibold mb-2">Lacak Service</h5>
                        <p class="text-muted">Pantau progres kendaraan Anda secara real-time dari ponsel.</p>
                        <a href="/tentang-kami"
                            class="btn btn-outline-primary rounded-pill px-4 py-2 mt-3">Selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- About Start -->
    <div class="container-fluid about py-5 bg-light">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <!-- Kiri: Teks -->
                <div class="col-xl-7 wow fadeInLeft" data-wow-delay="0.2s">
                    <h4 class="text-primary fw-semibold">Tentang Kami</h4>
                    <h1 class="display-5 fw-bold mb-4">CV. Razka Pratama - Bengkel Profesional</h1>
                    <p class="mb-4 text-muted">
                        Dengan pengalaman dalam industri otomotif, CV. Razka Pratama telah menjadi
                        pilihan utama untuk perawatan dan perbaikan truk serta mobil. Kami berkomitmen memberikan
                        layanan terbaik dengan standar tinggi.
                    </p>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start gap-3">
                                <i class="fas fa-tools fa-2x text-primary"></i>
                                <div>
                                    <h6 class="fw-semibold mb-1">Teknisi Ahli</h6>
                                    <p class="text-muted mb-0">Tim kami bersertifikat dan berpengalaman.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start gap-3">
                                <i class="fas fa-car fa-2x text-primary"></i>
                                <div>
                                    <h6 class="fw-semibold mb-1">Fasilitas Modern</h6>
                                    <p class="text-muted mb-0">Peralatan terkini untuk diagnosis dan servis.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start gap-3">
                                <i class="fas fa-phone-alt fa-2x text-primary"></i>
                                <div>
                                    <h6 class="fw-semibold mb-1">Hubungi Kami</h6>
                                    <p class="mb-0 text-dark fs-6">0813-6334-8020 / 0811-6608-020</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start gap-3">
                                <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                                <div>
                                    <h6 class="fw-semibold mb-1">Lokasi Kami</h6>
                                    <p class="mb-0 text-dark fs-6">Jl. Rambutan, No.8, RT01/RW06, Koto Tangah, Padang
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Gambar -->
                <div class="col-xl-5 wow fadeInRight" data-wow-delay="0.2s">
                    <div class="position-relative text-center">
                        <img src="{{ asset('images/asset/about-bengkel.jpg') }}"
                            class="img-fluid rounded-circle shadow-lg"
                            style="width: 350px; height: 350px; object-fit: cover; border: 5px solid #210C60;"
                            alt="Bengkel Razka Pratama">
                        <div class="mt-4">
                            <a href="/tentang-kami" class="btn btn-primary rounded-pill px-4 py-2">Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- About End -->

    <!-- Blog Start -->


    <div class="container-fluid blog py-5">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h4 class="text-primary">Artikel & Tips</h4>
                <h1 class="display-5 mb-4">Informasi Terbaru Tentang Perawatan Kendaraan</h1>
                <p class="mb-0">Temukan berbagai artikel dan tips bermanfaat tentang perawatan kendaraan dari tim ahli
                    kami. Dapatkan informasi terbaru seputar otomotif untuk menjaga performa kendaraan Anda tetap
                    optimal.
                </p>
            </div>
            <div class="owl-carousel blog-carousel wow fadeInUp" data-wow-delay="0.2s">
                @foreach ($kontens as $konten)
                <div class="blog-item p-4 shadow-sm rounded bg-white">
                    <div class="blog-img mb-4 position-relative">
                        {{-- Gambar atau Video konten --}}
                        @php
                            $src = $konten->video_konten
                                ? asset('storage/konten/video/' . $konten->video_konten)
                                : ($konten->foto_konten
                                    ? asset('storage/konten/gambar/' . $konten->foto_konten)
                                    : asset('images/asset/default-konten.jpg'));
                        @endphp

                        @if ($konten->video_konten)
                        <video class="img-fluid w-100 rounded" style="object-fit: cover; max-height: 250px;" controls>
                            <source src="{{ $src }}" type="video/mp4">
                            Browser kamu tidak mendukung tag video.
                        </video>
                        @else
                        <img src="{{ $src }}" class="img-fluid w-100 rounded" alt="{{ $konten->judul ?? 'Konten' }}"
                            style="object-fit: cover; max-height: 250px;">
                        @endif

                        {{-- Label kategori --}}
                        <div class="blog-title position-absolute top-0 start-0 m-3">
                            <span class="btn btn-primary text-white px-3" href="{{ route('berita', $konten->id) }}"
                                wire:navigate>
                                {{ ucfirst($konten->kategori) }}
                            </span>
                        </div>
                    </div>


                    {{-- Judul konten --}}
                    <a href="{{ route('berita', $konten->id) }}"
                        class="h5 d-inline-block mb-2 text-dark text-decoration-none" wire:navigate>
                        {{ $konten->judul }}
                    </a>

                    {{-- Ringkasan isi --}}
                    <p class="text-muted mb-4">
                        {{ \Illuminate\Support\Str::limit(strip_tags($konten->isi), 120, '...') }}
                    </p>

                    {{-- Info penulis --}}
                    <div class="d-flex align-items-center border-top pt-3">
                        <img src="{{ $konten->penulis && $konten->penulis->user && $konten->penulis->user->profile_photo
                    ? asset('storage/images/profile/' . $konten->penulis->user->profile_photo)
                    : asset('images/user/default.jpg') }}" class="img-fluid rounded-circle"
                            style="width: 50px; height: 50px; object-fit: cover;"
                            alt="{{ $konten->penulis->nama ?? 'Penulis' }}">

                        <div class="ms-3">
                            <h6 class="mb-0">{{ $konten->penulis->nama ?? 'Admin' }}</h6>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($konten->created_at)->translatedFormat('d F Y') }}
                            </small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Blog End -->

</div>
@push('scripts')
<script>
    // Fungsi untuk menginisialisasi carousel
        function initCarousels() {
            // Hancurkan carousel yang sudah ada jika ada
            $('.header-carousel, .blog-carousel').each(function() {
                if ($(this).data('owl.carousel')) {
                    $(this).trigger('destroy.owl.carousel');
                    $(this).removeClass('owl-loaded owl-hidden');
                    $(this).find('.owl-stage-outer').children().unwrap();
                }
            });

            // Hero Header carousel
            $(".header-carousel").owlCarousel({
                animateOut: 'fadeOut',
                items: 1,
                margin: 0,
                stagePadding: 0,
                autoplay: true,
                smartSpeed: 500,
                dots: false,
                loop: true,
                nav: true,
                navText: [
                    '<i class="bi bi-arrow-left"></i>',
                    '<i class="bi bi-arrow-right"></i>'
                ],
            });

            // Blog carousel
            $(".blog-carousel").owlCarousel({
                autoplay: true,
                smartSpeed: 1500,
                center: false,
                dots: false,
                loop: true,
                margin: 25,
                nav: true,
                navText: [
                    '<i class="fa fa-angle-right"></i>',
                    '<i class="fa fa-angle-left"></i>'
                ],
                responsiveClass: true,
                responsive: {
                    0: { items: 1 },
                    576: { items: 1 },
                    768: { items: 2 },
                    992: { items: 2 },
                    1200: { items: 3 }
                }
            });
        }

        // Inisialisasi pertama kali saat halaman dimuat
        $(document).ready(function() {
            initCarousels();
        });

        // Livewire V3 - navigasi antar halaman (SPA behavior)
        document.addEventListener('livewire:navigated', () => {
            setTimeout(initCarousels, 100);
        });
</script>
@endpush
