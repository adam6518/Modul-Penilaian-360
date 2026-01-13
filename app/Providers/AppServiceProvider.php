<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\PeriodePegawai\PeriodePegawaiRepositoryInterface;
use App\Repositories\PeriodePegawai\PeriodePegawaiRepository;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            PeriodePegawaiRepositoryInterface::class,
            PeriodePegawaiRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}