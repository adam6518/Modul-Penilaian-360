<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekapPenilaianController extends Controller
{
    public function index()
    {
        return view('rekap-penilaian');
    }

    public function getPeriode()
    {
        return DB::select("
                SELECT id, nama_periode, tanggal_awal, tanggal_akhir
                FROM periode
                WHERE status = 1
                ORDER BY id DESC
            ");
    }

    /* ===============================
        DETAIL PER PERIODE (SATKER)
        =============================== */
    public function detail(int $periodeId)
    {
        $periode = DB::selectOne("
                SELECT id, nama_periode
                FROM periode
                WHERE id = ?
            ", [$periodeId]);

        return view('rekap-penilaian-detail', compact('periode'));
    }

    public function getSatker(int $periodeId)
    {
        logger('GET SATKER HIT', [
            'periodeId' => $periodeId
        ]);
        return DB::select("
                SELECT
                    pp.id_satker,
                    COUNT(DISTINCT pp.id_pegawai) AS jumlah_pegawai
                FROM periode_pegawai pp
                WHERE pp.id_periode = ?
                AND pp.status = 1
                GROUP BY pp.id_satker
                ORDER BY pp.id_satker
            ", [$periodeId]);
    }

    /* ===============================
        VIEW PEGAWAI
        =============================== */
    public function viewPegawai(int $periodeId, int $satkerId)
    {
        // return view('rekap-penilaian-view', compact('periodeId', 'satkerId'));
        $indikator = DB::select("
        SELECT id, referensi, kode
        FROM referensi
        WHERE jenis = 'penilaian'
          AND status = 1
        ORDER BY id
    ");

        return view('rekap-penilaian-view', compact(
            'periodeId',
            'satkerId',
            'indikator'
        ));
    }

    public function getPegawai(int $periodeId, int $satkerId)
    {
        return DB::select("
                SELECT
                pp.id_pegawai,
                pp.nama_pegawai,
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
            WHERE kp.id_periode = ?
            AND pp.id_satker = ?
            AND pp.status = 1
            ORDER BY kp.total DESC
            ", [$periodeId, $satkerId]);
    }

    /* ===============================
        KALKULASI PENILAIAN
        =============================== */
    public function kalkulasi(int $periodeId)
    {
        DB::beginTransaction();

        try {
            // reset
            DB::delete("
                DELETE FROM kalkulasi_penilaian
                WHERE id_periode = ?
            ", [$periodeId]);

            DB::insert("
                INSERT INTO kalkulasi_penilaian
(
    id_periode, id_pegawai,
    col_01, col_02, col_03, col_04, col_05, col_06, col_07,
    total
)
SELECT
    pn.id_periode,
    pn.id_ternilai,

    -- BER
    ROUND(
        SUM(pn.col_01 * rb.nilai) / SUM(rb.nilai),
    2),

    -- A
    ROUND(
        SUM(pn.col_02 * rb.nilai) / SUM(rb.nilai),
    2),

    -- K
    ROUND(
        SUM(pn.col_03 * rb.nilai) / SUM(rb.nilai),
    2),

    -- H
    ROUND(
        SUM(pn.col_04 * rb.nilai) / SUM(rb.nilai),
    2),

    -- L
    ROUND(
        SUM(pn.col_05 * rb.nilai) / SUM(rb.nilai),
    2),

    -- A
    ROUND(
        SUM(pn.col_06 * rb.nilai) / SUM(rb.nilai),
    2),

    -- K
    ROUND(
        SUM(pn.col_07 * rb.nilai) / SUM(rb.nilai),
    2),

    -- TOTAL = jumlah col_01 s/d col_07
    ROUND(
        (
            (SUM(pn.col_01 * rb.nilai) / SUM(rb.nilai)) +
            (SUM(pn.col_02 * rb.nilai) / SUM(rb.nilai)) +
            (SUM(pn.col_03 * rb.nilai) / SUM(rb.nilai)) +
            (SUM(pn.col_04 * rb.nilai) / SUM(rb.nilai)) +
            (SUM(pn.col_05 * rb.nilai) / SUM(rb.nilai)) +
            (SUM(pn.col_06 * rb.nilai) / SUM(rb.nilai)) +
            (SUM(pn.col_07 * rb.nilai) / SUM(rb.nilai))
        ),
    2)

FROM penilaian pn

JOIN periode_pegawai penilai
  ON penilai.id_pegawai = pn.id_penilai
 AND penilai.id_periode = pn.id_periode

JOIN periode_pegawai ternilai
  ON ternilai.id_pegawai = pn.id_ternilai
 AND ternilai.id_periode = pn.id_periode

JOIN referensi rb
  ON rb.jenis = 'bobot'
 AND rb.status = 1
 AND rb.referensi = CASE
        WHEN penilai.id_pegawai = ternilai.id_atasan THEN 'Atasan'
        WHEN penilai.id_atasan = ternilai.id_pegawai THEN 'Bawahan'
        ELSE 'Sejawat'
     END

WHERE pn.id_periode = ?
GROUP BY pn.id_ternilai, pn.id_periode;

            ", [$periodeId]);

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
