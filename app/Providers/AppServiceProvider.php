<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\CityRepositoryInterface;
use App\Repositories\CityRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
