<?php
namespace App\Modules\Keranjang;

use App\Modules\Keranjang\Controllers\KeranjangController;
use Illuminate\Support\Facades\Route;

// USE MARKER (DONT DELETE THIS LINE)

Route::prefix('/keranjang')->group(function() {

    // SUB MENU MARKER (DONT DELETE THIS LINE)

    Route::get('/', [KeranjangController::class, 'index'])->middleware('authorize:read-keranjang');
    Route::get('/datatable', [KeranjangController::class, 'datatable'])->middleware('authorize:read-keranjang');
    Route::get('/create', [KeranjangController::class, 'create'])->middleware('authorize:create-keranjang');
    Route::post('/', [KeranjangController::class, 'store'])->middleware('authorize:create-keranjang');
    Route::get('/{keranjang_id}', [KeranjangController::class, 'show'])->middleware('authorize:read-keranjang');
    Route::get('/{keranjang_id}/edit', [KeranjangController::class, 'edit'])->middleware('authorize:update-keranjang');
    Route::put('/{keranjang_id}', [KeranjangController::class, 'update'])->middleware('authorize:update-keranjang');
    Route::delete('/{keranjang_id}', [KeranjangController::class, 'destroy'])->middleware('authorize:delete-keranjang');
});