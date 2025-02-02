<?php

namespace App\Modules\Role;

use App\Modules\Role\Controller\RoleController;
use Illuminate\Support\Facades\Route;

Route::prefix('/role')->group(function () {
    Route::get('/', [RoleController::class, 'index'])->middleware('authorize:read-role');
    Route::get('/datatable', [RoleController::class, 'datatable']);
    Route::get('/{role_id}/permission/datatable', [RoleController::class, 'permissionDatatable']);
    Route::get('/create', [RoleController::class, 'create']);
    Route::get('/all', [RoleController::class, 'all']);
    Route::post('/', [RoleController::class, 'store']);
    Route::post('/{role_id}/permission', [RoleController::class, 'addPermission']);
    Route::get('/{role_id}', [RoleController::class, 'show']);
    Route::get('/{role_id}/detail', [RoleController::class, 'detail']);
    Route::get('/{role_id}/edit', [RoleController::class, 'edit']);
    Route::put('/{role_id}', [RoleController::class, 'update']);
    Route::delete('/{role_id}', [RoleController::class, 'destroy']);
    Route::delete('/{role_id}/permission/{permission_id}', [RoleController::class, 'deletePermission']);
});
