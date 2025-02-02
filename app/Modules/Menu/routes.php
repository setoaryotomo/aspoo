<?php
namespace App\Modules\Menu;

use App\Modules\Menu\Controller\MenuController;
use Illuminate\Support\Facades\Route;
Route::prefix('/menu')->group(function() {
    Route::get('/', [MenuController::class, 'index']);
    Route::get('/parents', [MenuController::class, 'parentList']);
    Route::get('/all', [MenuController::class, 'all']);
    Route::get('/mine', [MenuController::class, 'mine']);
    Route::get('/datatable', [MenuController::class, 'datatable']);
    Route::get('/create', [MenuController::class, 'create']);
    Route::post('/', [MenuController::class, 'store']);
    Route::get('/{menu_id}', [MenuController::class, 'show']);
    Route::get('/{menu_id}/detail', [MenuController::class, 'detail']);
    Route::get('/{menu_id}/edit', [MenuController::class, 'edit']);
    Route::get('/{menu_id}/permissions', [MenuController::class, 'permissions']);
    Route::put('/{menu_id}', [MenuController::class, 'update']);
    Route::delete('/{menu_id}', [MenuController::class, 'destroy']);
});