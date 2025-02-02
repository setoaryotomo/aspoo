<?php
namespace App\Modules\Slider;

use App\Modules\Slider\Controllers\SliderController;
use Illuminate\Support\Facades\Route;

// USE MARKER (DONT DELETE THIS LINE)

Route::prefix('/slider')->group(function() {

    // SUB MENU MARKER (DONT DELETE THIS LINE)

    Route::get('/', [SliderController::class, 'index'])->middleware('authorize:read-silder');
    Route::get('/datatable', [SliderController::class, 'datatable'])->middleware('authorize:read-silder');
    Route::get('/create', [SliderController::class, 'create'])->middleware('authorize:create-silder');
    Route::post('/', [SliderController::class, 'store'])->middleware('authorize:create-silder');
    Route::get('/{slider_id}', [SliderController::class, 'show'])->middleware('authorize:read-silder');
    Route::get('/{slider_id}/edit', [SliderController::class, 'edit'])->middleware('authorize:update-silder');
    Route::put('/{slider_id}', [SliderController::class, 'update'])->middleware('authorize:update-silder');
    Route::delete('/{slider_id}', [SliderController::class, 'destroy'])->middleware('authorize:delete-silder');
});