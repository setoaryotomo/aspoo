<?php
namespace App\Modules\permintaanparcel;

use App\Modules\permintaanparcel\Controllers\permintaanparcelController;
use Illuminate\Support\Facades\Route;

// USE MARKER (DONT DELETE THIS LINE)

Route::prefix('/permintaan-parcel')->group(function() {

    // SUB MENU MARKER (DONT DELETE THIS LINE)

    Route::get('/', [permintaanparcelController::class, 'index'])->middleware('authorize:read-permintaan_parcel');
    Route::get('/datatable', [permintaanparcelController::class, 'datatable'])->middleware('authorize:read-permintaan_parcel');
    Route::get('/create', [permintaanparcelController::class, 'create'])->middleware('authorize:create-permintaan_parcel');
    Route::post('/', [permintaanparcelController::class, 'store'])->middleware('authorize:create-permintaan_parcel');
    Route::get('/{permintaan_parcel_id}', [permintaanparcelController::class, 'show'])->middleware('authorize:read-permintaan_parcel');
    Route::get('/{permintaan_parcel_id}/edit', [permintaanparcelController::class, 'edit'])->middleware('authorize:update-permintaan_parcel');
    Route::put('/{permintaan_parcel_id}', [permintaanparcelController::class, 'update'])->middleware('authorize:update-permintaan_parcel');
    Route::delete('/{permintaan_parcel_id}', [permintaanparcelController::class, 'destroy'])->middleware('authorize:delete-permintaan_parcel');

    Route::get('/preview/{id}', [permintaanparcelController::class, 'preview'])->middleware('authorize:read-permintaan_parcel');
    Route::post('/save-selected-items/{id}', [permintaanparcelController::class, 'saveSelectedItems'])->name('save-selected-items');

});