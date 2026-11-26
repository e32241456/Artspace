<?php

namespace App\Providers;

use App\Models\KaryaSeni;
use App\Models\RiwayatPameran;
use App\Policies\KaryaSeniPolicy;
use App\Policies\RiwayatPameranPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        Gate::policy(KaryaSeni::class, KaryaSeniPolicy::class);
        Gate::policy(RiwayatPameran::class, RiwayatPameranPolicy::class);
    }
}