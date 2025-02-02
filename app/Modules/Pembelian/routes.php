<?php
namespace App\Modules\Pembelian;

use App\Modules\Pembelian\Controllers\PembelianController;
use Illuminate\Support\Facades\Route;

// USE MARKER (DONT DELETE THIS LINE)

Route::prefix('/pembelian')->group(function() {

    // SUB MENU MARKER (DONT DELETE THIS LINE)

    Route::get('/', [PembelianController::class, 'index'])->middleware('authorize:read-pembelian');
    Route::get('/datatable', [PembelianController::class, 'datatable'])->middleware('authorize:read-pembelian');
    Route::get('/create', [PembelianController::class, 'create'])->middleware('authorize:create-pembelian');
    Route::post('/', [PembelianController::class, 'store'])->middleware('authorize:create-pembelian');
    Route::get('/{pembelian_id}', [PembelianController::class, 'show'])->middleware('authorize:read-pembelian');
    Route::get('/{pembelian_id}/edit', [PembelianController::class, 'edit'])->middleware('authorize:update-pembelian');
    Route::put('/{pembelian_id}', [PembelianController::class, 'update'])->middleware('authorize:update-pembelian');
    Route::delete('/{pembelian_id}', [PembelianController::class, 'destroy'])->middleware('authorize:delete-pembelian');
});