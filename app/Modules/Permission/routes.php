<?php

namespace App\Modules\Permission;

use App\Modules\Permission\Controller\PermissionController;
use Illuminate\Support\Facades\Route;

Route::prefix('/permission')->group(function () {
    Route::get('/', [PermissionController::class, 'index']);
    Route::get('/datatable', [PermissionController::class, 'datatable']);
    Route::get('/create', [PermissionController::class, 'create']);
    Route::post('/', [PermissionController::class, 'store']);
    Route::get('/{permission_id}', [PermissionController::class, 'show']);
    Route::get('/{permission_id}/detail', [PermissionController::class, 'detail']);
    Route::get('/{permission_id}/edit', [PermissionController::class, 'edit']);
    Route::put('/{permission_id}', [PermissionController::class, 'update']);
    Route::delete('/{permission_id}', [PermissionController::class, 'destroy']);
});
