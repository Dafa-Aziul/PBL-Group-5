<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManajemenKontenController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard.index');
});

// Route::get('/ManajemenKonten-dashb', function () {
//     return view('dashboard.index');
// });

// Route::get('/ManajemenKonten', [ManajemenKontenController::class,'index']);


Route::resource('manajemen-konten', ManajemenKontenController::class);
// use App\Http\Controllers\ManajemenKontenController;

Route::get('/ManajemenKonten', [ManajemenKontenController::class, 'index'])->name('manajemen-konten.index');
