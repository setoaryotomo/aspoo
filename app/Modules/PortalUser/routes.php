<?php
namespace App\Modules\PortalUser;

use App\Modules\PortalUser\Controllers\PortalUserController;
use Illuminate\Support\Facades\Route;

// USE MARKER (DONT DELETE THIS LINE)

Route::prefix('/portaluser')->group(function() {

    // SUB MENU MARKER (DONT DELETE THIS LINE)

    Route::get('/', [PortalUserController::class, 'index'])->middleware('authorize:read-portaluser');
    Route::get('/datatable', [PortalUserController::class, 'datatable'])->middleware('authorize:read-portaluser');
    Route::get('/create', [PortalUserController::class, 'create'])->middleware('authorize:create-portaluser');
    Route::post('/', [PortalUserController::class, 'store'])->middleware('authorize:create-portaluser');
    Route::get('/{portaluser_id}', [PortalUserController::class, 'show'])->middleware('authorize:read-portaluser');
    Route::get('/{portaluser_id}/edit', [PortalUserController::class, 'edit'])->middleware('authorize:update-portaluser');
    Route::put('/{portaluser_id}', [PortalUserController::class, 'update'])->middleware('authorize:update-portaluser');
    Route::delete('/{portaluser_id}', [PortalUserController::class, 'destroy'])->middleware('authorize:delete-portaluser');
});