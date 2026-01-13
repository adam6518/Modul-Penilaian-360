<?php

namespace App\UseCases\PeriodePegawai;

use App\Repositories\PeriodePegawai\PeriodePegawaiRepositoryInterface;

class GetPeriodePegawaiUseCase
{
    // public function __construct(
    //     protected PeriodePegawaiRepositoryInterface $repository
    // ) {}

    // public function execute(): array
    // {
    //     return $this->repository->getAll();
    // }
    public function __construct(
        private PeriodePegawaiRepositoryInterface $repository
    ) {}

    public function execute(?int $periodeId = null): array
    {
        // return $this->repo->getByPeriode($periodeId);
        $data = $this->repository->getAll();

        if ($periodeId === null) {
            return [];
        }

        return array_values(array_filter(
            $data,
            fn($row) => (int) $row['id_periode'] === (int) $periodeId
        ));
    }
}