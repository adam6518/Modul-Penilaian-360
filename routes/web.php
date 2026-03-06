<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\ReferensiController;
use App\Http\Controllers\PeriodePegawaiController;
use App\Http\Controllers\PenilaianBawahanController;
use App\Http\Controllers\PenilaianAtasanController;
use App\Http\Controllers\PenilaianSejawatController;
use App\Http\Controllers\RekapPenilaianController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardProfileController;
use App\Http\Controllers\StatistikController;

Route::get('/', [DashboardController::class, 'index']);

Route::get('/periode', [PeriodeController::class, 'index'])->name('periode.index');
Route::get('/periode/data', [PeriodeController::class, 'getData'])->name('periode.data');
Route::post('/periode/store', [PeriodeController::class, 'store'])->name('periode.store');
Route::post('/periode/update/{id}', [PeriodeController::class, 'update'])->name('periode.update');
Route::delete('/periode/delete/{id}', [PeriodeController::class, 'delete'])->name('periode.delete');

Route::get('/referensi', [ReferensiController::class, 'index'])->name('referensi.index');
Route::get('/referensi/data', [ReferensiController::class, 'getData']);
Route::post('/referensi/store', [ReferensiController::class, 'store']);
Route::post('/referensi/update/{id}', [ReferensiController::class, 'update']);
Route::delete('/referensi/delete/{id}', [ReferensiController::class, 'delete']);

Route::get('/periode-pegawai', [PeriodePegawaiController::class, 'index'])->name('periode-pegawai.index');
Route::get('/periode-pegawai/list', [PeriodePegawaiController::class, 'getPeriodeList']);
Route::get('/periode-pegawai/data', [PeriodePegawaiController::class, 'getData']);
// PROSES 1: SIMPAN DARI JSON KE DB
Route::post('/periode-pegawai/import', [PeriodePegawaiController::class, 'importFromJson']);

// PROSES 2: TAMPILKAN DARI DB
Route::get('/periode-pegawai/show', [PeriodePegawaiController::class, 'showByPeriode']);
Route::delete('/periode-pegawai/delete/{id}', [PeriodePegawaiController::class, 'destroy']);
// BULK DELETE PER PERIODE
Route::post(
    '/periode-pegawai/delete-periode',
    [PeriodePegawaiController::class, 'destroyByPeriode']
);
Route::post('/periode-pegawai/sync', [PeriodePegawaiController::class, 'sync']);

Route::get('/penilaian-bawahan', [PenilaianBawahanController::class, 'index'])->name('penilaian-bawahan.index');
Route::post('/penilaian-bawahan/store', [PenilaianBawahanController::class, 'store']);
Route::get(
    '/penilaian-bawahan/bawahan',
    [PenilaianBawahanController::class, 'getBawahanByPeriode']
);

Route::get('/penilaian-atasan', [PenilaianAtasanController::class, 'index'])->name('penilaian-atasan.index');
Route::post('/penilaian-atasan/store', [PenilaianAtasanController::class, 'store']);
Route::get('/penilaian-atasan/atasan', [PenilaianAtasanController::class, 'getAtasanByPeriode']);

Route::get('/penilaian-sejawat', [PenilaianSejawatController::class, 'index'])->name('penilaian-sejawat.index');
Route::post('/penilaian-sejawat/store', [PenilaianSejawatController::class, 'store']);
Route::get('/penilaian-sejawat/sejawat', [PenilaianSejawatController::class, 'getSejawatByPeriode']);

// REKAP PENILAIAN
Route::get('/rekap-penilaian', [RekapPenilaianController::class, 'index'])->name('rekap-penilaian.index');
Route::get('/rekap-penilaian/data', [RekapPenilaianController::class, 'getPeriode']);

// DETAIL PER PERIODE
Route::get('/rekap-penilaian/{periodeId}/data', [RekapPenilaianController::class, 'getSatker'])->whereNumber('periodeId');
Route::get('/rekap-penilaian/{periodeId}', [RekapPenilaianController::class, 'detail'])->whereNumber('periodeId');;

// VIEW PEGAWAI PER SATKER
Route::get(
    '/rekap-penilaian/{periodeId}/satker/{satkerId}',
    [RekapPenilaianController::class, 'viewPegawai']
);
Route::get(
    '/rekap-penilaian/{periodeId}/satker/{satkerId}/data',
    [RekapPenilaianController::class, 'getPegawai']
);

// KALKULASI (OPTIONAL – BUTTON ACTION)
Route::post(
    '/rekap-penilaian/{periodeId}/kalkulasi',
    [RekapPenilaianController::class, 'kalkulasi']
);

Route::get(
    '/rekap-penilaian/{periodeId}/export/excel',
    [RekapPenilaianController::class, 'exportExcel']
);

Route::get(
    '/rekap-penilaian/{periodeId}/satker/{satkerId}/export/pdf',
    [RekapPenilaianController::class, 'exportPdf']
);

// DASHBOARD PROFILE
Route::get(
    '/dashboard-profile',
    [DashboardProfileController::class, 'index']
)->name('dashboard-profile.index');

Route::post('/set-role', function (Request $request) {
    session(['role' => $request->role]);
    return response()->json(['success' => true]);
})->name('set-role');

// GLOBAL SESSION FOR LOGGED IN USER
Route::post('/set-active-user', function (Request $request) {
    session(['role' => $request->role]);

    if ($request->role === 'admin') {

        session()->forget('active_user_id');
        session()->forget('active_user_nama');
        session()->forget('active_user_nip');
    } else {

        $pegawai = DB::table('periode_pegawai')
            ->where('id_pegawai', $request->user_id)
            ->first();

        session([
            'active_user_id'   => $pegawai->id_pegawai,
            'active_user_nama' => $pegawai->nama_pegawai,
            'active_user_nip'  => $pegawai->nip,
        ]);
    }

    return response()->json(['success' => true]);
})->name('set-active-user');

// STATISTIK

Route::get('/statistik', [StatistikController::class, 'index'])
    ->name('statistik.index');

Route::get('/statistik/data', [StatistikController::class, 'getData']);