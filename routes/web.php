<?php

use App\Http\Controllers\auth\VerifyEmailController;
use App\Livewire\About;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\VerifyEmail;
use App\Livewire\Dashboard;
use \App\Livewire\User\Create;
use App\Livewire\User\Index as UserIndex;
use App\Livewire\JenisKendaraan\Create as JenisKendaraanCreate;
use App\Livewire\JenisKendaraan\Edit as JenisKendaraanEdit;
use App\Livewire\JenisKendaraan\Index as JenisKendaraanIndex;
use App\Livewire\Kendaraan\Create as KendaraanCreate;
use App\Livewire\Pelanggan\Create as PelangganCreate;
use App\Livewire\Pelanggan\Edit as PelangganEdit;
use App\Livewire\Pelanggan\Index as PelangganIndex;
use App\Livewire\Pelanggan\Show as PelangganDetail;
use App\Livewire\Sparepart\Index as SparepartIndex;
use App\Livewire\Sparepart\Create as SparepartCreate;
use App\Livewire\Sparepart\Edit as SparepartEdit; 
use App\Livewire\Jasa\Index as JasaIndex;
use App\Livewire\Jasa\Create as JasaCreate;
use App\Livewire\Jasa\Edit as JasaEdit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true, 'register' => false, 'login' => false]);

Route::middleware('auth', 'verified')->group(function () {
    Route::post('logout', App\Livewire\Action\Logout::class)->name('logout');
    
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    
    Route::get('/user', UserIndex::class)->name('user.view');
    Route::get('/user/create', Create::class)->name('user.create');
    
    Route::get('/jenis_kendaraan', JenisKendaraanIndex::class)->name('jenis_kendaraan.view');
    Route::get('/jenis_kendaraan/create', JenisKendaraanCreate::class)->name('jenis_kendaraan.create');
    Route::get('/jenis_kendaraan/{id}/edit', JenisKendaraanEdit::class)->name('jenis_kendaraan.edit');
    
    Route::get('/pelanggan', PelangganIndex::class)->name('pelanggan.view');
    Route::get('/pelanggan/create', PelangganCreate::class)->name('pelanggan.create');
    Route::get('/pelanggan/{id}/edit', PelangganEdit::class)->name('pelanggan.edit');
    Route::get('/pelanggan/{id}', PelangganDetail::class)->name('pelanggan.detail');
    Route::get('/pelanggan/{id}/kendaraan/create', KendaraanCreate::class)->name('kendaraan.create');

    Route::get('/jasa',JasaIndex::class)->name('jasa.view');
    Route::get('/jasa/create',JasaCreate::class)->name('jasa.create');
    Route::get('/jasa/{id}/edit',JasaEdit::class)->name('jasa.edit');


    Route::get('/sparepart', SparepartIndex::class)->name('sparepart.view');
    Route::get('/sparepart/create', SparepartCreate::class)->name('sparepart.create');
    Route::get('/sparepart/{id}/edit', SparepartEdit::class)->name('sparepart.edit');
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

