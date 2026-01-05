<?php

namespace App\UseCases\PeriodePegawai;

use App\Repositories\PeriodePegawai\PeriodePegawaiRepositoryInterface;

class GetPeriodePegawaiUseCase
{
    public function __construct(
        protected PeriodePegawaiRepositoryInterface $repository
    ) {}

    public function execute(): array
    {
        return $this->repository->getAll();
    }
}