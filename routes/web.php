<?php

use App\Http\Controllers\MidtransController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\KaryawanController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use App\Modules\InputSCM\Controllers\AlamatController;
use App\Modules\InputSCM\Controllers\BahanController;
use App\Modules\InputSCM\Controllers\BarangController;
use App\Modules\InputSCM\Controllers\InputSCMController;
use App\Modules\InputSCM\Controllers\SupplierController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['auth'])->group(function () {
    require app_path('Modules/Dashboard/routes.php');
    require app_path('Modules/User/routes.php');
    require app_path('Modules/Menu/routes.php');
    require app_path('Modules/Role/routes.php');
    require app_path('Modules/Permission/routes.php');
    require app_path('Modules/Module/routes.php');
    require app_path('Modules/Penjualan/routes.php');
    require app_path('Modules/DataBarang/routes.php');
    require app_path('Modules/Diskon/routes.php');
    require app_path('Modules/Pembelian/routes.php');
    require app_path('Modules/Satuan/routes.php');
    require app_path('Modules/InputSCM/routes.php');
    require app_path('Modules/PortalUser/routes.php');
    require app_path('Modules/Slider/routes.php');
    require app_path('Modules/KategoriProduk/routes.php');
    require app_path('Modules/Keranjang/routes.php');
    require app_path('Modules/TransaksiBarang/routes.php');
    require app_path('Modules/ApproveUser/routes.php');
    require app_path('Modules/ApproveTransaksi/routes.php');
    require app_path('Modules/ValidasiTransaksi/routes.php');
    require app_path('Modules/KirimBarang/routes.php');
    require app_path('Modules/Komposisi/routes.php');
    require app_path('Modules/MasterUMKM/routes.php');
    require app_path('Modules/permintaanparcel/routes.php');
    require app_path('Modules/Cabang/routes.php');
    
    // ROUTE_MARKER
    // Add routes in the line below (DONT REMOVE THIS SECTION !!!!!!, because this line is LINE_MARKER used by Module Generator)
});


// Mengisikan Routing untuk portal
require base_path("routes/portal.php");

Route::get('/', function () {
    return redirect('/p');
})->name('home_utama');


// Callback Midtrans
Route::post('midtrans/callback', [MidtransController::class, 'callback']);

Route::get('/p/order', [OrderController::class, 'order']);
Route::post('/bayar', [OrderController::class, 'bayar']);
Route::get('/p/invoice/{id}', [OrderController::class, 'invoice']);

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
