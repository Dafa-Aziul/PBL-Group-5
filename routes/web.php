<?php

use \App\Livewire\Absensi\Create as AbsensiCreate;
use \App\Livewire\Absensi\Index as AbsensiIndex;
use \App\Livewire\Absensi\Read as AbsensiRead;
use \App\Livewire\Absensi\Show as AbsensiShow;

//auth
use \App\Livewire\User\Create as UserCreate;
use App\Http\Controllers\auth\VerifyEmailController;
use App\Http\Controllers\InvoiceController;
use App\Livewire\About;
use App\Livewire\Action\Logout;

// user
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\ResetPassword;



// jenis kendaraan
use App\Livewire\Auth\VerifyEmail;
use App\Livewire\Dashboard;

// jasa
use App\Livewire\Gudang\Create as GudangCreate;
use App\Livewire\Jasa\Create as JasaCreate;
use App\Livewire\Jasa\Edit as JasaEdit;


//pelanggan
use App\Livewire\Jasa\Index as JasaIndex;
use App\Livewire\JenisKendaraan\Create as JenisKendaraanCreate;
use App\Livewire\JenisKendaraan\Edit as JenisKendaraanEdit;
use App\Livewire\JenisKendaraan\Index as JenisKendaraanIndex;

//jenis kendaraan
use App\Livewire\Karyawan\Create as karyawanCreate;
use App\Livewire\Karyawan\Edit as karyawanEdit;
use App\Livewire\Karyawan\Index as karyawanIndex;

//karyawan
use App\Livewire\Kendaraan\Create as KendaraanCreate;
use App\Livewire\Kendaraan\show as KendaraanDetail;
use App\Livewire\Konten\Create as KontenCreate;

//kendaraan
use App\Livewire\Konten\Edit as KontenEdit;
use App\Livewire\Konten\Index as KontenIndex;

//konten
use App\Livewire\Pelanggan\Create as PelangganCreate;
use App\Livewire\Pelanggan\Edit as PelangganEdit;
use App\Livewire\Pelanggan\Index as PelangganIndex;

//penjualan
use App\Livewire\Pelanggan\Show as PelangganDetail;
use App\Livewire\Penjualan\Create as PenjualanCreate;
use App\Livewire\Penjualan\Index as PenjualanIndex;


//service
use App\Livewire\Penjualan\Show as PenjualanShow;
use App\Livewire\Service\Create as ServiceCreate;
use App\Livewire\Service\Edit as ServiceEdit;
use App\Livewire\Service\Index as ServiceIndex;
use App\Livewire\Service\ServiceDetail;

//sparepart
use App\Livewire\Service\Show as ServiceShow;
use App\Livewire\Sparepart\Create as SparepartCreate;
use App\Livewire\Sparepart\Edit as SparepartEdit;
use App\Livewire\Sparepart\Index as SparepartIndex;

//transaksi
use App\Livewire\Sparepart\Show as SparepartShow;
use App\Livewire\Transaksi\Index as TransaksiIndex;
use App\Livewire\Transaksi\Show as TransaksiShow;

//absensi
use App\Livewire\Transaksi\TambahService as TransaksiService;
use App\Livewire\User\Index as UserIndex;
use App\Livewire\User\Password;
use App\Livewire\User\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;







Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true, 'register' => false, 'login' => false]);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('logout', Logout::class)->name('logout');

    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    //user
    Route::get('/user', UserIndex::class)->name('user.view');
    Route::get('/user/create', UserCreate::class)->name('user.create');
    Route::get('/profile', Profile::class)->name('profile.show');
    Route::get('/profile/password', Password::class)->name('profile.password');

    //karyawan
    Route::get('/karyawan', KaryawanIndex::class)->name('karyawan.view');
    Route::get('/karyawan/create', KaryawanCreate::class)->name('karyawan.create');
    Route::get('/karyawan/{id}/edit', KaryawanEdit::class)->name('karyawan.edit');

    //kendaraan
    Route::get('/jenis_kendaraan', JenisKendaraanIndex::class)->name('jenis_kendaraan.view');
    Route::get('/jenis_kendaraan/create', JenisKendaraanCreate::class)->name('jenis_kendaraan.create');
    Route::get('/jenis_kendaraan/{id}/edit', JenisKendaraanEdit::class)->name('jenis_kendaraan.edit');

    //pelanggan
    Route::get('/pelanggan', PelangganIndex::class)->name('pelanggan.view');
    Route::get('/pelanggan/create', PelangganCreate::class)->name('pelanggan.create');
    Route::get('/pelanggan/{id}/edit', PelangganEdit::class)->name('pelanggan.edit');
    Route::get('/pelanggan/{id}', PelangganDetail::class)->name('pelanggan.detail');
    Route::get('/pelanggan/{id}/kendaraan/create', KendaraanCreate::class)->name('kendaraan.create');
    Route::get('/pelanggan/{pelanggan}/kendaraan/{kendaraan}', KendaraanDetail::class)->name('kendaraan.show');


    //jasa
    Route::get('/jasa', JasaIndex::class)->name('jasa.view');
    Route::get('/jasa/create', JasaCreate::class)->name('jasa.create');
    Route::get('/jasa/{id}/edit', JasaEdit::class)->name('jasa.edit');

    //sparepart
    Route::get('/sparepart', SparepartIndex::class)->name('sparepart.view');
    Route::get('/sparepart/create', SparepartCreate::class)->name('sparepart.create');
    Route::get('/sparepart/{id}', SparepartShow::class)->name('sparepart.show');
    Route::get('/sparepart/{id}/edit', SparepartEdit::class)->name('sparepart.edit');
    Route::get('/sparepart/{id}/gudang/create', GudangCreate::class)->name('gudang.create');

    //konten
    Route::get('/konten', KontenIndex::class)->name('konten.view');
    Route::get('/konten/create', KontenCreate::class)->name('konten.create');
    Route::get('/konten/{id}/edit', KontenEdit::class)->name('konten.edit');

    //absensi
    Route::get('/absensi', AbsensiIndex::class)->name('absensi.view');
    Route::get('/absensi/create/{id}/{type}', AbsensiCreate::class)->name('absensi.create');
    Route::get('/absensi/lihat-absen', AbsensiRead::class)->name('absensi.read');
    Route::get('/rekap-absen', AbsensiShow::class)->name('absensi.rekap');


    //transaksi
    Route::get('/transaksi/', TransaksiIndex::class)->name('transaksi.view');
    Route::get('/transaksi/{id}', TransaksiShow::class)->name('transaksi.show');
    Route::get('/transaksi/{id}/invoice/', [InvoiceController::class, 'show'])->name('invoice.show');
    Route::get('/transaksi/{id}/invoice/download', [InvoiceController::class, 'download'])->name('invoice.download');

    Route::get('/transaksi/service/{id}/create', TransaksiService::class)->name('transaksi.service');


    //service
    Route::get('/service', ServiceIndex::class)->name('service.view');
    Route::get('/service/create', ServiceCreate::class)->name('service.create');
    Route::get('/service/create/{id}/detail', ServiceDetail::class)->name('service.detail');
    Route::get('/service/{id}', ServiceShow::class)->name('service.show');
    Route::get('/service/{id}/edit', ServiceEdit::class)->name('service.edit');

    //penjualan
    Route::get('/penjualan', PenjualanIndex::class)->name('penjualan.view');
    Route::get('/penjualan/create', PenjualanCreate::class)->name('penjualan.create');
    Route::get('/penjualan/{id}', PenjualanShow::class)->name('penjualan.show');
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
