<?php

namespace App\Providers;

use App\Services\Entreprise;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Entreprise::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share('entreprise', $this->app->make(Entreprise::class));
    }
}
