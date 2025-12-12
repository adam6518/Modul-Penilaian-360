<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeriodeController;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/periode', [PeriodeController::class, 'index'])->name('periode.index');

Route::get('/periode/data', [PeriodeController::class, 'getData'])->name('periode.data');
Route::post('/periode/store', [PeriodeController::class, 'store'])->name('periode.store');
Route::post('/periode/update/{id}', [PeriodeController::class, 'update'])->name('periode.update');
Route::delete('/periode/delete/{id}', [PeriodeController::class, 'delete'])->name('periode.delete');