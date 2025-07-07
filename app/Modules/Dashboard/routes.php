<?php
namespace App\Modules\Dashboard;

use App\Modules\Dashboard\Controller\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('/dashboard')->group(function() {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/komposisi',[DashboardController::class,'cekKomposisi']);  
    Route::get('/transaction-data', [DashboardController::class, 'getTransactionData']);
    Route::get('/laporan-penjualan', [DashboardController::class, 'laporanPenjualan'])->name('laporan.penjualan');
    Route::get('/laporan-penjualan-admin', [DashboardController::class, 'laporanPenjualanAdmin'])->name('laporan.penjualan.admin');
    Route::get('/export-pdf', [DashboardController::class, 'exportPdf'])
    ->name('laporan.penjualan.export.pdf')
    ->middleware('auth');
});