<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('components.navbar', function ($view) {
            $karyawan = null;
            if (Auth::check()) {
                $karyawan = Karyawan::where('user_id', Auth::id())->first();
            }
            $view->with('karyawan', $karyawan);
        });
    }
}
