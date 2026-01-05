<?php

namespace App\Services\External;

use Illuminate\Support\Facades\Http;

class JsonBinService
{
    public function getPeriodePegawai(): array
    {
        $response = Http::get(
            'https://api.jsonbin.io/v3/b/6954850a43b1c97be90f7a7b'
        )->json();

        if (isset($response['record']['data'])) {
            return $response['record']['data'];
        }

        if (isset($response['record']) && is_array($response['record'])) {
            return $response['record'];
        }

        return [];
    }
}