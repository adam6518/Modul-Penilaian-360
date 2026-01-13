<?php

namespace App\UseCases\PeriodePegawai;

use App\Repositories\PeriodePegawai\PeriodePegawaiRepositoryInterface;

class DeletePeriodePegawaiUseCase
{
    public function __construct(
        private PeriodePegawaiRepositoryInterface $repo
    ) {}

    public function execute(int $id): void
    {
        $success = $this->repo->softDelete($id);
        if (! $success) {
            throw new \RuntimeException('Periode Pegawai tidak ditemukan atau sudah dihapus');
        }
    }
}