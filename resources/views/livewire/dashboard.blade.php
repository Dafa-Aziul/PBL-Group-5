@php
use Carbon\Carbon;
Carbon::setLocale('id'); // Biar hari & bulan pakai bahasa Indonesia
@endphp

<div>
    <h1 class="mt-4" style="color: #09005d;">Selamat Datang, {{ Auth::user()->name }} 👋
        <label class="text-muted mb-4">
            {{ Carbon::now()->translatedFormat('l, d F Y') }}
        </label>
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <div class="row g-3">
        <div class="col-12 col-md-4">
            <div class="card h-100 card-hover">
                <div class="card-body">
                    <h3 class="card-title">
                        <i class="fa-solid fa-clipboard-user"></i> Absen Hari ini
                    </h3>
                    <hr class="border border-2 opacity-50">
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card h-100 card-hover">
                <div class="card-body">
                    <h3 class="card-title text-danger">
                        <i class="fa-solid fa-triangle-exclamation"></i> Sparepart Menipis
                    </h3>
                    <hr class="border border-2 opacity-50">

                    <p class="card-text">Ada <strong>5 sparepart</strong> dengan stok menipis.</p>
                    <ul class="list-group list-group-flush mt-3">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Oli Mesin
                            <span class="badge bg-danger rounded-pill">3</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Kampas Rem
                            <span class="badge bg-danger rounded-pill">2</span>
                        </li>
                    </ul>

                    <div class="text-center">
                        <a href="/admin/stok" class="btn btn-danger btn-sm mt-3">Lihat Detail</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card h-100 card-hover">
                <div class="card-body">
                    <h3 class="card-title text-success">
                        <i class="fa-solid fa-universal-access"></i> Quick Acces
                    </h3>
                    <hr class="border border-2 opacity-50">

                    <div class="mb-3">
                        <a class="btn btn-primary w-100" href="{{ route('sparepart.create') }}" wire:navigate>
                            <i class="fas fa-plus"></i>
                            <span class="ms-1">Tambah Sparepart</span>
                        </a>
                    </div>

                    <div class="mb-3">
                        <a class="btn btn-primary w-100" href="{{ route('pelanggan.create') }}" wire:navigate>
                            <i class="fas fa-plus"></i>
                            <span class="ms-1">Tambah Pelanggan</span>
                        </a>
                    </div>

                    <div class="mb-3">
                        <a class="btn btn-primary w-100" href="{{ route('karyawan.create') }}" wire:navigate>
                            <i class="fas fa-plus"></i>
                            <span class="ms-1">Tambah Karyawan</span>
                        </a>
                    </div>

                    <div class="mb-3">
                        <a class="btn btn-primary w-100" href="{{ route('jasa.create') }}" wire:navigate>
                            <i class="fas fa-plus"></i>
                            <span class="ms-1">Tambah Jasa</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row d-flex align-items-stretch my-3">
        <div class="card h-100 card-hover">
            <div class="card-body">
                <h3 class="card-title text-center">
                        <i class="fa-solid fa-chart-simple"></i> Transaksi Bulan Ini
                </h3>
                    <hr class="border border-2 opacity-50">

            </div>
        </div>
    </div>







</div>
