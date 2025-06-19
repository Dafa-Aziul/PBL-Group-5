<div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
    <div class="container py-5 border-start-0 border-end-0"
        style="border: 1px solid; border-color: rgb(255, 255, 255, 0.08);">
        <div class="row g-5">
            <div class="col-md-6 col-lg-6 col-xl-4">
                <div class="footer-item">
                    <a href="{{ route('home') }}" class="p-0" wire:navigate>
                        <h4 class="text-white"><i class="fas fa-tools me-3"></i>CV. Razka Pratama</h4>
                    </a>
                    <p class="mb-4">Bengkel spesialis truk dan mobil terpercaya. Kami siap memberikan pelayanan
                        terbaik untuk kendaraan Anda.</p>
                    <div class="d-flex">
                        <a class="btn btn-sm-square rounded-circle me-3" href="#"><i
                                class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-sm-square rounded-circle me-3" href="#"><i
                                class="fab fa-instagram"></i></a>
                        <a class="btn btn-sm-square rounded-circle me-0" href="#"><i
                                class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-2">
                <div class="footer-item">
                    <h4 class="text-white mb-4">Link Cepat</h4>
                    <a href="{{ route('about') }}" wire:navigate><i class="fas fa-angle-right me-2"></i> Tentang
                        Kami</a>
                    <a href="{{ route('layanan') }}" wire:navigate><i class="fas fa-angle-right me-2"></i> Layanan</a>

                    <a href="{{ route('lacakService') }}" wire:navigate><i class="fas fa-angle-right me-2"></i> Lacak
                        Service</a>
                    <a href="{{ route('about') }}" wire:navigate><i class="fas fa-angle-right me-2"></i> Kontak</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item">
                    <h4 class="text-white mb-4">Bantuan</h4>
                    <a href="{{ route('about') }}" wire:navigate><i class="fas fa-angle-right me-2"></i> FAQ</a>
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
    </div>
</div>
