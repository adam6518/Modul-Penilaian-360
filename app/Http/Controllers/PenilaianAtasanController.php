<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenilaianAtasanController extends Controller
{
    // DUMMY USER LOGGED IN
    private array $userLoggedIn = [
        'id' => 18,
        'nama' => 'Bawahan A2 A'
    ];

    // LOAD PAGE
    public function index()
    {
        $indikator = DB::select("
        SELECT id, referensi, kode
        FROM referensi
        WHERE jenis = 'penilaian'
          AND status = 1
        ORDER BY id
    ");

        return view('penilaian-atasan', [
            'userPenilai' => $this->userLoggedIn,
            'indikator'   => $indikator
        ]);
    }

    // AMBIL DARI DB REFERENSI
    private function getNilaiReferensi(): array
    {
        $rows = DB::select("
        SELECT referensi, nilai
        FROM referensi
        WHERE status = 1
    ");

        $map = [];
        foreach ($rows as $r) {
            $map[$r->referensi][] = $r->nilai;
        }

        return [
            'col_01' => $map['Ber'][0] ?? 0,
            'col_02'  => $map['A'][0] ?? 0,
            'col_03'  => $map['K'][0] ?? 0,
            'col_04'   => $map['H'][0] ?? 0,
            'col_05'   => $map['L'][0] ?? 0,
            'col_06'  => $map['A'][1] ?? 0,
            'col_07'  => $map['K'][1] ?? 0,
        ];
    }

    // AMBIL NAMA TERNILAI DARI DB PERIODE PEGAWAI
    public function getTernilaiByPeriode(Request $request)
    {
        return DB::select("
        SELECT
            pp.id_pegawai AS id,
            pp.nama_pegawai
        FROM periode_pegawai pp
        WHERE pp.id_periode = ?
          AND pp.status = 1
    ", [$request->periode_id]);
    }

    // PENGHITUNGAN BOBOT
    private function getBobotReferensi(): array
    {
        $rows = DB::select("
        SELECT referensi, nilai
        FROM referensi
        WHERE status = 1
        ORDER BY id ASC
    ");

        $map = [];

        foreach ($rows as $r) {
            $map[$r->referensi][] = (float) $r->nilai;
        }

        return [
            'col_01' => $map['Ber'][0] ?? 0,
            'col_02'  => $map['A'][0] ?? 0,
            'col_03'  => $map['K'][0] ?? 0,
            'col_04'   => $map['H'][0] ?? 0,
            'col_05'   => $map['L'][0] ?? 0,
            'col_06'  => $map['A'][1] ?? 0,
            'col_07'  => $map['K'][1] ?? 0,
        ];
    }

    public function store(Request $request)
    {
        $periodeId = $request->periode_id;
        $rows = $request->penilaian;

        if (!is_array($rows) || empty($rows)) {
            return response()->json([
                'success' => false,
                'message' => 'Data penilaian kosong'
            ], 422);
        }

        $bobot = $this->getBobotReferensi();

        DB::beginTransaction();

        try {
            foreach ($rows as $row) {

                DB::statement("
                INSERT INTO penilaian
                (id_periode, id_penilai, id_ternilai,
                 col_01, col_02, col_03, col_04, col_05, col_06, col_07)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                    col_01 = VALUES(col_01),
                    col_02 = VALUES(col_02),
                    col_03 = VALUES(col_03),
                    col_04 = VALUES(col_04),
                    col_05 = VALUES(col_05),
                    col_06 = VALUES(col_06),
                    col_07 = VALUES(col_07)
            ", [
                    $periodeId,
                    $this->userLoggedIn['id'],
                    $row['id_ternilai'],

                    // HITUNG NILAI
                    ($row['col_01'] ?? 0) * ($bobot['col_01'] / 100),
                    ($row['col_02'] ?? 0) * ($bobot['col_02'] / 100),
                    ($row['col_03'] ?? 0) * ($bobot['col_03'] / 100),
                    ($row['col_04'] ?? 0) * ($bobot['col_04'] / 100),
                    ($row['col_05'] ?? 0) * ($bobot['col_05'] / 100),
                    ($row['col_06'] ?? 0) * ($bobot['col_06'] / 100),
                    ($row['col_07'] ?? 0) * ($bobot['col_07'] / 100),
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'inserted' => count($rows)
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan penilaian',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // AMBIL DATA ATASAN
    public function getAtasanByPeriode(Request $request)
    {
        $periodeId = $request->periode_id;

        return DB::select("
        SELECT
            atasan.id_pegawai   AS id_atasan,
            atasan.nama_pegawai AS nama_atasan
        FROM periode_pegawai bawahan
        JOIN periode_pegawai atasan
          ON atasan.id_pegawai = bawahan.id_atasan
         AND atasan.id_periode = bawahan.id_periode
        WHERE bawahan.id_periode = ?
          AND bawahan.id_pegawai = ?
          AND bawahan.status = 1
          AND atasan.status = 1
        LIMIT 1
    ", [
            $periodeId,
            $this->userLoggedIn['id']
        ]);
    }
}