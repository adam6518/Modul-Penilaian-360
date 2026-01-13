<?php

namespace App\UseCases\Periode;

use App\Repositories\Periode\PeriodeRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreatePeriodeUseCase
{
    public function __construct(
        private PeriodeRepositoryInterface $repository
    ) {}

    public function execute(array $data)
    {
        $validator = Validator::make($data, [
            'nama_periode' => 'required|string',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $this->repository->store($validator->validated());
    }
}