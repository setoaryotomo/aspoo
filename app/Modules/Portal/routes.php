<?php

namespace App\Modules\Portal;

use App\Modules\DataBarang\Models\DataBarang;
use App\Modules\InputSCM\Models\Alamat\Kota;
use App\Modules\permintaanparcel\Controllers\permintaanparcelController;
use Illuminate\Support\Facades\Route;
use App\Modules\Portal\Controller\PortalController;
use App\Modules\PortalUser\Controllers\PortalUserController;
use App\Modules\User\Controller\UserController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;

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
    Route::post('/save-to-cart', [PortalController::class, 'saveToCart'])->name('save.to.cart');
    Route::get('/keranjang', [PortalController::class, 'keranjang'])->name('keranjang');
    Route::get('/api/barang', [PortalController::class, 'apibarang']);

    // Route::get('/send-wa', [PortalController::class, 'send-wa']);
    // Route::get('send-wa', function(){
    //     $response = Http::withHeaders([
    //         'Authorization' => 'RNnk34zGgGPPxF7KLn8L',
    //     ])->post('https://api.fonnte.com/send', [
    //         'target' => '085747215411',
    //         'message' => 'Haloo',
    //     ]);

    //     dd(json_decode($response, true));
    // });

    // Route::get('/api/barang', function() {
    //     $barang = DataBarang::with(['user', 'user.detail', 'user.detail.kotaModel'])
    //         ->where('berat', '>', 0)
    //         // ->where('kategori_umum', '!=', '')
    //         // ->where('bahan_dasar', '!=', '')
    //         // ->where('basah_kering', '!=', '')
    //         // ->where('rasa', '!=', '')
    //         // ->where('produsen', '!=', '')
    //         ->get();
            
    //     return response()->json([
    //         'success' => true,
    //         'data' => $barang->map(function($item) {
    //             return [
    //                 'id' => $item->id,
    //                 'nama_barang' => $item->nama_barang,
    //                 'harga_user' => $item->harga_user,
    //                 'berat' => $item->berat,
    //                 'kategori_umum' => $item->kategori_umum,
    //                 'bahan_dasar' => $item->bahan_dasar,
    //                 'basah_kering' => $item->basah_kering,
    //                 'rasa' => $item->rasa,
    //                 'produsen' => $item->produsen,
    //                 'thumbnail_readable' => $item->thumbnail_readable ? URL::asset($item->thumbnail_readable) : null,
    //                 'user' => [
    //                     'nama' => $item->user->nama,
    //                     'detail' => [
    //                         'kotaModel' => [
    //                             'name' => $item->user->detail->kotaModel->name ?? 'Unknown'
    //                         ]
    //                     ]
    //                 ]
    //             ];
    //         })
    //     ]);
    // });

    Route::get('/parcel/search', [ParcelController::class, 'searchbarangparcel'])->name('parcel.search');
    // Route::post('/save-selected-items/{id}', [permintaanparcelController::class, 'saveSelectedItems'])->name('save-selected-items');
    Route::post('/permintaan-parcel/save-selected-items/{id}', [permintaanparcelController::class, 'saveSelectedItems']);
    Route::post('/parcel/{id}/review', [PortalController::class, 'submitParcelReview'])->name('parcel.review');

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

    Route::get('/kota/{id}', function ($id) {
        $kota = Kota::find($id);
        return response()->json([
            'rajaongkir_city' => $kota->rajaongkir_city,
            'rajaongkir_postal' => $kota->rajaongkir_postal
        ]);
    });
    
    
    Route::get("/status/{kode}",[PortalController::class,"statuspengiriman"]);
 
    Route::post("/user-role",[PortalController::class,"getRolesUser"]);

    Route::get("/logout",[UserController::class,"logoutWeb"]);
});
