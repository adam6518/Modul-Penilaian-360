<?php

namespace App\Repositories\PeriodePegawai;

interface PeriodePegawaiRepositoryInterface
{
    public function getAll(): array;

    public function getByPeriode(int $periodeId): array;
    public function create(array $data): array;
    public function update(int $id, array $data): array;
    public function softDelete(int $id): bool;
}