<?php
namespace App\Modules\ValidasiTransaksi;

use App\Modules\ValidasiTransaksi\Controllers\ValidasiTransaksiController;
use Illuminate\Support\Facades\Route;

// USE MARKER (DONT DELETE THIS LINE)

Route::prefix('/validasi-transaksi')->group(function() {

    // SUB MENU MARKER (DONT DELETE THIS LINE)

    Route::get('/', [ValidasiTransaksiController::class, 'index'])->middleware('authorize:read-validasi_transaksi');
    Route::get('/datatable', [ValidasiTransaksiController::class, 'datatable'])->middleware('authorize:read-validasi_transaksi');
    Route::get('/create', [ValidasiTransaksiController::class, 'create'])->middleware('authorize:create-validasi_transaksi');
    Route::get('/preview/{kode}', [ValidasiTransaksiController::class, 'preview'])->middleware('authorize:create-validasi_transaksi');
    Route::post('/preview/{kode}/delete', [ValidasiTransaksiController::class, 'deletePreview'])->middleware('authorize:create-validasi_transaksi');
    Route::post('/preview/{kode}', [ValidasiTransaksiController::class, 'approve'])->middleware('authorize:create-validasi_transaksi');
    Route::post('/', [ValidasiTransaksiController::class, 'store'])->middleware('authorize:create-validasi_transaksi');
    Route::get('/{validasi_transaksi_id}', [ValidasiTransaksiController::class, 'show'])->middleware('authorize:read-validasi_transaksi');
    Route::get('/{validasi_transaksi_id}/edit', [ValidasiTransaksiController::class, 'edit'])->middleware('authorize:update-validasi_transaksi');
    Route::put('/{validasi_transaksi_id}', [ValidasiTransaksiController::class, 'update'])->middleware('authorize:update-validasi_transaksi');
    Route::delete('/{validasi_transaksi_id}', [ValidasiTransaksiController::class, 'destroy'])->middleware('authorize:delete-validasi_transaksi');
});