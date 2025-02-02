<?php
namespace App\Modules\Module;

use App\Modules\Menu\Controller\MenuController;
use App\Modules\Module\Controller\ModuleController;
use Illuminate\Support\Facades\Route;
Route::prefix('/module')->group(function() {
    Route::get('/', [ModuleController::class, 'index']);
    Route::get('/all', [ModuleController::class, 'all']);
    Route::get('/datatable', [ModuleController::class, 'datatable']);
    Route::get('/create', [ModuleController::class, 'create']);
    Route::post('/', [ModuleController::class, 'store']);
    Route::get('/{menu_id}', [MenuController::class, 'show']);
    Route::get('/{menu_id}/detail', [MenuController::class, 'detail']);
    Route::get('/{menu_id}/edit', [MenuController::class, 'edit']);
    Route::put('/{menu_id}', [MenuController::class, 'update']);
});