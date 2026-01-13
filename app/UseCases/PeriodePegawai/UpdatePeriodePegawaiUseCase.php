<?php

namespace App\UseCases\PeriodePegawai;

use App\Repositories\PeriodePegawai\PeriodePegawaiRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UpdatePeriodePegawaiUseCase
{
    public function __construct(
        private PeriodePegawaiRepositoryInterface $repo
    ) {}

    public function execute(int $id, array $data): array
    {
        return $this->repo->update($id, $data);
    }
}