<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;


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
        // Gate berdasarkan role tunggal
        Gate::define('admin', fn($user) => $user->role === 'admin' || $user->role === 'superadmin');
        Gate::define('owner', fn($user) => $user->role === 'owner'  || $user->role === 'superadmin');
        Gate::define('mekanik', fn($user) => $user->role === 'mekanik' || $user->role === 'superadmin');/*  */

        // === Admin, Owner, Superadmin ===
        Gate::define(
            'akses-admin-owner',
            fn($user) =>
            in_array($user->role, ['admin', 'owner', 'superadmin'])
        );

        // === Superadmin, Admin ===
        Gate::define(
            'akses-admin',
            fn($user) =>
            in_array($user->role, ['superadmin', 'admin'])
        );

        // === Superadmin, Admin, Owner ===
        Gate::define(
            'akses-admin-owner',
            fn($user) =>
            in_array($user->role, ['superadmin', 'admin', 'owner'])
        );

        // === Superadmin, Admin, Mekanik ===
        Gate::define(
            'akses-karyawan',
            fn($user) => in_array($user->role, ['superadmin', 'admin', 'mekanik'])
        );

        // === Superadmin, Owner, Admin, Mekanik ===
        Gate::define(
            'akses-internal',
            fn($user) =>
            in_array($user->role, ['superadmin', 'owner', 'admin', 'mekanik'])
        );
    }
}
