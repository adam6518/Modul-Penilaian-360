<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class RekapSatkerSheet implements FromCollection, WithHeadings, WithTitle
{
    protected $periodeId;
    protected $satkerId;

    public function __construct($periodeId, $satkerId)
    {
        $this->periodeId = $periodeId;
        $this->satkerId = $satkerId;
    }

    public function collection()
    {
        return collect(DB::select("
            SELECT
            pp.nama_pegawai,
            MAX(kp.col_01) AS col_01,
            MAX(kp.col_02) AS col_02,
            MAX(kp.col_03) AS col_03,
            MAX(kp.col_04) AS col_04,
            MAX(kp.col_05) AS col_05,
            MAX(kp.col_06) AS col_06,
            MAX(kp.col_07) AS col_07,
            MAX(kp.total)  AS total
        FROM kalkulasi_penilaian kp
        JOIN periode_pegawai pp
          ON pp.id_pegawai = kp.id_pegawai
         AND pp.id_periode = kp.id_periode
        WHERE kp.id_periode = ?
          AND pp.id_satker = ?
        GROUP BY kp.id_pegawai, pp.nama_pegawai
        ORDER BY total DESC
        ", [$this->periodeId, $this->satkerId]));
    }

    public function headings(): array
    {
        return [
            'Nama Pegawai',
            'Ber',
            'A',
            'K',
            'H',
            'L',
            'A',
            'K',
            'Total Nilai'
        ];
    }

    public function title(): string
    {
        return 'Satker ' . $this->satkerId;
    }
}