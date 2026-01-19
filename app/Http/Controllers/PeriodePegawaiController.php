<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Http;

class PeriodePegawaiController extends Controller
{
    // Data dummy Periode Pegawai 
    private array $dataPeriodePegawai = [
        "record" => [
            "data" => [
                [
                    "id" => 1,
                    "id_periode" => 11,
                    "id_atasan" => null,
                    "nama_pegawai" => "Atasan 1",
                    "nip" => "2440086703",
                    "id_pegawai" => 12,
                    "id_satker" => 13,
                    "status" => 1
                ],
                [
                    "id" => 2,
                    "id_periode" => 11,
                    "id_atasan" => null,
                    "nama_pegawai" => "Atasan 2",
                    "nip" => "2440086704",
                    "id_pegawai" => 13,
                    "id_satker" => 14,
                    "status" => 1
                ],
                [
                    "id" => 3,
                    "id_periode" => 11,
                    "id_atasan" => 12,
                    "nama_pegawai" => "Bawahan A1 A",
                    "nip" => "2440086705",
                    "id_pegawai" => 14,
                    "id_satker" => 13,
                    "status" => 1
                ],
                [
                    "id" => 4,
                    "id_periode" => 11,
                    "id_atasan" => 12,
                    "nama_pegawai" => "Bawahan A1 B",
                    "nip" => "2440086706",
                    "id_pegawai" => 15,
                    "id_satker" => 13,
                    "status" => 1
                ],
                [
                    "id" => 5,
                    "id_periode" => 11,
                    "id_atasan" => 12,
                    "nama_pegawai" => "Bawahan A1 C",
                    "nip" => "2440086707",
                    "id_pegawai" => 16,
                    "id_satker" => 13,
                    "status" => 1
                ],
                [
                    "id" => 6,
                    "id_periode" => 11,
                    "id_atasan" => 12,
                    "nama_pegawai" => "Bawahan A1 D",
                    "nip" => "2440086708",
                    "id_pegawai" => 17,
                    "id_satker" => 13,
                    "status" => 1
                ],
                [
                    "id" => 7,
                    "id_periode" => 11,
                    "id_atasan" => 13,
                    "nama_pegawai" => "Bawahan A2 A",
                    "nip" => "2440086709",
                    "id_pegawai" => 18,
                    "id_satker" => 14,
                    "status" => 1
                ],
                [
                    "id" => 8,
                    "id_periode" => 11,
                    "id_atasan" => 13,
                    "nama_pegawai" => "Bawahan A2 B",
                    "nip" => "2440086710",
                    "id_pegawai" => 19,
                    "id_satker" => 14,
                    "status" => 1
                ],
                [
                    "id" => 9,
                    "id_periode" => 11,
                    "id_atasan" => 13,
                    "nama_pegawai" => "Bawahan A2 B",
                    "nip" => "2440086711",
                    "id_pegawai" => 19,
                    "id_satker" => 14,
                    "status" => 1
                ],
                [
                    "id" => 10,
                    "id_periode" => 11,
                    "id_atasan" => 13,
                    "nama_pegawai" => "Bawahan A2 C",
                    "nip" => "2440086712",
                    "id_pegawai" => 20,
                    "id_satker" => 14,
                    "status" => 1
                ],
                [
                    "id" => 11,
                    "id_periode" => 11,
                    "id_atasan" => 13,
                    "nama_pegawai" => "Bawahan A2 D",
                    "nip" => "2440086713",
                    "id_pegawai" => 21,
                    "id_satker" => 14,
                    "status" => 1
                ],
            ]
        ]
    ];

    // LOAD PAGE
    public function index()
    {
        return view('periode-pegawai');
    }

    // AMBIL PERIODE DARI DB (UNTUK DROPDOWN)
    public function getPeriodeList()
    {
        $periode = DB::select("
            SELECT id, nama_periode
            FROM periode
            WHERE status != 9
            ORDER BY id DESC
        ");

        return response()->json($periode);
    }

    // Import dari JSON ke DB
    public function importFromJson(Request $request)
    {
        $periodeId = $request->periode_id;

        $data = $this->dataPeriodePegawai['record']['data'];

        $filtered = array_filter(
            $data,
            fn($row) => (int) $row['id_periode'] === $periodeId
        );

        foreach ($filtered as $row) {
            DB::insert("
                INSERT INTO periode_pegawai
                (id_periode, id_atasan, nama_pegawai, nip, id_pegawai, id_satker, status)
                VALUES (?, ?, ?, ?, ?, ?, 1)
            ", [
                $row['id_periode'],
                $row['id_atasan'] ?? 0,
                $row['nama_pegawai'],
                $row['nip'],
                $row['id_pegawai'],
                $row['id_satker'],
            ]);
        }

        return response()->json(['success' => true]);
    }

    // Tampilkan data dari DB
    public function showByPeriode(Request $request)
    {
        return DB::select("
            SELECT *
            FROM periode_pegawai
            WHERE id_periode = ?
            AND status = 1
        ", [$request->periode_id]);
    }

    // Hapus data periode pegawai per row
    public function destroy($id)
    {
        DB::update("
        UPDATE periode_pegawai
        SET status = 9
        WHERE id = ?
    ", [$id]);

        return response()->json([
            'success' => true
        ]);
    }

    // Hapus data by periode
    public function destroyByPeriode(Request $request)
    {
        $periodeId = $request->periode_id;

        if (! $periodeId) {
            return response()->json([
                'success' => false,
                'message' => 'Periode tidak valid'
            ], 422);
        }

        DB::update("
        UPDATE periode_pegawai
        SET status = 9
        WHERE id_periode = ?
        AND status = 1
    ", [$periodeId]);

        return response()->json([
            'success' => true
        ]);
    }
}