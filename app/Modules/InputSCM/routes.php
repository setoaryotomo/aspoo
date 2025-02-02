<?php
namespace App\Modules\InputSCM;

use App\Modules\InputSCM\Controllers\AlamatController;
use App\Modules\InputSCM\Controllers\BahanController;
use App\Modules\InputSCM\Controllers\BarangController;
use App\Modules\InputSCM\Controllers\InputSCMController;
use App\Modules\InputSCM\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

// USE MARKER (DONT DELETE THIS LINE)

Route::prefix('/input-scm')->group(function() {

    // SUB MENU MARKER (DONT DELETE THIS LINE)

    Route::get("/excel",[InputSCMController::class,'excel']);
    Route::get('/', [InputSCMController::class, 'index']);
    Route::get('/datatable', [InputSCMController::class, 'datatable']);
    Route::get('/create', [InputSCMController::class, 'create']);
    Route::post('/', [InputSCMController::class, 'store']);
    Route::get('/{input_scm_id}', [InputSCMController::class, 'show']);
    Route::get('/{input_scm_id}/edit', [InputSCMController::class, 'edit']);
    Route::post('/{input_scm_id}/edit', [InputSCMController::class, 'getEdit']);
    Route::post('/{input_scm_id}/edit/save', [InputSCMController::class, 'saveEdit']);

    Route::put('/{input_scm_id}', [InputSCMController::class, 'update']);
    Route::delete('/{input_scm_id}', [InputSCMController::class, 'destroy']);


    Route::prefix("/{id_umkm}")->group(function(){
        Route::get('/preview', [InputSCMController::class, 'preview']);

        Route::prefix("/barang")->group(function(){
            Route::get('/', [BarangController::class, 'index']);
            Route::get('/datatable', [BarangController::class, 'datatable']);
            Route::get('/create', [BarangController::class, 'create']);
            Route::post('/create', [BarangController::class, 'store']);
            Route::get('/{id_barang}', [BarangController::class, 'show']);
            Route::get('/{id_barang}/edit', [BarangController::class, 'edit']);
            Route::post('/{id_barang}/edit', [BarangController::class, 'getEdit']);
            Route::post('/{id_barang}/editsave', [BarangController::class, 'saveEdit']);
            
            Route::put('/{id_barang}', [BarangController::class, 'update']);
            Route::delete('/{id_barang}', [BarangController::class, 'destroy']);
        });
    });

    
    Route::prefix("/bahan")->group(function(){
            Route::prefix("/{id_barang}")->group(function(){
            Route::get('/', [BahanController::class, 'index']);
            Route::get('/datatable', [BahanController::class, 'datatable']);
            Route::get('/create', [BahanController::class, 'create']);
            Route::get('/create/datatable', [BahanController::class,'datatableSupplier']);
            Route::post('/create', [BahanController::class, 'store']);
            Route::get('/{id_bahan}', [BahanController::class, 'show']);
            Route::get('/{id_bahan}/edit', [BahanController::class, 'edit']);
            Route::post('/{id_bahan}/edit', [BahanController::class, 'getEdit']);
            Route::post('/{id_bahan}/edit/save', [BahanController::class, 'saveEdit']);
            
            Route::put('/{id_bahan}', [BahanController::class, 'update']);
            Route::delete('/{id_bahan}', [BahanController::class, 'destroy']);
        });
    });
     Route::prefix("/supplier")->group(function(){
        Route::prefix("/{id_bahan}")->group(function(){
        Route::get('/', [SupplierController::class, 'index']);
        Route::get('/datatable', [SupplierController::class, 'datatable']);
        Route::get('/create', [SupplierController::class, 'create']);
        Route::post('/create', [SupplierController::class, 'store']);
        Route::get('/{id_supplier}', [SupplierController::class, 'show']);
        Route::get('/{id_supplier}/edit', [SupplierController::class, 'edit']);
        Route::put('/{id_supplier}', [SupplierController::class, 'update']);
        Route::delete('/{id_supplier}', [SupplierController::class, 'destroy']);
        });
     });
    
  

    Route::prefix('/alamat')->group(function() {
        Route::get('/provinsi', [AlamatController::class, 'provinsi']);
        Route::get('/kota/{id}', [AlamatController::class, 'kota']);
        Route::get('/kecamatan/{id}', [AlamatController::class, 'kecamatan']);
        Route::get('/kelurahan/{id}', [AlamatController::class, 'kelurahan']);
    });
});
