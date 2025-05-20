<?php
namespace App\Modules\cabang;

use App\Modules\cabang\Controllers\cabangController;
use Illuminate\Support\Facades\Route;

// USE MARKER (DONT DELETE THIS LINE)

Route::prefix('/cabang')->group(function() {

    // SUB MENU MARKER (DONT DELETE THIS LINE)

    Route::get('/', [cabangController::class, 'index'])->middleware('authorize:read-cabang');
    Route::get('/datatable', [cabangController::class, 'datatable'])->middleware('authorize:read-cabang');
    Route::get('/create', [cabangController::class, 'create'])->middleware('authorize:create-cabang');
    Route::post('/', [cabangController::class, 'store'])->middleware('authorize:create-cabang');
    Route::get('/{cabang_id}', [cabangController::class, 'show'])->middleware('authorize:read-cabang');
    Route::get('/{cabang_id}/edit', [cabangController::class, 'edit'])->middleware('authorize:update-cabang');
    Route::put('/{cabang_id}', [cabangController::class, 'update'])->middleware('authorize:update-cabang');
    Route::delete('/{cabang_id}', [cabangController::class, 'destroy'])->middleware('authorize:delete-cabang');

    Route::get('/preview/{id}', [cabangController::class, 'preview'])->middleware('authorize:read-cabang');

});