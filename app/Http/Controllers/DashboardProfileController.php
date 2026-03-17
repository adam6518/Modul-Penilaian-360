<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardProfileController extends Controller
{
    public function index()
    {
        $role = session('role', 'admin'); // default user kalau belum ada
        if ($role === 'admin') {
            return $this->adminDashboard();
        }

        return $this->userDashboard();
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN DASHBOARD
    |--------------------------------------------------------------------------
    */
    private function adminDashboard()
    {
        $page  = request()->get('page', 1);

        $cardPerRow  = 4;
        $rowPerPage  = 2;
        $limit       = $cardPerRow * $rowPerPage; // 8
        $offset      = ($page - 1) * $limit;

        /*
    |------------------------------------------------------------
    | Hitung total data
    |------------------------------------------------------------
    */
        $totalData = DB::selectOne("
        SELECT COUNT(*) as total
        FROM kalkulasi_penilaian
    ");

        /*
    |------------------------------------------------------------
    | Ambil data sesuai limit offset
    |------------------------------------------------------------
    */
        $pegawai = DB::select("
        SELECT
        pp.nama_pegawai,
        pp.nip,
        kp.col_01,
        kp.col_02,
        kp.col_03,
        kp.col_04,
        kp.col_05,
        kp.col_06,
        kp.col_07,
        kp.total
    FROM kalkulasi_penilaian kp
    JOIN periode_pegawai pp
    ON pp.id_pegawai = kp.id_pegawai
    AND pp.id_periode = kp.id_periode
    ORDER BY kp.total DESC
    LIMIT ? OFFSET ?
    ", [$limit, $offset]);

        $totalPage = ceil($totalData->total / $limit);

        /*
    |------------------------------------------------------------
    | Statistik summary
    |------------------------------------------------------------
    */
        $totalPegawai = DB::table('periode_pegawai')
            ->where('status', 1)
            ->count();

        $sudahDinilai = DB::table('kalkulasi_penilaian')
            ->distinct('id_pegawai')
            ->count('id_pegawai');

        $belumDinilai = $totalPegawai - $sudahDinilai;

        return view('dashboard-profile', [
            'role' => 'admin',
            'totalPegawai' => $totalPegawai,
            'sudahDinilai' => $sudahDinilai,
            'belumDinilai' => $belumDinilai,
            'pegawai' => $pegawai,
            'currentPage' => $page,
            'totalPage' => $totalPage
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | USER DASHBOARD
    |--------------------------------------------------------------------------
    */
    private function userDashboard()
    {
        $userId = session('active_user_id');
        if (!$userId) {
            return redirect()
                ->route('dashboard-profile.index')
                ->with('error', 'Silakan pilih user terlebih dahulu.');
        }

        $page  = request()->get('page', 1);

        $cardPerRow  = 4;
        $rowPerPage  = 2;
        $limit       = $cardPerRow * $rowPerPage; // 8
        $offset      = ($page - 1) * $limit;

        /*
    |------------------------------------------------------------
    | Hitung total data
    |------------------------------------------------------------
    */
        $totalData = DB::selectOne("
        SELECT COUNT(*) as total
        FROM kalkulasi_penilaian
    ");

        /*
    |------------------------------------------------------------
    | Ambil data sesuai limit offset
    |------------------------------------------------------------
    */
        $pegawai = DB::select("
        SELECT
            pp.nama_pegawai,
            pp.nip,
            (kp.col_01 + kp.col_02 + kp.col_03 + kp.col_04 +
             kp.col_05 + kp.col_06 + kp.col_07) AS nilai_berakhlak,
            kp.total
        FROM kalkulasi_penilaian kp
        JOIN periode_pegawai pp
          ON pp.id_pegawai = kp.id_pegawai
         AND pp.id_periode = kp.id_periode
        ORDER BY kp.total DESC
        LIMIT ? OFFSET ?
    ", [$limit, $offset]);

        $totalPage = ceil($totalData->total / $limit);


        /*
    |--------------------------------------------------------------------------
    | Ambil periode aktif (kalau ada konsep periode aktif)
    |--------------------------------------------------------------------------
    */
        $periode = DB::selectOne("
        SELECT id_periode as id
        FROM penilaian
        WHERE id_ternilai = ?
        ORDER BY id_periode DESC
        LIMIT 1
    ", [$userId]);

        if (!$periode) {
            $periode = DB::selectOne("
            SELECT id
            FROM periode
            WHERE status = 1
            ORDER BY id DESC
            LIMIT 1
            ");
        }

        if (!$periode) {
            return redirect()
                ->route('dashboard-profile.index')
                ->with('error', 'Silakan pilih user terlebih dahulu.');
        }

        $periodeId = $periode->id;

        /*
    |--------------------------------------------------------------------------
    | 1. Ambil nilai dia sendiri
    |--------------------------------------------------------------------------
    */
        $nilaiSaya = DB::selectOne("
       SELECT
        col_01,
        col_02,
        col_03,
        col_04,
        col_05,
        col_06,
        col_07,
        total
    FROM kalkulasi_penilaian
    WHERE id_periode = ?
      AND id_pegawai = ?
    ", [$periodeId, $userId]);

        /*
    |--------------------------------------------------------------------------
    | 2. Total yang harus dia nilai (atasan + bawahan + sejawat)
    |--------------------------------------------------------------------------
    */
        $totalHarusDinilai = DB::selectOne("
        SELECT COUNT(*) as total
        FROM periode_pegawai
        WHERE id_periode = ?
          AND id_pegawai != ?
          AND status = 1
    ", [$periodeId, $userId])->total;

        /*
    |--------------------------------------------------------------------------
    | 3. Jumlah yang sudah dia nilai
    |--------------------------------------------------------------------------
    */
        $sudahDinilai = DB::table('penilaian')
            ->where('id_periode', $periodeId)
            ->where('id_penilai', $userId)
            ->distinct('id_ternilai')
            ->count('id_ternilai');

        /*
    |--------------------------------------------------------------------------
    | 4. Jumlah orang yang menilai dia
    |--------------------------------------------------------------------------
    */
        $jumlahMenilaiSaya = DB::table('penilaian')
            ->where('id_periode', $periodeId)
            ->where('id_ternilai', $userId)
            ->distinct('id_penilai')
            ->count('id_penilai');

        $persen = $totalHarusDinilai > 0
            ? round(($sudahDinilai / $totalHarusDinilai) * 100)
            : 0;
        /*
    |--------------------------------------------------------------------------
    | 5. Jumlah orang yang harusnya menilai dia
    |--------------------------------------------------------------------------
    */
        $totalYangHarusMenilaiDia = DB::selectOne("
    SELECT COUNT(*) as total
    FROM periode_pegawai
    WHERE id_periode = ?
      AND id_pegawai != ?
      AND status = 1
", [$periodeId, $userId])->total;

        /*
    |--------------------------------------------------------------------------
    | 6. Jumlah orang yang dinilai saya
    |--------------------------------------------------------------------------
    */
        $hasilDinilaiSaya = DB::select("
    SELECT
        pp.nama_pegawai,
        pp.nip,
        (kp.col_01 + kp.col_02 + kp.col_03 + kp.col_04 +
         kp.col_05 + kp.col_06 + kp.col_07) AS nilai_berakhlak,
        kp.total
    FROM kalkulasi_penilaian kp
    JOIN periode_pegawai pp
      ON pp.id_pegawai = kp.id_pegawai
     AND pp.id_periode = kp.id_periode
    WHERE kp.id_periode = ?
      AND kp.id_pegawai = ?
", [$periodeId, $userId]);

        return view('dashboard-profile', [
            'role' => 'user',
            'nilaiSaya' => $nilaiSaya,
            'totalHarusDinilai' => $totalHarusDinilai,
            'sudahDinilai' => $sudahDinilai,
            'jumlahMenilaiSaya' => $jumlahMenilaiSaya,
            'persen' => $persen,
            'pegawai' => $pegawai,
            'totalPage' => $totalPage,
            'totalYangHarusMenilaiDia' => $totalYangHarusMenilaiDia,
            'hasilDinilaiSaya' => $hasilDinilaiSaya
        ]);
    }
}