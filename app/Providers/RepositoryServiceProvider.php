<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\PeriodePegawai\{
    PeriodePegawaiRepository,
    PeriodePegawaiRepositoryInterface
};
use App\Repositories\Periode\{
    PeriodeRepository,
    PeriodeRepositoryInterface
};

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            \App\Repositories\Periode\PeriodeRepositoryInterface::class,
            \App\Repositories\Periode\PeriodeRepository::class
        );
        $this->app->bind(
            PeriodePegawaiRepositoryInterface::class,
            PeriodePegawaiRepository::class
        );
    }
}