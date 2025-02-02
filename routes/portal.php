<?php

use App\Modules\Dashboard\Controller\DashboardController;
use App\Modules\PortalUser\Controllers\PortalUserController;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Route;

require app_path('Modules/Portal/routes.php');

Route::prefix("dummy")->group(function(){
    Route::get('/',[DashboardController::class,'dummyget']);

    Route::post('/',[DashboardController::class,'dummypost']);
});

Route::prefix("database")->group(function(){
    Route::get('/import',[DashboardController::class,'importdb']);
});