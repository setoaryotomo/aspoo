<?php
namespace App\Modules\Satuan;

use App\Modules\Satuan\Controllers\SatuanController;
use Illuminate\Support\Facades\Route;

// USE MARKER (DONT DELETE THIS LINE)

Route::prefix('/satuan')->group(function() {

    Route::get('/all', [SatuanController::class, 'all']);
    // SUB MENU MARKER (DONT DELETE THIS LINE)
    Route::get('/', [SatuanController::class, 'index'])->middleware('authorize:read-satuan');
    Route::get('/datatable', [SatuanController::class, 'datatable'])->middleware('authorize:read-satuan');
    Route::get('/create', [SatuanController::class, 'create'])->middleware('authorize:create-satuan');
    Route::post('/', [SatuanController::class, 'store'])->middleware('authorize:create-satuan');
    Route::get('/{satuan_id}', [SatuanController::class, 'show'])->middleware('authorize:read-satuan');
    Route::get('/{satuan_id}/edit', [SatuanController::class, 'edit'])->middleware('authorize:update-satuan');
    Route::put('/{satuan_id}', [SatuanController::class, 'update'])->middleware('authorize:update-satuan');
    Route::delete('/{satuan_id}', [SatuanController::class, 'destroy'])->middleware('authorize:delete-satuan');
});