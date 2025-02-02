<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\OrderController;
use App\Modules\DataBarang\Controllers\DataBarangController;
use App\Modules\Diskon\Controllers\DiskonController;
use App\Modules\Keranjang\Controllers\KeranjangController;
use App\Modules\Portal\Controller\PortalController;
use App\Modules\Satuan\Controllers\SatuanController;
use App\Modules\PortalUser\Controllers\PortalUserController;
use App\Modules\TransaksiBarang\Controllers\TransaksiBarangController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [PortalUserController::class, 'logout']);
    Route::get('/dashboard', [PortalController::class, 'dashboard']);
    Route::get('/kategoriproduk/{id}', [PortalController::class, 'listByKategoriProduk']);
    Route::get('/barang', [PortalController::class, 'searchBarang']);
    Route::get('/barang/{id}', [PortalController::class, 'detailBarang']);
    Route::prefix('/keranjang')->group(function() {
        Route::get('/', [KeranjangController::class, 'index']);
        Route::get('/datatable', [KeranjangController::class, 'datatable']);
        Route::get('/create', [KeranjangController::class, 'create']);
        Route::post('/', [KeranjangController::class, 'store']);
        Route::get('/{keranjang_id}', [KeranjangController::class, 'show']);
        Route::get('/{keranjang_id}/edit', [KeranjangController::class, 'edit']);
        Route::put('/{keranjang_id}', [KeranjangController::class, 'update']);
        Route::delete('/{keranjang_id}', [KeranjangController::class, 'destroy']);
    });
    Route::prefix('/transaksi')->group(function() {
        Route::get('/', [TransaksiBarangController::class, 'index']);
        Route::get('/datatable', [TransaksiBarangController::class, 'datatable']);
        Route::get('/create', [TransaksiBarangController::class, 'create']);
        Route::post('/', [TransaksiBarangController::class, 'store']);
        Route::get('/{transaksi_barang_id}', [TransaksiBarangController::class, 'show']);
        Route::get('/{transaksi_barang_id}/edit', [TransaksiBarangController::class, 'edit']);
        Route::put('/{transaksi_barang_id}', [TransaksiBarangController::class, 'update']);
        Route::delete('/{transaksi_barang_id}', [TransaksiBarangController::class, 'destroy']);
    });

});


Route::post('/register', [PortalUserController::class, 'store']);
Route::post('/login', [PortalUserController::class, 'login']);

Route::get('/data-barang',[DataBarangController::class,'datatable']);
Route::get('/diskon',[DiskonController::class,'datatable']);
Route::get('/satuan',[SatuanController::class,'datatable']);
Route::get('/KategoriBarang',[KategoriBarangController::class,'datatable']);

Route::post('/midtrans-callback', [OrderController::class, 'callback']);
