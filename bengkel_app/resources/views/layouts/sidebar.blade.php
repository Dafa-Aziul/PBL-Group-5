<div class="sidebar border border-right col-md-3 col-lg-2 p-0 ">
    <div class="offcanvas-md offcanvas-end " tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">Company name</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
            <ul class="nav nav-pills item-bar flex-column px-3">
            <ul class="nav flex-column">
                <li class="nav-item" class="">
                    <a href="/dashboard" class="nav-link @yield('navDashboard')"  aria-current="page">
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/user" class="nav-link @yield('navUser')"  aria-current="page">
                        Manajemen User
                    </a>
                    </li>
                <li class="nav-item" class="">
                    <a href="#" class="nav-link @yield('navManajementAbsensi')"  aria-current="page">
                        Manajemen Absensi
                    </a>
                </li>
                <li class="nav-item" class="">
                    <a href="#" class="nav-link @yield('navKaryawan')"  aria-current="page">
                        Kelola Karyawan
                    </a>
                </li>
                <li class="nav-item" class="">
                    <a href="#" class="nav-link @yield('navTransaksi')"  aria-current="page">
                        Kelola Transaksi
                    </a>
                </li>
                <li class="nav-item" class="">
                    <a href="/data-pelanggan" class="nav-link @yield('navPelanggan')"  aria-current="page">
                    Kelola Data Pelanggan
                    </a>
                </li>
                <li class="nav-item" class="">
                    <a href="/jenis-kendaraan" class="nav-link @yield('navKendaraan')"  aria-current="page">
                    Kelola Jenis Kendaraan
                    </a>
                </li>
                <li class="nav-item" class="">
                    <a href="#" class="nav-link @yield('navSukuCadang')"  aria-current="page">
                    Manajemen Suku Cadang
                    </a>
                </li>
                <li class="nav-item" class="">
                    <a href="#" class="nav-link @yield('navLayanan')"  aria-current="page">
                    Kelola Jenis Layanan Service
                    </a>
                </li>
                <li class="nav-item" class="">
                    <a href="#" class="nav-link @yield('navKonten')"  aria-current="page">
                    Manajemen Konten
                    </a>
                </li>
            </ul>
        </div>
    </div>
  </div>

  