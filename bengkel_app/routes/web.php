<?php

use App\Http\Controllers\AuthControlller;
use App\Http\Controllers\SparepartController; 
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::get('login', [AuthControlller::class, 'index'])->name('login');
Route::post('login', [AuthControlller::class, 'submitLogin'])->name('login.post');

Route::middleware(['auth'])->group(function () {
    Route::get('logout', [AuthControlller::class, 'logout'])->name('logout');
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');
    Route::resource('/sparepart', SparepartController::class);
    Route::resource('/user', UserController::class);
});
Route::get('/user-create', function () {
    DB::table('users')->insert([
        'name' => 'admin',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('admin123'),
        'role' => 'admin']);
        return redirect()->route('login')->with('success', 'User berhasil ditambahkan');
});