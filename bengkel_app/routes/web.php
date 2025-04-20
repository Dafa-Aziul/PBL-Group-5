<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\JenisLayananController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard.index');
});

Route::resource('pelanggan', PelangganController::class);
Route::resource('/pelanggan', PelangganController::class);

Route::resource('layanan', JenisLayananController::class);
Route::resource('/layanan', JenisLayananController::class);