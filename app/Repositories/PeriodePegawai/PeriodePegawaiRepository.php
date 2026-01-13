<?php

namespace App\Repositories\PeriodePegawai;

use Illuminate\Support\Facades\Http;

class PeriodePegawaiRepository implements PeriodePegawaiRepositoryInterface
{
    private string $url = 'https://api.jsonbin.io/v3/b/6954850a43b1c97be90f7a7b';

    // public function getAll(): array
    // {
    //     $response = Http::withoutVerifying()->get($this->url);

    //     if (! $response->successful()) {
    //         return [];
    //     }

    //     $json = $response->json();

    //     return $json['record']['data'] ?? [];
    // }

    public function getAll(): array
    {
        // $res = Http::get($this->url)->json();
        // return $res['record']['data'] ?? [];
        $response = Http::withoutVerifying()->get($this->url);

        if (! $response->successful()) {
            return [];
        }

        $json = $response->json();

        return $json['record']['data'] ?? [];
    }

    public function getByPeriode(int $periodeId): array
    {
        return array_values(array_filter(
            $this->getAll(),
            fn($row) => (int) $row['id_periode'] === $periodeId
        ));
    }

    public function create(array $data): array
    {
        // MOCK create (JSONBin tidak di-update beneran)
        $data['id'] = rand(1000, 9999);
        return $data;
    }

    public function update(int $id, array $data): array
    {
        $data['id'] = $id;
        return $data;
    }

    public function softDelete(int $id): bool
    {
        return true;
    }
}