<?php
namespace App\Modules\ApproveUser;

use App\Modules\ApproveUser\Controllers\ApproveUserController;
use Illuminate\Support\Facades\Route;

// USE MARKER (DONT DELETE THIS LINE)

Route::prefix('/approve-user')->group(function() {

    // SUB MENU MARKER (DONT DELETE THIS LINE)

    Route::get('/', [ApproveUserController::class, 'index'])->middleware('authorize:read-approve_user');
    Route::get('/datatable', [ApproveUserController::class, 'datatable'])->middleware('authorize:read-approve_user');
    Route::get('/create', [ApproveUserController::class, 'create'])->middleware('authorize:create-approve_user');
    Route::post('/approve/{id}', [ApproveUserController::class, 'approve'])->middleware('authorize:create-approve_user');
    Route::post('/', [ApproveUserController::class, 'store'])->middleware('authorize:create-approve_user');
    Route::get('/{approve_user_id}', [ApproveUserController::class, 'show'])->middleware('authorize:read-approve_user');
    Route::get('/{approve_user_id}/edit', [ApproveUserController::class, 'edit'])->middleware('authorize:update-approve_user');
    Route::put('/{approve_user_id}', [ApproveUserController::class, 'update'])->middleware('authorize:update-approve_user');
    Route::delete('/{approve_user_id}', [ApproveUserController::class, 'destroy'])->middleware('authorize:delete-approve_user');
});