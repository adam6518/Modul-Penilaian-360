<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\ReferensiController;
// use App\Http\Controllers\PenilaianController;

Route::get('/', function () {
    return view('dashboard');
});

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

// Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');