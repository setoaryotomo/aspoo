<?php

namespace App\Modules\User;

use App\Modules\User\Controller\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('/user')->group(function () {
    Route::withoutMiddleware(['auth'])->middleware('guest')->group(function () {
        Route::get('/login', [UserController::class, 'loginPage']);
        Route::post('/login', [UserController::class, 'login']);
    });

    Route::get('/', [UserController::class, 'index']);
    Route::get('/me', [UserController::class, 'me']);
    Route::get('/logout', [UserController::class, 'logout']);
    Route::get('/logout-web', [UserController::class, 'logoutWeb']);
    Route::get('/datatable', [UserController::class, 'datatable']);
    Route::get('/create', [UserController::class, 'create']);
    Route::post('/', [UserController::class, 'store']);
    Route::post('/{user_id}/role', [UserController::class, 'addRole']);
    Route::get('/{user_id}', [UserController::class, 'show']);
    Route::get('/{user_id}/role', [UserController::class, 'getRoles']);
    Route::get('/{user_id}/detail', [UserController::class, 'detail']);
    Route::get('/{user_id}/edit', [UserController::class, 'edit']);
    Route::put('/{user_id}', [UserController::class, 'update']);
    Route::delete('/{user_id}', [UserController::class, 'destroy']);
    Route::delete('/{user_id}/role/{role_id}', [UserController::class, 'removeRole']);
});
