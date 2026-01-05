<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\PeriodePegawai\{
    PeriodePegawaiRepository,
    PeriodePegawaiRepositoryInterface
};

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            PeriodePegawaiRepositoryInterface::class,
            PeriodePegawaiRepository::class
        );
    }
}