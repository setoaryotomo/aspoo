<?php
namespace App\Modules\Dashboard;

use App\Modules\Dashboard\Controller\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('/dashboard')->group(function() {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/komposisi',[DashboardController::class,'cekKomposisi']);  
});