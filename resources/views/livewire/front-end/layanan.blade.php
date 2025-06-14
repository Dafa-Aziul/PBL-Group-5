<div>
    {{-- <div class="card-carousel">

    </div> --}}
    <div class="container-fluid py-5" style="background-color:#373390; ">
        <div class="container" style="max-width: 900px;">
            <div class="row align-items-center">
                <!-- Kolom Teks -->
                <div class="col-md-6 text-center text-md-start mb-4 mb-md-0">
                    <h4 class="text-white display-4 mb-3 wow fadeInDown" data-wow-delay="0.1s">Layanan Kami</h4>
                    <p class="text-white mb-3">
                        Kami menyediakan berbagai layanan perawatan dan perbaikan kendaraan dengan standar tinggi
                    </p>
                    {{-- <ol
                        class="breadcrumb d-flex justify-content-center justify-content-md-start mb-0 wow fadeInDown mt-3"
                        data-wow-delay="0.3s">
                        <li class="breadcrumb-item"><a href="/" class="text-white text-info">Beranda</a></li>
                        <li class="breadcrumb-item active text-primary">Layanan</li>
                    </ol> --}}
                </div>

                <!-- Kolom Gambar -->
                <div class="col-md-6 text-center">
                    <img src="{{ asset('images/asset/illustrasi-service.png') }}" alt="Ilustrasi Layanan"
                        class="img-fluid wow fadeInUp" data-wow-delay="0.2s" style="max-height: 300px;">
                </div>
            </div>
        </div>
    </div>

    <!-- Header End -->
    <div class="container-fluid service py-5 bg-light">
        <div class="container">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h4 class="text-primary text-uppercase fw-bold">Layanan Kami</h4>
                <h1 class="display-5 fw-semibold mb-3">Layanan Profesional untuk Kendaraan Anda</h1>
                <p class="text-muted mb-0">Kami menyediakan berbagai layanan perawatan dan perbaikan kendaraan dengan
                    standar tinggi. Setiap kendaraan akan mendapatkan perhatian penuh dari teknisi berpengalaman kami.
                </p>
            </div>

            <div class="row g-4">
                <!-- Service Berkala -->
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                        <img src="{{ asset('images/asset/layanan6.jpg') }}" class="card-img-top"
                            style="height: 250px; object-fit: cover;" alt="Service Berkala">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-primary">Service Berkala</h5>
                            <p class="text-muted">Perawatan rutin berkala untuk menjaga kendaraan tetap prima sesuai
                                standar pabrikan.</p>
                            <ul class="small text-muted ps-3">
                                <li>Pemeriksaan dan penggantian oli & filter</li>
                                <li>Pengecekan sistem rem, ban, dan suspensi</li>
                                <li>Kalibrasi sistem injeksi & elektronik</li>
                                <li>Pemeriksaan aki & pengisian daya</li>
                                <li>Pembersihan throttle body</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Perbaikan Mesin -->
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                        <img src="{{ asset('images/asset/layanana1.jpg') }}" class="card-img-top"
                            style="height: 250px; object-fit: cover;" alt="Perbaikan Mesin">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-primary">Perbaikan Mesin</h5>
                            <p class="text-muted">Solusi menyeluruh untuk masalah mesin kendaraan Anda.</p>
                            <ul class="small text-muted ps-3">
                                <li>Diagnosis kerusakan dengan alat scanner</li>
                                <li>Overhaul mesin (bongkar total)</li>
                                <li>Penggantian piston, gasket, dan seal</li>
                                <li>Setting ulang sistem pembakaran</li>
                                <li>Pembersihan injektor & intake manifold</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Perbaikan Transmisi -->
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.6s">
                    <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                        <img src="{{ asset('images/asset/layananan3.jpg') }}" class="card-img-top"
                            style="height: 250px; object-fit: cover;" alt="Perbaikan Transmisi">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-primary">Perbaikan Transmisi</h5>
                            <p class="text-muted">Menangani semua jenis kerusakan pada transmisi manual dan otomatis.
                            </p>
                            <ul class="small text-muted ps-3">
                                <li>Pemeriksaan dan penggantian oli transmisi</li>
                                <li>Servis kopling, flywheel, & master clutch</li>
                                <li>Perbaikan gearbox dan synchromesh</li>
                                <li>Reset & update sistem TCU (transmission control unit)</li>
                                <li>Kalibrasi perpindahan gigi otomatis</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mt-2">
                <!-- Sistem Kelistrikan -->
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                        <img src="{{ asset('images/asset/layanan8.jpg') }}" class="card-img-top"
                            style="height: 250px; object-fit: cover;" alt="Sistem Kelistrikan">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-primary">Sistem Kelistrikan</h5>
                            <p class="text-muted">Penanganan lengkap masalah kelistrikan kendaraan dengan teknologi
                                modern.</p>
                            <ul class="small text-muted ps-3">
                                <li>Diagnosis dengan electrical scanner</li>
                                <li>Perbaikan wiring, lampu, & sensor</li>
                                <li>Servis alternator & starter</li>
                                <li>Penggantian modul ECU/ECM</li>
                                <li>Kalibrasi sistem kelistrikan elektronik</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Body Repair & Cat -->
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                        <img src="{{ asset('images/asset/layanan7.jpg') }}" class="card-img-top"
                            style="height: 250px; object-fit: cover;" alt="Body Repair">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-primary">Body Repair & Cat</h5>
                            <p class="text-muted">Restorasi bodi kendaraan dengan hasil presisi tinggi dan tampilan
                                seperti baru.</p>
                            <ul class="small text-muted ps-3">
                                <li>Perbaikan penyok & kerusakan bodi ringan/berat</li>
                                <li>Pengecatan ulang full body & panel</li>
                                <li>Proses oven & clear coat anti gores</li>
                                <li>Penyelarasan warna pabrikan</li>
                                <li>Poles & detailing akhir</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Layanan Khusus Truk -->
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.6s">
                    <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                        <img src="{{ asset('images/asset/layanan9.jpg') }}" class="card-img-top"
                            style="height: 250px; object-fit: cover;" alt="Layanan Truk">
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-primary">Layanan Khusus Truk</h5>
                            <p class="text-muted">Layanan profesional untuk berbagai jenis truk dengan kapasitas dan
                                teknisi khusus.</p>
                            <ul class="small text-muted ps-3">
                                <li>Servis mesin diesel skala besar</li>
                                <li>Perawatan sistem pengereman udara (air brake)</li>
                                <li>Balancing dan spooring roda besar</li>
                                <li>Perbaikan gardan dan transmisi heavy-duty</li>
                                <li>Perawatan sistem hidrolik dan suspensi truk</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Tambahkan baris baru untuk 3 layanan berikutnya kalau mau -->
        </div>
    </div>

    <!-- Services End -->

    <!-- Additional Services Start -->
    <div class="container-fluid py-5 bg-light">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                <h4 class="text-primary fw-semibold text-uppercase">Layanan Tambahan</h4>
                <h1 class="display-5 fw-bold mb-3">Layanan Pendukung untuk Kendaraan Anda</h1>
                <p class="text-muted">Selain layanan utama, kami juga menyediakan berbagai layanan pendukung untuk
                    memastikan kendaraan Anda selalu dalam kondisi terbaik.</p>
            </div>

            <div class="row g-4">
                <!-- Card 1 -->
                <div class="col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="card service-extra-card border-0 h-100 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div
                                class="service-icon-wrapper mb-3 mx-auto bg-primary text-white rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fas fa-oil-can fa-lg"></i>
                            </div>
                            <h5 class="card-title fw-semibold">Ganti Oli & Filter</h5>
                            <p class="card-text text-muted">Penggantian oli mesin dan filter dengan oli berkualitas
                                untuk performa optimal.</p>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="card service-extra-card border-0 h-100 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div
                                class="service-icon-wrapper mb-3 mx-auto bg-primary text-white rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fas fa-car fa-lg"></i>
                            </div>
                            <h5 class="card-title fw-semibold">Spooring & Balancing</h5>
                            <p class="card-text text-muted">Penyeimbangan roda dan penyetelan geometri roda untuk
                                kenyamanan berkendara.</p>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="0.6s">
                    <div class="card service-extra-card border-0 h-100 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div
                                class="service-icon-wrapper mb-3 mx-auto bg-primary text-white rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fas fa-car-battery fa-lg"></i>
                            </div>
                            <h5 class="card-title fw-semibold">Perbaikan Aki</h5>
                            <p class="card-text text-muted">Diagnosis dan perbaikan sistem pengisian aki serta
                                penggantian aki jika diperlukan.</p>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="0.8s">
                    <div class="card service-extra-card border-0 h-100 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div
                                class="service-icon-wrapper mb-3 mx-auto bg-primary text-white rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fas fa-tools fa-lg"></i>
                            </div>
                            <h5 class="card-title fw-semibold">Perawatan AC</h5>
                            <p class="card-text text-muted">Servis sistem AC termasuk pengisian freon dan perbaikan
                                komponen AC.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Services End -->


    <!-- Call to Action Start -->
    <div class="container-fluid py-5" style="background-color: #4D499D;">
        <div class="container py-5 text-center wow fadeInUp" data-wow-delay="0.2s">
            <h1 class="display-5 text-white mb-4">Siap Melayani Kendaraan Anda</h1>
            <p class="fs-4 text-white mb-4">Jadwalkan kunjungan Anda sekarang atau hubungi kami untuk konsultasi gratis
            </p>
            <div class="d-flex justify-content-center">
                <a class="btn btn-light rounded-pill py-3 px-5 me-3" href="/tentang-kami">Hubungi Kami</a>
                <!-- <a class="btn btn-dark rounded-pill py-3 px-5" href="#">Booking Service</a> -->
            </div>
        </div>
    </div>
    <!-- Call to Action End -->
</div>
