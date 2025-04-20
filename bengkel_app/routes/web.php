<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JenisKendaraanController;
use App\Http\Controllers\DataKaryawanController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard.index');
});


Route::resource('jenis-kendaraan', JenisKendaraanController::class);

Route::resource('data-karyawan', DataKaryawanController::class);

