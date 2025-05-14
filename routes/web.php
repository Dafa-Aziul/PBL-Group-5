<?php

use \App\Livewire\User\Create;
use App\Http\Controllers\auth\VerifyEmailController;
use App\Livewire\About;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\VerifyEmail;
use App\Livewire\Dashboard;
//jenis kendaraan
use App\Livewire\JenisKendaraan\Index as JenisKendaraanIndex;
use App\Livewire\JenisKendaraan\Create as JenisKendaraanCreate;
use App\Livewire\JenisKendaraan\Edit as JenisKendaraanEdit;
//jasa
use App\Livewire\JenisJasa\Index as JenisJasaIndex;
use App\Livewire\JenisJasa\Create as JenisJasaCreate;
use App\Livewire\JenisJasa\Edit as JenisJasaEdit;
//user
use App\Livewire\User\Index;
//pelanggan
use App\Livewire\Pelanggan\Index as PelangganIndex;
use App\Livewire\Pelanggan\Create as PelangganCreate;

//sparepart 
use App\Livewire\Sparepart\Index as SparepartIndex;
use App\Livewire\Sparepart\Create as SparepartCreate;
use App\Livewire\Sparepart\Edit as SparepartEdit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true, 'register' => false, 'login' => false]);

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    
    // user
    Route::get('/user', Index::class)->name('user.view');
    Route::get('/user/create', Create::class)->name('user.create');
    // pelanggan
    Route::get('/pelanggan', PelangganIndex::class)->name('pelanggan.view');
    Route::get('/pelanggan/create', PelangganCreate::class)->name('pelanggan.create');
    //jenis kendaraan
    Route::get('/jenis_kendaraan',JenisKendaraanIndex::class)->name('jenis_kendaraan.view');
    Route::get('/jenis_kendaraan/create',JenisKendaraanCreate::class)->name('jenis_kendaraan.create');
    Route::get('/jenis_kendaraan/{id}/edit',JenisKendaraanEdit::class)->name('jenis_kendaraan.edit');
    //jenis jasa
    Route::get('/jenis_jasa',JenisJasaIndex::class)->name('jenis_jasa.view');
    Route::get('/jenis_jasa/create',JenisJasaCreate::class)->name('jenis_jasa.create');
    Route::get('/jenis_jasa/{id}/edit',JenisJasaEdit::class)->name('jenis_jasa.edit');

    //sparepart
    Route::get('/sparepart',SparepartIndex::class)->name('sparepart.view');
    Route::get('/sparepart/create',SparepartCreate::class)->name('sparepart.create');
    Route::get('/sparepart/{id}/edit',SparepartEdit::class)->name('sparepart.edit');

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

Route::post('logout', App\Livewire\Action\Logout::class)
    ->name('logout');