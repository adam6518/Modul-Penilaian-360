<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PeriodePegawaiService
{
    private string $jsonUrl = 'https://api.jsonbin.io/v3/b/6954850a43b1c97be90f7a7b';

    // ambil periode dari DB
    public function getPeriodeList(): array
    {
        return DB::table('periode')
            ->where('status', '!=', 9)
            ->select('id', 'nama_periode')
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();
    }

    // ambil data pegawai dari JSON dummy
    public function getPegawaiByPeriode(int $periodeId): array
    {
        $response = Http::get($this->jsonUrl);

        if (! $response->successful()) {
            return [];
        }

        $json = $response->json();

        $data = $json['record']['data']
            ?? $json['record']
            ?? [];

        // filter berdasarkan id_periode
        return array_values(array_filter($data, function ($row) use ($periodeId) {
            return (int) $row['id_periode'] === (int) $periodeId;
        }));
    }
}