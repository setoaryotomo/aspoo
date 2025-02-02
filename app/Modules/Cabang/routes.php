<?php
namespace App\Modules\Cabang;

use App\Modules\Cabang\Controllers\CabangController;
use Illuminate\Support\Facades\Route;

// USE MARKER (DONT DELETE THIS LINE)

Route::prefix('/cabang')->group(function() {

    // SUB MENU MARKER (DONT DELETE THIS LINE)

    Route::get('/', [CabangController::class, 'index'])->middleware('authorize:read-cabang');
    Route::get('/datatable', [CabangController::class, 'datatable'])->middleware('authorize:read-cabang');
    Route::get('/create', [CabangController::class, 'create'])->middleware('authorize:create-cabang');
    Route::post('/', [CabangController::class, 'store'])->middleware('authorize:create-cabang');
    Route::get('/{cabang_id}', [CabangController::class, 'show'])->middleware('authorize:read-cabang');
    Route::get('/{cabang_id}/edit', [CabangController::class, 'edit'])->middleware('authorize:update-cabang');
    Route::put('/{cabang_id}', [CabangController::class, 'update'])->middleware('authorize:update-cabang');
    Route::delete('/{cabang_id}', [CabangController::class, 'destroy'])->middleware('authorize:delete-cabang');

    Route::get('/preview/{id}', [CabangController::class, 'preview'])->middleware('authorize:read-cabang');

});