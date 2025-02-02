<?php
namespace App\Modules\Diskon;

use App\Modules\Diskon\Controllers\DiskonController;
use Illuminate\Support\Facades\Route;

// USE MARKER (DONT DELETE THIS LINE)

Route::prefix('/diskon')->group(function() {

    // SUB MENU MARKER (DONT DELETE THIS LINE)

    Route::get('/', [DiskonController::class, 'index'])->middleware('authorize:read-diskon');
    Route::get('/datatable', [DiskonController::class, 'datatable'])->middleware('authorize:read-diskon');
    Route::get('/create', [DiskonController::class, 'create'])->middleware('authorize:create-diskon');
    Route::post('/', [DiskonController::class, 'store'])->middleware('authorize:create-diskon');
    Route::get('/{diskon_id}', [DiskonController::class, 'show'])->middleware('authorize:read-diskon');
    Route::get('/{diskon_id}/edit', [DiskonController::class, 'edit'])->middleware('authorize:update-diskon');
    Route::put('/{diskon_id}', [DiskonController::class, 'update'])->middleware('authorize:update-diskon');
    Route::delete('/{diskon_id}', [DiskonController::class, 'destroy'])->middleware('authorize:delete-diskon');
});