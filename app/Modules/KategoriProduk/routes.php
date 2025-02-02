<?php
namespace App\Modules\KategoriProduk;

use App\Modules\KategoriProduk\Controllers\KategoriProdukController;
use Illuminate\Support\Facades\Route;

// USE MARKER (DONT DELETE THIS LINE)

Route::prefix('/kategoriproduk')->group(function() {

    // SUB MENU MARKER (DONT DELETE THIS LINE)

    Route::get('/', [KategoriProdukController::class, 'index'])->middleware('authorize:read-kategori_produk');
    Route::get('/datatable', [KategoriProdukController::class, 'datatable'])->middleware('authorize:read-kategori_produk');
    Route::get('/create', [KategoriProdukController::class, 'create'])->middleware('authorize:create-kategori_produk');
    Route::post('/', [KategoriProdukController::class, 'store'])->middleware('authorize:create-kategori_produk');
    Route::post('/setkategori', [KategoriProdukController::class, 'setkategori'])->middleware('authorize:create-kategori_produk');
    Route::get('/listkategori/{id}/datatable', [KategoriProdukController::class, 'listkategori'])->middleware('authorize:read-kategori_produk');
    Route::delete('/listkategori/{id}/{id_barang}', [KategoriProdukController::class, 'deletelistkategori'])->middleware('authorize:read-kategori_produk');

    
    Route::get('/{kategoriproduk_id}', [KategoriProdukController::class, 'show'])->middleware('authorize:read-kategori_produk');
    Route::get('/{kategoriproduk_id}/edit', [KategoriProdukController::class, 'edit'])->middleware('authorize:update-kategori_produk');
    Route::put('/{kategoriproduk_id}', [KategoriProdukController::class, 'update'])->middleware('authorize:update-kategori_produk');
    Route::delete('/{kategoriproduk_id}', [KategoriProdukController::class, 'destroy'])->middleware('authorize:delete-kategori_produk');
});