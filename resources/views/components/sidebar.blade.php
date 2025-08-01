<nav class="sb-sidenav accordion sb-sidenav" id="sidenavAccordion" data-navigate-once>
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Menu</div>
            <x-nav-link wire:current.exact href="{{ route('dashboard') }}" icon="fas fa-tachometer-alt p-2" class="mb-1">Dashboard
            </x-nav-link>

            <a class="nav-link d-flex align-items-center collapsed @if (request()->routeIs('absensi.view') || request()->routeIs('absensi.rekap') || request()->routeIs('absensi.read')) active @endif" href="#" data-bs-toggle="collapse"
                data-bs-target="#collapseAbsensi" aria-expanded="false" aria-controls="collapseLayouts"
                >
                <i class="fa-solid fa-person-chalkboard p-2"></i>
                <span class="ml-2">Absensi</span>
                <div class="sb-sidenav-collapse-arrow me-2"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse mt-1" id="collapseAbsensi" aria-labelledby="headingOne"
                data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    @can('akses-karyawan')
                    <x-nav-link wire:current.exact href="{{ route('absensi.view') }}"
                        icon="fa-solid fa-clipboard-user p-2">absen</x-nav-link>
                    @endcan
                    @can('akses-admin-owner')
                    <x-nav-link wire:current.exact href="{{ route('absensi.rekap') }}"
                        icon="fa-solid fa-book-open-reader p-2">Rekap Absen</x-nav-link>
                    @endcan
                    @can('owner')
                    <x-nav-link wire:current.exact href="{{ route('absensi.read') }}" icon="fa-solid fa-table-list p-2">
                        Absensi Hari Ini</x-nav-link>
                    @endcan
                </nav>
            </div>
            @can('akses-admin-owner')
            <x-nav-link wire:current.exact href="{{ route('user.view') }}" icon="fas fa-solid fa-user p-2">User
            </x-nav-link>

            <x-nav-link wire:current.exact href="{{ route('karyawan.view') }}" icon="fas fa-solid fa-id-badge p-2">
                Karyawan</x-nav-link>
            @endcan

            @can('admin')
            <x-nav-link wire:current.exact href="{{ route('jenis_kendaraan.view') }}" icon="fas fa-solid fa-car p-2">
                Jenis Kendaraan</x-nav-link>
            @endcan

            @can('akses-admin-owner')
            <x-nav-link wire:current.exact href="{{ route('pelanggan.view') }}" icon="fas fa-users  p-2" class="mb-1">Pelanggan
            </x-nav-link>
            @endcan
            <a class="nav-link d-flex align-items-center collapsed @if (request()->routeIs('transaksi.view') || request()->routeIs('penjualan.view') || request()->routeIs('service.view')) active @endif" href="#" data-bs-toggle="collapse"
                data-bs-target="#collapseTransaksi" aria-expanded="false" aria-controls="collapseLayouts"
                wire:current.exact>
                <i class="fas fa-receipt p-2"></i>
                <span class="ml-2">Transaksi</span>
                <div class="sb-sidenav-collapse-arrow me-2"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse mt-1" id="collapseTransaksi" aria-labelledby="headingOne"
                data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    @can('akses-admin-owner')
                    <x-nav-link wire:current.exact href="{{ route('transaksi.view') }}"
                        icon="fa-solid fa-money-bill-transfer p-2">Aktifitas Transaksi</x-nav-link>
                    <x-nav-link wire:current.exact href="{{ route('penjualan.view') }}" icon="fas fa-shopping-cart p-2">
                        Penjualan</x-nav-link>

                    @endcan
                    @can('akses-internal')
                    <x-nav-link wire:current.exact href="{{ route('service.view') }}" icon="fas fa-tools p-2">Service
                    </x-nav-link>
                    @endcan
                </nav>
            </div>

            @can('admin')

            <x-nav-link wire:current.exact href="{{ route('jasa.view') }}" icon="fa-solid fa-briefcase p-2">Jasa
            </x-nav-link>

            <x-nav-link wire:current.exact href="{{ route('sparepart.view') }}" icon="fa-solid fa-boxes-stacked p-2 ">
                Sparepart</x-nav-link>

            <x-nav-link wire:current.exact href="{{ route('konten.view') }}" icon="fa-solid fa-newspaper p-2 ">Konten
            </x-nav-link>
            @endcan
        </div>
    </div>
</nav>
