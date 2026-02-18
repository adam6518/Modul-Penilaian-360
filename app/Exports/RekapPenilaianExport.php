<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RekapPenilaianExport implements WithMultipleSheets
{
    protected $periodeId;
    protected $satkerList;

    public function __construct($periodeId, $satkerList)
    {
        $this->periodeId = $periodeId;
        $this->satkerList = $satkerList;
    }

    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->satkerList as $satker) {
            $sheets[] = new RekapSatkerSheet(
                $this->periodeId,
                $satker->id_satker
            );
        }

        return $sheets;
    }
}