<?php

use \App\Livewire\Absensi\Create as AbsensiCreate;
use \App\Livewire\Absensi\Index as AbsensiIndex;
use \App\Livewire\Absensi\Read as AbsensiRead;
use \App\Livewire\Absensi\Show as AbsensiShow;
use App\Http\Controllers\AbsensiController;

//auth
use \App\Livewire\User\Create as UserCreate;
use App\Http\Controllers\auth\VerifyEmailController;

// user
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\VerifyEmail;



// jenis kendaraan

//frontend
use App\Livewire\Dashboard;
use App\Livewire\FrontEnd\About;
use App\Livewire\FrontEnd\Home;
use App\Livewire\FrontEnd\KontenDetail;
use App\Livewire\FrontEnd\Lacak;

// jasa
use App\Livewire\FrontEnd\Layanan;
use App\Livewire\Jasa\Create as JasaCreate;
use App\Livewire\Jasa\Edit as JasaEdit;
use App\Livewire\Jasa\Index as JasaIndex;

//jenis kendaraan
use App\Livewire\JenisKendaraan\Create as JenisKendaraanCreate;
use App\Livewire\JenisKendaraan\Edit as JenisKendaraanEdit;
use App\Livewire\JenisKendaraan\Index as JenisKendaraanIndex;

//karyawan
use App\Livewire\Karyawan\Create as karyawanCreate;
use App\Livewire\Karyawan\Edit as karyawanEdit;
use App\Livewire\Karyawan\Index as karyawanIndex;

//kendaraan
use App\Livewire\Kendaraan\Create as KendaraanCreate;
use App\Livewire\Kendaraan\show as KendaraanDetail;

//konten
use App\Livewire\Konten\Create as KontenCreate;
use App\Livewire\Konten\Edit as KontenEdit;
use App\Livewire\Konten\Index as KontenIndex;

//pelanggan
use App\Livewire\Pelanggan\Create as PelangganCreate;
use App\Livewire\Pelanggan\Edit as PelangganEdit;
use App\Livewire\Pelanggan\Index as PelangganIndex;
use App\Livewire\Pelanggan\Show as PelangganShow;

//penjualan
use App\Livewire\Penjualan\Create as PenjualanCreate;
use App\Livewire\Penjualan\Show as PenjualanShow;
use App\Livewire\Penjualan\Index as PenjualanIndex;


//service
use App\Livewire\Service\Create as ServiceCreate;
use App\Livewire\Service\Edit as ServiceEdit;
use App\Livewire\Service\Index as ServiceIndex;

//sparepart
use App\Livewire\Service\ServiceDetail;
use App\Livewire\Service\Show as ServiceShow;
use App\Livewire\Sparepart\Create as SparepartCreate;
use App\Livewire\Sparepart\Edit as SparepartEdit;

//transaksi
use App\Livewire\Sparepart\Index as SparepartIndex;
use App\Livewire\Sparepart\Show as SparepartShow;
use App\Livewire\Transaksi\Index as TransaksiIndex;
use App\Http\Controllers\InvoiceController;

//absensi
use App\Livewire\Transaksi\Show as TransaksiShow;
use App\Livewire\Transaksi\TambahService as TransaksiService;
use App\Livewire\User\Index as UserIndex;
use App\Livewire\User\Password;
use App\Livewire\User\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;




