<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\ReferensiController;
// use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PeriodePegawaiController;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/periode', [PeriodeController::class, 'index'])->name('periode.index');
Route::get('/periode/data', [PeriodeController::class, 'getData'])->name('periode.data');
Route::post('/periode/store', [PeriodeController::class, 'store'])->name('periode.store');
Route::post('/periode/update/{id}', [PeriodeController::class, 'update'])->name('periode.update');
Route::delete('/periode/delete/{id}', [PeriodeController::class, 'delete'])->name('periode.delete');
// Route::get('/periode/list', [PeriodeController::class, 'getList']);

// Route::get('/periode', [PeriodeController::class, 'index']);
// Route::post('/periode', [PeriodeController::class, 'store']);
// Route::put('/periode/{id}', [PeriodeController::class, 'update']);
// Route::delete('/periode/{id}', [PeriodeController::class, 'delete']);

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
// Route::post('/periode-pegawai/store', [PeriodePegawaiController::class, 'store']);
// Route::post('/periode-pegawai/update/{id}', [PeriodePegawaiController::class, 'update']);
// Route::post('/periode-pegawai/delete/{id}', [PeriodePegawaiController::class, 'delete']);