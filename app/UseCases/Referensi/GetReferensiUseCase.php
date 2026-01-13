<?php

namespace App\UseCases\Referensi;

use App\Repositories\Referensi\ReferensiRepositoryInterface;
class GetReferensiUseCase
{
    public function __construct(
        private ReferensiRepositoryInterface $repository
    ) {}

    public function execute(): array
    {
        return $this->repository->getActive();
    }
}