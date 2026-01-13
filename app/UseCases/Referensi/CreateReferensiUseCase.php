<?php

namespace App\UseCases\Referensi;

use App\Repositories\Referensi\ReferensiRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateReferensiUseCase
{
    public function __construct(
        private ReferensiRepositoryInterface $repository
    ) {}

    public function execute(array $data)
    {
        $validator = Validator::make($data, [
            'referensi' => 'required|string',
            'nilai' => 'required|int',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $this->repository->store($validator->validate());
    }
}