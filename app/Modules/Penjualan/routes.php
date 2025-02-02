<?php
namespace App\Modules\Penjualan;

use App\Modules\Penjualan\Controllers\PenjualanController;
use Illuminate\Support\Facades\Route;

// USE MARKER (DONT DELETE THIS LINE)

Route::prefix('/penjualan')->group(function() {

    // SUB MENU MARKER (DONT DELETE THIS LINE)


    Route::get('/', [PenjualanController::class, 'redirectPos'])->middleware('authorize:read-penjualan');
    Route::get('/datatable', [PenjualanController::class, 'datatable'])->middleware('authorize:read-penjualan');
    Route::get('/create', [PenjualanController::class, 'create'])->middleware('authorize:create-penjualan');
    Route::post('/', [PenjualanController::class, 'store'])->middleware('authorize:create-penjualan');
    Route::post('/check-nomor-faktur', [PenjualanController::class, 'checkNomorFaktur'])->middleware('authorize:create-penjualan');
    Route::get('/{penjualan_id}', [PenjualanController::class, 'show'])->middleware('authorize:read-penjualan');
    Route::get('/{penjualan_id}/edit', [PenjualanController::class, 'edit'])->middleware('authorize:update-penjualan');
    Route::put('/{penjualan_id}', [PenjualanController::class, 'update'])->middleware('authorize:update-penjualan');
    Route::delete('/{penjualan_id}', [PenjualanController::class, 'destroy'])->middleware('authorize:delete-penjualan');
});