Route::get('/', Home::class)->name('home');
Route::get('/layanan', Layanan::class)->name('layanan');
Route::get('/tentang-kami', About::class)->name('about');
Route::get('/lacak-service', Lacak::class)->name('lacakService');
Route::get('/berita/{id}', KontenDetail::class)->name('berita');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('logout', App\Livewire\Actions\Logout::class)
        ->name('logout');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/profile', Profile::class)->name('profile.show');
    Route::get('/profile/password', Password::class)->name('profile.password');

    // Hanya admin, owner, superadmin
    Route::middleware(['role:admin,owner,superadmin'])->group(function () {
        // User
        Route::get('/user', UserIndex::class)->name('user.view');
        Route::get('/user/create', UserCreate::class)->name('user.create')->middleware('role:superadmin,admin');

        // Karyawan
        Route::prefix('karyawan')->middleware('role:superadmin,admin')->group(function () {
            Route::get('/', KaryawanIndex::class)->name('karyawan.view')->withoutMiddleware('role:superadmin,admin');
            Route::get('/create', KaryawanCreate::class)->name('karyawan.create');
            Route::get('/{id}/edit', KaryawanEdit::class)->name('karyawan.edit');
        });

        // Jenis Kendaraan
        Route::prefix('jenis_kendaraan')->middleware('role:superadmin,admin')->group(function () {
            Route::get('/', JenisKendaraanIndex::class)->name('jenis_kendaraan.view');
            Route::get('/create', JenisKendaraanCreate::class)->name('jenis_kendaraan.create');
            Route::get('/{id}/edit', JenisKendaraanEdit::class)->name('jenis_kendaraan.edit');
        });

        // Pelanggan
        Route::prefix('pelanggan')->group(function () {
            Route::get('/', PelangganIndex::class)->name('pelanggan.view');
            Route::get('/create', PelangganCreate::class)->name('pelanggan.create')->middleware('role:superadmin,admin');
            Route::get('/{id}/edit', PelangganEdit::class)->name('pelanggan.edit')->middleware('role:superadmin,admin');
            Route::get('/{id}', PelangganShow::class)->name('pelanggan.detail');
            Route::get('/{pelanggan}/kendaraan/{kendaraan}', KendaraanDetail::class)->name('kendaraan.show');
        });

        // Jasa
        Route::prefix('jasa')->middleware('role:superadmin,admin')->group(function () {
            Route::get('/', JasaIndex::class)->name('jasa.view');
            Route::get('/create', JasaCreate::class)->name('jasa.create');
            Route::get('/{id}/edit', JasaEdit::class)->name('jasa.edit');
        });

        // Sparepart
        Route::prefix('sparepart')->middleware('role:superadmin,admin,owner')->group(function () {
            Route::get('/', SparepartIndex::class)->name('sparepart.view');
            Route::get('/create', SparepartCreate::class)->name('sparepart.create')->middleware('role:superadmin,admin');
            Route::get('/{id}', SparepartShow::class)->name('sparepart.show');
            Route::get('/{id}/edit', SparepartEdit::class)->name('sparepart.edit')->middleware('role:superadmin,admin');
        });

        // Konten
        Route::prefix('konten')->middleware('role:superadmin,admin')->group(function () {
            Route::get('/', KontenIndex::class)->name('konten.view');
            Route::get('/create', KontenCreate::class)->name('konten.create');
            Route::get('/{id}/edit', KontenEdit::class)->name('konten.edit');
        });
    });

    // Absensi
    Route::prefix('absensi')->middleware('role:superadmin,admin,mekanik')->group(function () {
        Route::get('/', AbsensiIndex::class)->name('absensi.view');
        Route::get('/create/{id}/{type}', AbsensiCreate::class)->name('absensi.create');
    });
    Route::get('/absensi/lihat-absen', AbsensiRead::class)->name('absensi.read')->middleware('role:superadmin,owner,admin,mekanik');
    Route::get('/rekap-absen', AbsensiShow::class)->name('absensi.rekap')->middleware('role:superadmin,admin,owner');
    Route::get('rekap-absen/export/pdf', [AbsensiController::class, 'exportPdf'])->name('absensi.export');
    Route::get('rekap-absen/preview/pdf', [AbsensiController::class, 'showPdf'])
        ->name('absensi.preview');

    // Transaksi
    Route::prefix('transaksi')->middleware('role:superadmin,admin,owner')->group(function () {
        Route::get('/', TransaksiIndex::class)->name('transaksi.view');
        Route::get('/{id}', TransaksiShow::class)->name('transaksi.show');
        Route::get('/{id}/invoice', [InvoiceController::class, 'show'])->name('invoice.show');
        Route::get('/{id}/invoice/download', [InvoiceController::class, 'download'])->name('invoice.download');
        Route::get('/service/{id}/create', TransaksiService::class)->name('transaksi.service')->middleware('role:superadmin,admin');
    });

    // Service
    Route::prefix('service')->group(function () {
        Route::get('/', ServiceIndex::class)->name('service.view')->middleware('role:superadmin,admin,owner,mekanik');
        Route::get('/create', ServiceCreate::class)->name('service.create')->middleware('role:superadmin,admin');
        Route::get('/create/{id}/detail', ServiceDetail::class)->name('service.detail')->middleware('role:superadmin,admin');
        Route::get('/{id}', ServiceShow::class)->name('service.show')->middleware('role:superadmin,admin,owner,mekanik');
        Route::get('/{id}/edit', ServiceEdit::class)->name('service.edit')->middleware('role:superadmin,admin');
    });

    // Penjualan
    Route::prefix('penjualan')->middleware('role:superadmin,admin,owner')->group(function () {
        Route::get('/', PenjualanIndex::class)->name('penjualan.view');
        Route::get('/create', PenjualanCreate::class)->name('penjualan.create')->withoutMiddleware('role:owner');
        Route::get('/{id}', PenjualanShow::class)->name('penjualan.show');
    });
});


Route::middleware('auth')->group(function () {
    Route::get('verify-email', VerifyEmail::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
});



Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');
    // Route::get('register', Register::class)->name('register');
    Route::get('forgot-password', ForgotPassword::class)->name('password.request');
    Route::get('/reset-password/{token}/{email}', ResetPassword::class)->name('password.reset');
});
