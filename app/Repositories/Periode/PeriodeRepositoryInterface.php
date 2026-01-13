<?php

namespace App\Repositories\Periode;

interface PeriodeRepositoryInterface
{
    public function getActive(): array;
    public function findById(int $id): ?array;
    public function store(array $data): int;
    public function update(int $id, array $data): bool;
    public function softDelete(int $id): bool;
}