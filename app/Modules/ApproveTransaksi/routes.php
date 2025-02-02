<?php
namespace App\Modules\ApproveTransaksi;

use App\Modules\ApproveTransaksi\Controllers\ApproveTransaksiController;
use Illuminate\Support\Facades\Route;

// USE MARKER (DONT DELETE THIS LINE)

Route::prefix('/approve-transaksi')->group(function() {

    // SUB MENU MARKER (DONT DELETE THIS LINE)


    
    Route::get('/', [ApproveTransaksiController::class, 'index'])->middleware('authorize:read-approve_transaksi');
    Route::get('/datatable', [ApproveTransaksiController::class, 'datatable'])->middleware('authorize:read-approve_transaksi');
    Route::get('/create', [ApproveTransaksiController::class, 'create'])->middleware('authorize:create-approve_transaksi');
    Route::post('/', [ApproveTransaksiController::class, 'store'])->middleware('authorize:create-approve_transaksi');
    Route::get('/preview/{id}',[ApproveTransaksiController::class,'preview'])->middleware('authorize:read-approve_transaksi');
    Route::post('/preview/{id}/tolak',[ApproveTransaksiController::class,'tolak'])->middleware('authorize:read-approve_transaksi');
    Route::post('/preview',[ApproveTransaksiController::class,'postPreview'])->middleware('authorize:read-approve_transaksi');
    Route::get('/{approve_transaksi_id}', [ApproveTransaksiController::class, 'show'])->middleware('authorize:read-approve_transaksi');
    Route::get('/{approve_transaksi_id}/edit', [ApproveTransaksiController::class, 'edit'])->middleware('authorize:update-approve_transaksi');
    Route::put('/{approve_transaksi_id}', [ApproveTransaksiController::class, 'update'])->middleware('authorize:update-approve_transaksi');
    Route::delete('/{approve_transaksi_id}', [ApproveTransaksiController::class, 'destroy'])->middleware('authorize:delete-approve_transaksi');
});