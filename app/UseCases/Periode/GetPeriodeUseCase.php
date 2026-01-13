<?php

namespace App\UseCases\Periode;

use App\Repositories\Periode\PeriodeRepositoryInterface;

class GetPeriodeUseCase
{
    public function __construct(
        private PeriodeRepositoryInterface $repository
    ) {}

    public function execute(): array
    {
        return $this->repository->getActive();
    }
}