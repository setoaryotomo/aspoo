<?php
namespace App\Modules\MasterUMKM;

use App\Modules\MasterUMKM\Controllers\MasterUMKMController;
use Illuminate\Support\Facades\Route;

// USE MARKER (DONT DELETE THIS LINE)

Route::prefix('/masterumkm')->group(function() {

    // SUB MENU MARKER (DONT DELETE THIS LINE)

    Route::get('/', [MasterUMKMController::class, 'index'])->middleware('authorize:read-master_umkm');
    Route::get('/datatable', [MasterUMKMController::class, 'datatable'])->middleware('authorize:read-master_umkm');
    Route::get('/create', [MasterUMKMController::class, 'create'])->middleware('authorize:create-master_umkm');
    Route::post('/', [MasterUMKMController::class, 'store'])->middleware('authorize:create-master_umkm');
    Route::get('/{masterumkm_id}', [MasterUMKMController::class, 'show'])->middleware('authorize:read-master_umkm');
    Route::get('/{masterumkm_id}/edit', [MasterUMKMController::class, 'edit'])->middleware('authorize:update-master_umkm');
    Route::put('/{masterumkm_id}', [MasterUMKMController::class, 'update'])->middleware('authorize:update-master_umkm');
    Route::delete('/{masterumkm_id}', [MasterUMKMController::class, 'destroy'])->middleware('authorize:delete-master_umkm');
});