<?php
namespace App\Modules\DataBarang;

use App\Modules\DataBarang\Controllers\DataBarangController;
use App\Modules\Komposisi\Controllers\KomposisiSupplierController;
use Illuminate\Support\Facades\Route;

// USE MARKER (DONT DELETE THIS LINE)

Route::prefix('/data-barang')->group(function() {

    Route::get('/all', [DataBarangController::class, 'all']);
    // SUB MENU MARKER (DONT DELETE THIS LINE)
    Route::prefix("/komposisi/{kode_barang}")->group(function(){
        Route::prefix("/supplier/{kode_komposisi}")->group(function(){
            Route::get('/',[KomposisiSupplierController::class,'index']);    
            Route::get('/datatable', [KomposisiSupplierController::class, 'datatable_komposisi']);
            Route::get('/create', [KomposisiSupplierController::class, 'create']);
            Route::post('/create', [KomposisiSupplierController::class, 'store']);
            Route::delete('/{data_barang_id}', [KomposisiSupplierController::class, 'destroy']);
        });
        Route::get('/',[DataBarangController::class,'komposisi_index']);    
        Route::get('/datatable', [DataBarangController::class, 'komposisi_datatable']);
        Route::get('/create', [DataBarangController::class, 'komposisi_create']);
        Route::post('/create', [DataBarangController::class, 'komposisi_store']);
        Route::delete('/{data_barang_id}', [DataBarangController::class, 'komposisi_destroy']);
    });
    Route::get('/', [DataBarangController::class, 'index'])->middleware('authorize:read-data_barang');
    Route::get('/view', [DataBarangController::class, 'view'])->middleware('authorize:read-data_barang');
    Route::get('/all', [DataBarangController::class, 'all']);
    Route::post('/find-kode-barang', [DataBarangController::class, 'findKodeBarang'])->middleware('authorize:read-data_barang');
    Route::get('/datatable', [DataBarangController::class, 'datatable'])->middleware('authorize:read-data_barang');
    Route::get('/create', [DataBarangController::class, 'create'])->middleware('authorize:create-data_barang');
    Route::post('/', [DataBarangController::class, 'store'])->middleware('authorize:create-data_barang');
    Route::get('/{data_barang_id}', [DataBarangController::class, 'show'])->middleware('authorize:read-data_barang');
    Route::get('/{data_barang_id}/edit', [DataBarangController::class, 'edit'])->middleware('authorize:update-data_barang');
    Route::post('/{data_barang_id}', [DataBarangController::class, 'update'])->middleware('authorize:update-data_barang');
    Route::delete('/{data_barang_id}', [DataBarangController::class, 'destroy'])->middleware('authorize:delete-data_barang');

    
});
