<?php

namespace App\UseCases\Referensi;

use App\Repositories\Referensi\ReferensiRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UpdateReferensiUseCase
{
    public function __construct(
        private ReferensiRepositoryInterface $repository
    ) {}

    public function execut(int $id, array $input): void
    {
        $validator = Validator::make($input, [
            'referensi' => 'required|string',
            'nilai' => 'required|int',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $success = $this->repository->update($id, $validator->validated());
        
        if(! $success) {
            throw new \RuntimeException('Referensi tidak ditemukan atau sudah dihapus');
        }
        
    }
}