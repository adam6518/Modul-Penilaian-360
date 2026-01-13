<?php

namespace App\UseCases\Referensi;

use App\Repositories\Referensi\ReferensiRepositoryInterface;

class DeleteReferensiUseCase
{
    public function __construct(
        private ReferensiRepositoryInterface $repository
    ) {}

    public function execute(int $id): void
    {
        $success = $this->repository->softDelete($id);

        if(! $success) {
            throw new \RuntimeException('Referensi tidak ditemukan atau sudah dihapus');
        }
    }

}