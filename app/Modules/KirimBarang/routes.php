<?php
namespace App\Modules\KirimBarang;

use App\Modules\KirimBarang\Controllers\KirimBarangController;
use Illuminate\Support\Facades\Route;

// USE MARKER (DONT DELETE THIS LINE)

Route::prefix('/kirim-barang')->group(function() {

    // SUB MENU MARKER (DONT DELETE THIS LINE)

    Route::get('/', [KirimBarangController::class, 'index'])->middleware('authorize:read-kirim_barang');
    Route::get('/datatable', [KirimBarangController::class, 'datatable'])->middleware('authorize:read-kirim_barang');
    Route::get('/create', [KirimBarangController::class, 'create'])->middleware('authorize:create-kirim_barang');
    Route::post('/', [KirimBarangController::class, 'store'])->middleware('authorize:create-kirim_barang');
    Route::get('/preview/{kode}', [KirimBarangController::class, 'preview'])->middleware('authorize:create-kirim_barang');
    Route::post('/preview/', [KirimBarangController::class, 'postPreview'])->middleware('authorize:create-kirim_barang');
    Route::post('/preview/{kode}/tolak', [KirimBarangController::class, 'tolak'])->middleware('authorize:create-kirim_barang');
    Route::get('/{kirim_barang_id}', [KirimBarangController::class, 'show'])->middleware('authorize:read-kirim_barang');
    Route::get('/{kirim_barang_id}/edit', [KirimBarangController::class, 'edit'])->middleware('authorize:update-kirim_barang');
    Route::put('/{kirim_barang_id}', [KirimBarangController::class, 'update'])->middleware('authorize:update-kirim_barang');
    Route::delete('/{kirim_barang_id}', [KirimBarangController::class, 'destroy'])->middleware('authorize:delete-kirim_barang');
});