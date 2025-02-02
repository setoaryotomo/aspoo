<?php
namespace App\Modules\Komposisi;

use App\Modules\InputSCM\Controllers\AlamatController;
use App\Modules\Komposisi\Controllers\KomposisiController;
use App\Modules\Komposisi\Controllers\KomposisiSupplierController;
use Illuminate\Support\Facades\Route;

// USE MARKER (DONT DELETE THIS LINE)

Route::prefix('/komposisi')->group(function() {

    // SUB MENU MARKER (DONT DELETE THIS LINE)
    Route::get('/supplier/datatable', [KomposisiSupplierController::class, 'datatable']);
    
    Route::prefix("/supplier/{kode_komposisi}")->group(function(){
        Route::get('/',[KomposisiSupplierController::class,'index']);    
        Route::get('/datatable', [KomposisiSupplierController::class, 'datatable_komposisi']);
        Route::get('/create', [KomposisiSupplierController::class, 'create']);
        Route::post('/create', [KomposisiSupplierController::class, 'store']);
        Route::delete('/{data_barang_id}', [KomposisiSupplierController::class, 'destroy']);
    });
    Route::prefix('/alamat')->group(function() {
        Route::get('/provinsi', [AlamatController::class, 'provinsi']);
        Route::get('/kota/{id}', [AlamatController::class, 'kota']);
        Route::get('/kecamatan/{id}', [AlamatController::class, 'kecamatan']);
        Route::get('/kelurahan/{id}', [AlamatController::class, 'kelurahan']);
    });
    Route::get('/', [KomposisiController::class, 'index'])->middleware('authorize:read-komposisi');
    Route::get('/all', [KomposisiController::class, 'all']);
    Route::get('/datatable', [KomposisiController::class, 'datatable'])->middleware('authorize:read-komposisi');
    Route::get('/create', [KomposisiController::class, 'create'])->middleware('authorize:create-komposisi');
    Route::post('/', [KomposisiController::class, 'store'])->middleware('authorize:create-komposisi');
    Route::get('/{komposisi_id}', [KomposisiController::class, 'show'])->middleware('authorize:read-komposisi');
    Route::get('/{komposisi_id}/edit', [KomposisiController::class, 'edit'])->middleware('authorize:update-komposisi');
    Route::put('/{komposisi_id}', [KomposisiController::class, 'update'])->middleware('authorize:update-komposisi');
    Route::delete('/{komposisi_id}', [KomposisiController::class, 'destroy'])->middleware('authorize:delete-komposisi');
});