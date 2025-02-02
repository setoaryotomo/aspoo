<?php

namespace App\Modules\Portal;

use App\Modules\permintaanparcel\Controllers\permintaanparcelController;
use Illuminate\Support\Facades\Route;
use App\Modules\Portal\Controller\PortalController;
use App\Modules\PortalUser\Controllers\PortalUserController;
use App\Modules\User\Controller\UserController;

Route::prefix('/p')->group(function () {
    Route::post("/fetch-login",[PortalController::class,"fetchLogin"]);
    Route::get("/fetch-login",[PortalController::class,"fetchLogin"]);
    Route::get("/",[PortalController::class,"index"]);
    Route::get('/index-data',[PortalController::class,'dashboard']);
    Route::get("/login",[PortalController::class,"login"]);
    Route::post("/login",[PortalUserController::class, 'login']);
    Route::get("/registrasi",[PortalController::class,"registrasi"]);
    Route::post("/registrasi",[PortalUserController::class, 'store']);
    Route::get("/status",[PortalController::class,"statuspengiriman"]);
    Route::get("/infotoko",[PortalController::class,"infotoko"]);
    Route::get("/daftartransaksi",[PortalController::class,"daftartransaksi"]);
    Route::get("/daftarparcel",[PortalController::class,"daftarparcel"]);
    Route::post('/updatestatus', [PortalController::class,"updatestatus"])->name('update.status');
    Route::post('/updatestatusgagal', [PortalController::class,"updatestatusgagal"])->name('update.status.gagal');
    Route::get("/detailproduk",[PortalController::class,"detailproduk"]);
    Route::get("/toko", [PortalController::class, "toko"]);
    Route::get("/ratingdanulasan",[PortalController::class,"ratingdanulasan"]);
    Route::get("/listbarang",[PortalController::class,"listbarang"]);
    Route::get("/listtoko",[PortalController::class,"listtoko"]);
    Route::get("/listparcel",[PortalController::class,"listparcel"]);
    Route::get("/paketparcel",[PortalController::class,"paketparcel"]);
    Route::get("/kebijakan",[PortalController::class,"kebijakan"]);
    Route::get("/tentangaspoomarket",[PortalController::class,"tentangaspoomarket"]);
    Route::get("/cekongkir",[PortalController::class,"cekongkir"]);
    Route::post("/cekongkir",[PortalController::class,"cekHasil"]);
    Route::get("/pesanparcel",[PortalController::class,"pesanparcel"]);
    Route::post("/pesanparcel",[PortalController::class,"kirimpesanparcel"])->name('parcel.store');
    Route::get('/bayarparcel', [PortalController::class, 'paymentparcel'])->name('paymentparcel');

    Route::get('/parcel/search', [ParcelController::class, 'searchbarangparcel'])->name('parcel.search');
    // Route::post('/save-selected-items/{id}', [permintaanparcelController::class, 'saveSelectedItems'])->name('save-selected-items');
    Route::post('/permintaan-parcel/save-selected-items/{id}', [permintaanparcelController::class, 'saveSelectedItems']);

    Route::prefix("toko")->group(function(){
        Route::get("/", [PortalController::class, "toko"]);
        Route::get('/{id}', [PortalController::class, 'toko']); 
        Route::post('/follow-toko/{tokoId}', [PortalController::class, 'followToko'])->name('follow-toko');
    });

    Route::prefix("paketparcel")->group(function(){
        Route::get("/", [PortalController::class, "paketparcel"]);
        Route::get('/{id}', [PortalController::class, 'paketparcel']); 
    });

    Route::get("/cari",[PortalController::class,'getCari']);
    Route::prefix("barang")->group(function(){
        Route::get('/check',[PortalController::class,'checkBarang']);
        Route::post('/keranjang',[PortalController::class,'postKeranjang']);
        Route::get('/cetak-printer',[PortalController::class,'cetakPrinter']);
        Route::get('/{id}',[PortalController::class,'getBarang']);

    });
    Route::prefix("checkout")->group(function(){
        Route::get("/",[PortalController::class,"checkout"]);
        Route::post("/",[PortalController::class,"postCheckout"]);
        Route::post("/rajaongkir",[PortalController::class,"cekHasil"]);
        Route::get('/success',[PortalController::class,'setelahcheckout']);

    });
    Route::prefix("keranjang")->group(function(){
        Route::get("/",[PortalController::class,"keranjang"]);
        Route::post("/",[PortalController::class,"postKeranjangToCheckout"]);
        Route::delete("/{id}",[PortalController::class,"deleteKeranjang"]);
        Route::post("/data",[PortalController::class,"getKeranjangData"]);
    });

    Route::prefix("profile")->group(function(){
        Route::get("/",[PortalController::class,"profile"]);
        Route::post("/",[PortalController::class,"updateProfile"]);
        Route::get("/data",[PortalController::class,"getDataProfile"]);
    });

    Route::prefix('api')->group(function () {
        Route::post('/getkota', [PortalController::class, 'getkota'])->name('getkota.fetch');
        Route::post('/getkecamatan', [PortalController::class, 'getkecamatan'])->name('getkecamatan.fetch');
        Route::post('/getkelurahan', [PortalController::class, 'getkelurahan'])->name('getkelurahan.fetch');
    });
    
    Route::get("/status/{kode}",[PortalController::class,"statuspengiriman"]);
 
    Route::post("/user-role",[PortalController::class,"getRolesUser"]);

    Route::get("/logout",[UserController::class,"logoutWeb"]);
});
