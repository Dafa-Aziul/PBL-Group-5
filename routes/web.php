<?php

use \App\Livewire\User\Create;
use App\Http\Controllers\auth\VerifyEmailController;
use App\Livewire\About;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\VerifyEmail;
use App\Livewire\Dashboard;
use App\Livewire\User\Index;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true, 'register' => false, 'login' => false]);

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/user', Index::class)->name('user.view');
    Route::get('/user/create', Create::class)->name('user.create');
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