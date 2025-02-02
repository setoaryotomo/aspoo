<?php
namespace App\Modules\TransaksiBarang;

use App\Modules\TransaksiBarang\Controllers\TransaksiBarangController;
use Illuminate\Support\Facades\Route;

// USE MARKER (DONT DELETE THIS LINE)

Route::prefix('/transaksi-barang')->group(function() {

    // SUB MENU MARKER (DONT DELETE THIS LINE)

    Route::get('/', [TransaksiBarangController::class, 'index'])->middleware('authorize:read-transaksi_barang');
    Route::get('/datatable', [TransaksiBarangController::class, 'datatable'])->middleware('authorize:read-transaksi_barang');
    Route::get('/create', [TransaksiBarangController::class, 'create'])->middleware('authorize:create-transaksi_barang');
    Route::post('/', [TransaksiBarangController::class, 'store'])->middleware('authorize:create-transaksi_barang');
    Route::get('/{transaksi_barang_id}', [TransaksiBarangController::class, 'show'])->middleware('authorize:read-transaksi_barang');
    Route::get('/{transaksi_barang_id}/edit', [TransaksiBarangController::class, 'edit'])->middleware('authorize:update-transaksi_barang');
    Route::put('/{transaksi_barang_id}', [TransaksiBarangController::class, 'update'])->middleware('authorize:update-transaksi_barang');
    Route::delete('/{transaksi_barang_id}', [TransaksiBarangController::class, 'destroy'])->middleware('authorize:delete-transaksi_barang');
});