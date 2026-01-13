<?php

namespace App\UseCases\Periode;

use App\Repositories\Periode\PeriodeRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UpdatePeriodeUseCase
{
    public function __construct(
        private PeriodeRepositoryInterface $repository
    ) {}

    public function execute(int $id, array $input): void
    {
        $validator = Validator::make($input, [
            'nama_periode' => 'required|string',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $success = $this->repository->update($id, $validator->validated());

        if (! $success) {
            throw new \RuntimeException('Periode tidak ditemukan atau sudah dihapus');
        }
    }
}