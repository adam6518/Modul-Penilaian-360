<?php

namespace App\UseCases\PeriodePegawai;

use App\Repositories\PeriodePegawai\PeriodePegawaiRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
class CreatePeriodePegawaiUseCase
{
    public function __construct(
        private PeriodePegawaiRepositoryInterface $repo
    ) {}

    public function execute(array $data): array
    {
        return $this->repo->create($data);
    }
}