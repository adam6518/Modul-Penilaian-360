<?php

namespace App\UseCases\Periode;

use App\Repositories\Periode\PeriodeRepositoryInterface;

class DeletePeriodeUseCase
{
    public function __construct(
        private PeriodeRepositoryInterface $repository
    ) {}

    public function execute(int $id): void
    {
        $success = $this->repository->softDelete($id);

        if (! $success) {
            throw new \RuntimeException('Periode tidak ditemukan atau sudah dihapus');
        }
    }
}