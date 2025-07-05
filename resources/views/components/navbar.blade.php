<nav class="sb-topnav navbar navbar-expand navbar-light">

    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3 d-flex align-items-center gap-2" href="{{ route('dashboard') }}" wire:navigate>
        <img src="/images/kopcv.jpg" width="28" alt="Logo CV Razka Pratama">
        <span class="fw-semibold fs-6 d-none d-sm-inline">CV. Razka Pratama</span>
    </a>
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 ms-2 me-4 me-lg-0" style="font-size: 1.1rem;"
        id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                aria-describedby="btnNavbarSearch" />
            <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
        </div>
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4 d-flex align-items-center">
        <div class="d-flex flex-column d-none mx-2 d-sm-block text-end" style="line-height: 1.2;">
            <div class="small fw-bold" style="color: #09005d;">{{ auth()->user()->name }}</div>
            <div class="small text-muted">{{ auth()->user()->email }}</div>
        </div>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">

                <img src="{{ auth()->user()->profile_photo ? asset('storage/images/profile/' . auth()->user()->profile_photo) : asset('images/user/default.jpg') }}"
                    alt="Foto Karyawan" height="35" class="rounded-circle">

            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li>
                    <div class="d-flex flex-column d-sm-none px-3 mt-2">
                        <div class="small fw-bold" style="color: #09005d;">{{ auth()->user()->name }}</div>
                        <div class="small text-muted">{{ auth()->user()->email }}</div>
                    </div>
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.show') }}" wire:navigate>
                        <i class="fas fa-user p-2"></i>
                        <span class="ms-2">Profile</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.password') }}"
                        wire:navigate>
                        <i class="fas fa-key p-2"></i>
                        <span class="ms-2">Ganti Password</span>
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item d-flex align-items-center">
                            <i class="fas fa-sign-out-alt p-2"></i><span class="ms-2">Logout</span>
                        </button>
                    </form>
                </li>


            </ul>
        </li>
    </ul>
</nav>
