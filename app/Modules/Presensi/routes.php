<?php
namespace App\Modules\Presensi;

use App\Modules\Presensi\Controllers\PresensiController;
use Illuminate\Support\Facades\Route;

use App\Modules\Presensi\Controllers\rekappresensiController;
use App\Modules\Presensi\Controllers\inputmanualController;
// USE MARKER (DONT DELETE THIS LINE)

Route::prefix('/presensi')->group(function() {

    Route::prefix('/rekap-presensi')->group(function() {
        Route::get('/', [rekappresensiController::class, 'index']);
    });
    Route::prefix('/input-manual')->group(function() {
        Route::get('/', [inputmanualController::class, 'index']);
    });
    // SUB MENU MARKER (DONT DELETE THIS LINE)

    Route::get('/', [PresensiController::class, 'index'])->middleware('authorize:read-presensi');
    Route::get('/datatable', [PresensiController::class, 'datatable'])->middleware('authorize:read-presensi');
    Route::get('/create', [PresensiController::class, 'create'])->middleware('authorize:create-presensi');
    Route::post('/', [PresensiController::class, 'store'])->middleware('authorize:create-presensi');
    Route::get('/{presensi_id}', [PresensiController::class, 'show'])->middleware('authorize:read-presensi');
    Route::get('/{presensi_id}/edit', [PresensiController::class, 'edit'])->middleware('authorize:update-presensi');
    Route::put('/{presensi_id}', [PresensiController::class, 'update'])->middleware('authorize:update-presensi');
    Route::delete('/{presensi_id}', [PresensiController::class, 'destroy'])->middleware('authorize:delete-presensi');
});