<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class StatistikController extends Controller
{
    public function index()
    {
        if(session('role') !== 'admin') {
            return redirect('/');
        }
        return view('statistik');
    }

    public function getData()
    {
        // Progress Penilaian
        $totalPegawai = DB::table('periode_pegawai')
            ->where('status', 1)
            ->count();

        $sudahDinilai = DB::table('kalkulasi_penilaian')
            ->distinct('id_pegawai')
            ->count('id_pegawai');

        $belumDinilai = $totalPegawai - $sudahDinilai;

        // Distribusi Nilai
        $distribusi = DB::select("
        SELECT
        CASE
            WHEN total >= 90 THEN '90-100'
            WHEN total >= 80 THEN '80-89'
            WHEN total >= 70 THEN '70-79'
            WHEN total >= 60 THEN '60-69'
            ELSE '<60'
        END as kategori,
        COUNT(*) jumlah
        FROM kalkulasi_penilaian
        GROUP BY kategori
        ");

        // Radar BerAKHLAK
        $indikator = DB::selectOne("
        SELECT
        AVG(col_01) ber,
        AVG(col_02) a1,
        AVG(col_03) k1,
        AVG(col_04) h,
        AVG(col_05) l,
        AVG(col_06) a2,
        AVG(col_07) k2
        FROM kalkulasi_penilaian
        ");

        // Top Pegawai
        $topPegawai = DB::select("
        SELECT
        pp.nama_pegawai,
        kp.total
        FROM kalkulasi_penilaian kp
        JOIN periode_pegawai pp
        ON pp.id_pegawai = kp.id_pegawai
        ORDER BY kp.total DESC
        LIMIT 10
        ");

        return response()->json([
            'progress' => [
                'sudah' => $sudahDinilai,
                'belum' => $belumDinilai
            ],
            'distribusi' => $distribusi,
            'indikator' => $indikator,
            'topPegawai' => $topPegawai
        ]);
    }
}