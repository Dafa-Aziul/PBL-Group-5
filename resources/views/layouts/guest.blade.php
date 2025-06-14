<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>CV. Razka Pratama - Bengkel Truk & Mobil Profesional</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="bengkel, service mobil, service truk, perbaikan kendaraan" name="keywords">
    <meta content="Bengkel profesional untuk truk dan mobil dengan layanan lengkap dan berkualitas" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Roboto:wght@400;500;700;900&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link rel="stylesheet" href="{{ asset('lib/animate/animate.min.css') }}"/>
    <link href="{{ asset('lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <style>
        .tracking-section {
            background-color: #f8f9fa;
            padding: 80px 0;
        }

        .tracking-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
        }

        .tracking-step {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .tracking-step.active {
            background-color: #0d6efd;
            color: white;
        }

        .tracking-step .step-number {
            width: 30px;
            height: 30px;
            background-color: #0d6efd;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-weight: bold;
        }

        .tracking-step.active .step-number {
            background-color: white;
            color: #0d6efd;
        }

        .tracking-step .step-content {
            flex: 1;
        }

        .track-status-btn {
            background-color: #0d6efd;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
            transition: all 0.3s;
        }

        .track-status-btn:hover {
            background-color: #0b5ed7;
            transform: translateY(-2px);
        }

        .service-icon {
            font-size: 2.5rem;
            color: #0d6efd;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Topbar Start -->
    {{-- <div class="container-fluid topbar bg-light px-5 d-none d-lg-block">
            <div class="row gx-0 align-items-center">
                <div class="col-lg-8 text-center text-lg-start mb-2 mb-lg-0">
                    <div class="d-flex flex-wrap">
                        <a href="#" class="text-muted small me-4"><i class="fas fa-map-marker-alt text-primary me-2"></i>Jl. Rambutan, No.8, RT01/RW06 Koto Tangah, Padang</a>
                        <a href="tel:+02112345678" class="text-muted small me-4"><i class="fas fa-phone-alt text-primary me-2"></i>0813-6334-8020 / 0811-6608-020 </a>
                        <a href="mailto:cv.razkapratama@gmail.com" class="text-muted small me-0"><i class="fas fa-envelope text-primary me-2"></i>cv.razkapratama@gmail.com</a>
                    </div>
                </div>
            </div>
        </div> --}}
    <!-- Topbar End -->

    <!-- Navbar & Hero Start -->
    <x-navbar-guest></x-navbar-guest>

    <!-- Navbar & Hero End -->
    {{ $slot }}






    <!-- Footer Start -->
    <x-footer-guest></x-footer-guest>
    {{-- <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s"> --}}
        {{-- <div class="container py-5 border-start-0 border-end-0"
            style="border: 1px solid; border-color: rgb(255, 255, 255, 0.08);">
            <div class="row g-5">
                <div class="col-md-6 col-lg-6 col-xl-4">
                    <div class="footer-item">
                        <a href="index.html" class="p-0">
                            <h4 class="text-white"><i class="fas fa-tools me-3"></i>CV. Razka Pratama</h4>
                        </a>
                        <p class="mb-4">Bengkel spesialis truk dan mobil terpercaya. Kami siap memberikan pelayanan
                            terbaik untuk kendaraan Anda.</p>
                        <div class="d-flex">
                            <a class="btn btn-primary btn-sm-square rounded-circle me-3" href="#"><i
                                    class="fab fa-facebook-f text-white"></i></a>
                            <a class="btn btn-primary btn-sm-square rounded-circle me-3" href="#"><i
                                    class="fab fa-instagram text-white"></i></a>
                            <a class="btn btn-primary btn-sm-square rounded-circle me-0" href="#"><i
                                    class="fab fa-linkedin-in text-white"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-2">
                    <div class="footer-item">
                        <h4 class="text-white mb-4">Link Cepat</h4>
                        <a href="#"><i class="fas fa-angle-right me-2"></i> Tentang Kami</a>
                        <a href="#"><i class="fas fa-angle-right me-2"></i> Layanan</a>
                        <a href="#"><i class="fas fa-angle-right me-2"></i> Booking Service</a>
                        <a href="#"><i class="fas fa-angle-right me-2"></i> Lacak Service</a>
                        <a href="#"><i class="fas fa-angle-right me-2"></i> Kontak</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item">
                        <h4 class="text-white mb-4">Bantuan</h4>
                        <a href="#"><i class="fas fa-angle-right me-2"></i> Kebijakan Privasi</a>
                        <a href="#"><i class="fas fa-angle-right me-2"></i> Syarat & Ketentuan</a>
                        <a href="#"><i class="fas fa-angle-right me-2"></i> FAQ</a>
                        <a href="#"><i class="fas fa-angle-right me-2"></i> Pusat Bantuan</a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="footer-item">
                        <h4 class="text-white mb-4">Kontak Kami</h4>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-map-marker-alt text-primary me-3"></i>
                            <p class="text-white mb-0">Jl. Rambutan, No.8, RT01/RW06 Koto Tangah, Padang</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-envelope text-primary me-3"></i>
                            <p class="text-white mb-0">cv.razkapratama@gmail.com</p>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fa fa-phone-alt text-primary me-3"></i>
                            <p class="text-white mb-0">0813-6334-8020 / 0811-6608-020</p>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    <!-- Footer End -->

    <!-- Copyright Start -->
    <x-copyright-guest></x-copyright>
    {{-- <div class="container-fluid copyright py-4">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-md-6 text-center text-md-start mb-md-0">
                    <span class="text-body text-white">© 2025 <a href="#" class="text-white border-bottom">CV. Razka
                            Pratama</a>. All rights reserved.</span>
                </div>
                <div class="col-md-6 text-center text-md-end text-white">
                    Designed by <a class="text-white border-bottom" href="https://htmlcodex.com">HTML Codex</a>,
                    modified by <strong>CV. Razka Pratama</strong>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Copyright End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary btn-lg-square rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    {{-- <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script> --}}
    <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('lib/lightbox/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>


    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
