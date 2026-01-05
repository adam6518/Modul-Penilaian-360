<?php

namespace App\Repositories\PeriodePegawai;

use App\Services\External\JsonBinService;

class PeriodePegawaiRepository implements PeriodePegawaiRepositoryInterface
{
    public function __construct(
        protected JsonBinService $jsonBinService
    ) {}

    public function getAll(): array
    {
        return $this->jsonBinService->getPeriodePegawai();
    }
}