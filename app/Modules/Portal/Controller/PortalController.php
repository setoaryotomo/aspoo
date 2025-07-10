<?php

namespace App\Modules\Portal\Controller;

use App\Handler\FileHandler;
use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Models\ParcelChildren;
use App\Models\User;
use App\Modules\ApproveTransaksi\Models\Pengiriman;
use App\Modules\DataBarang\Models\DataBarang;
use App\Modules\InputSCM\Models\Alamat\Kecamatan;
use App\Modules\InputSCM\Models\Alamat\Kelurahan;
use App\Modules\InputSCM\Models\Alamat\Kota;
use App\Modules\InputSCM\Models\Alamat\Provinsi;
use App\Modules\KategoriProduk\Models\KategoriProduk;
use App\Modules\KategoriProduk\Models\PivotKategoriProduk;
use App\Modules\Keranjang\Models\Keranjang;
use App\Modules\MasterUMKM\Models\MasterUMKM;
use App\Modules\Pembelian\Repositories\WatZapRepository;
use App\Modules\Penjualan\Models\Pengikut;
use App\Modules\permintaanparcel\Models\permintaanparcel;
use App\Modules\Portal\Model\Rekening;
use App\Modules\Portal\Model\TransaksiMaster;
use App\Modules\Portal\Model\UserDetail;
use App\Modules\Portal\Model\UserPortal;
use App\Modules\PortalUser\Models\TokoUser;
use App\Modules\Slider\Models\Slider;
use App\Modules\TransaksiBarang\Models\TransaksiBarang;
use App\Modules\TransaksiBarang\Models\TransaksiBarangChildren;
use App\Modules\User\Model\UserModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Midtrans\Config;
use Midtrans\Snap;

class PortalController extends Controller
{
    public function cetakPrinter(Request $request)
    {
        return view('Portal::transaksi.cetakprinter');
    }
    public function checkBarang(Request $request)
    {
        $barang = DataBarang::find($request->barcode);
        return JsonResponseHandler::setResult($barang)->send();
    }
    public function deleteKeranjang(Request $request, $id)
    {
        $delete = Keranjang::where("id", $id)->where('user_id', Auth::user()->id);
        if ($delete) {
            $delete->delete();
        } else {
            $delete = "Barang di keranjang tidak ditemukan";
        }
        return JsonResponseHandler::setResult($delete)->send();
    }
    public function updateKeranjang(Request $request, $id)
    {
        // Your update logic here
        $keranjang = Keranjang::findOrFail($id);
        $keranjang->update($request->only(['jumlah']));

        return response()->json(['message' => 'Cart updated successfully']);
    }
    public function postKeranjangToCheckout(Request $request)
{
    $datas = json_decode($request->data);
    $userId = Auth::user()->id;

    // Validate selected items
    if (!isset($datas->data_keranjang) || empty($datas->data_keranjang)) {
        return JsonResponseHandler::setResult('No items selected for checkout.')->setCode(400)->send();
    }

    // Update quantities for selected items and verify they belong to the user
    $validItems = [];
    foreach ($datas->data_keranjang as $data) {
        $keranjang = Keranjang::where('id', $data->id)->where('user_id', $userId)->first();
        if ($keranjang) {
            $keranjang->jumlah = $data->jumlah;
            $keranjang->save();
            $validItems[] = $data;
        }
    }

    if (empty($validItems)) {
        return JsonResponseHandler::setResult('No valid items found for checkout.')->setCode(400)->send();
    }

    // Store validated selected items in session
    Session::put('checkout_keranjang', $validItems);

    return JsonResponseHandler::setResult(true)->send();
}
    public function getKeranjangData()
    {
        $user = Auth::user();
        $keranjang = Keranjang::where("user_id", $user->id)->with("barang")->get();
        return JsonResponseHandler::setResult($keranjang)->send();
    }

    public function getRolesUser()
    {
        return JsonResponseHandler::setResult(2)->send();
    }
    public function detailBarang($id)
    {
        $data = DataBarang::where('id', $id)->with(['satuan', 'foto'])->get();
        return JsonResponseHandler::setResult($data)->send();
    }

    public function postKeranjang(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        $keranjang = Keranjang::create($data);

        if ($keranjang) {
            return JsonResponseHandler::setMessage("SUCCESS")->setResult($keranjang)->send();
        } else {
            return JsonResponseHandler::setMessage("ERROR")->send();
        }
    }

    public function searchBarang(Request $request)
    {
        $payload = $request->input('nama');
        $data = DataBarang::where('nama_barang', 'LIKE', "%" . $payload . "%")->with(['satuan', 'foto'])->get();
        return JsonResponseHandler::setResult($data)->send();
    }
    public function listByKategoriProduk($id)
    {
        $data = PivotKategoriProduk::where('kategori_produk_id', $id)->with(['barang'])->get();
        return JsonResponseHandler::setResult($data)->send();
    }

    public function getCari(Request $request)
    {
        $q = $request->input('q');
        $tipe = $request->input('tipe');
        $category = DataBarang::select('kategori_umum')->distinct()->get();

        // Hanya jalankan pencarian jika nilai 'q' tidak kosong
        if (!empty($q)) {
            if ($tipe == 'barang') {
                $results = DataBarang::where("nama_barang", "LIKE", "%" . $q . "%")->get();
                return view('Portal::cari.cari', compact('results', 'q', 'tipe','category'));
            } 
            // elseif ($tipe == 'toko') {
            // $results = TokoUser::where("nama", "LIKE", "%" . $q . "%")->with(['user', 'user.kotaModel'])->get();
            // return view('Portal::cari.caritoko', compact('results', 'q', 'tipe'));
            // } 
            else {
                // Handle jenis pencarian yang tidak valid
                return redirect()->back()->with('error', 'Jenis pencarian tidak valid.');
            }
        } else {
            // Handle jika nilai 'q' kosong
            return redirect()->back()->with('error', 'Kata kunci pencarian tidak boleh kosong.');
        }
    }



    public function getDataProfile(Request $request)
    {
        $auth = Auth::user();
        $user = UserPortal::find($auth->id)->with(['details'])->first();
        return JsonResponseHandler::setResult($user)->send();
    }

    public function getBarang(Request $request, $id)
    {
        $data = DataBarang::where('id', $id)->with(['satuan', 'foto', 'user', 'user.detail', 'user.user'])->first();
        return view('Portal::barang.detailproduk', compact("data"));
    }
    public function dashboard()
    {
        $slider = Slider::all();
        $barang = DataBarang::limit(18)->inRandomOrder()->get();
        $kategori = KategoriProduk::get();
        $data = [
            'slider' => $slider,
            'kategori_produk' => $kategori,
            'rekomendasi' => $barang,
        ];
        return JsonResponseHandler::setResult($data)->send();
       
    }
    public function fetchLogin(Request $request)
    {
        $data = Auth::user();
        if ($data) {
            $user = UserModel::with(["roles", 'detail'])->find($data->id);
            return JsonResponseHandler::setResult($user)->send();
        } else {
            return JsonResponseHandler::setCode(400)->send();
        }
    }
    public function index(Request $request)
    {
        $slider = Slider::all();
        // $category = DataBarang::all();
        $category = DataBarang::limit(8)->inRandomOrder()->get();
        $barang = DataBarang::limit(8)->inRandomOrder()->get();
        return view('Portal::dashboard.dashboard', compact('barang','slider','category'));
    }
    public function login(Request $request)
    {
        return view('Portal::auth.login');
    }
    public function registrasi(Request $request)
    {
        return view('Portal::auth.registrasi');
    }

    public function statuspengiriman(Request $request, $kode)
{
    try {
        $user = Auth::user()->id;
        
        // Get the master transaction first
        $transaksi_master = TransaksiMaster::where('kode_transaksi', $kode)->first();
        
        if (!$transaksi_master) {
            abort(404, 'Transaksi tidak ditemukan');
        }

        // Get all transactions with this master code for the user
        $transaksi_barang = TransaksiBarang::where('user_id', $user)
            ->where('kode_transaksi_master', $transaksi_master->kode_transaksi)
            ->get();

        if ($transaksi_barang->isEmpty()) {
            abort(404, 'Transaksi tidak ditemukan');
        }

        // Collect all items from all transactions
        $allItems = [];
        $allPengiriman = [];
        
        foreach ($transaksi_barang as $transaksi) {
            $transaksiChildren = TransaksiBarangChildren::where('transaksi_id', $transaksi->id)->get();
            
            foreach ($transaksiChildren as $child) {
                $barang = DataBarang::find($child->barang_id);
                if ($barang) {
                    $allItems[] = [
                        'namaBarang' => $barang->nama_barang,
                        'thumbnail' => $barang->thumbnail_readable,
                        'jumlah' => $child->jumlah,
                        'harga' => $child->harga,
                        'subtotal' => $child->harga * $child->jumlah,
                        'transaksi_kode' => $transaksi->kode_transaksi,
                        'status' => $transaksi->status,
                        'status_readable' => $transaksi->status_readable,
                        'biaya_pengiriman' => $transaksi->biaya_pengiriman,
                        'kurir_pengiriman' => $transaksi->kurir_pengiriman
                    ];
                }
            }
            
            // Get shipping history for each transaction
            $pengiriman = Pengiriman::where('transaksi_id', $transaksi->id)
                ->orderBy('created_at', 'desc')
                ->get();
                
            $allPengiriman = array_merge($allPengiriman, $pengiriman->toArray());
        }

        // Sort shipping history by date
        usort($allPengiriman, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        // Get the first product image for the header
        $firstProductImage = count($allItems) > 0 ? $allItems[0]['thumbnail'] : asset('img/default-product.jpg');

        $status_pengiriman = [
            'transaksi_master' => $transaksi_master,
            'transaksi_list' => $transaksi_barang,
            'items' => $allItems,
            'pengiriman' => $allPengiriman,
            'keterangan' => $allPengiriman[0]['keterangan'] ?? 'Menunggu pengiriman',
            'image_product' => $firstProductImage,
            'kode_unik' => $transaksi_master->kode_unik
        ];

        return view('Portal::statuspengiriman', ['data' => $status_pengiriman]);
        
    } catch (\Exception $e) {
        Log::error('Error in statuspengiriman: ' . $e->getMessage());
        abort(500, 'Terjadi kesalahan saat memuat data pengiriman');
    }
}
    public function toko(Request $request, $id)
    {

        // $toko =TokoUser::find($id);
        $toko = TokoUser::with('detail.kotaModel')->find($id);


        // dd($toko);

        if (!$toko) {
            return abort(404);
        }
        $barang = DataBarang::with('user')->where('created_by_user_id', $toko->user_id)->get();
        // dd($barang);
        return view('Portal::toko', [
            'toko' => $toko,
            'barang' => $barang,
        ]);
    }

    public function paketparcel(Request $request, $id)
    {

        // $toko =TokoUser::find($id);
        $paketparcel = permintaanparcel::find($id);


        // dd($toko);

        if (!$paketparcel) {
            return abort(404);
        }
        // $barang = DataBarang::with('user')->where('created_by_user_id', $toko->user_id)->get();
        // dd($barang);
        return view('Portal::paketparcel', compact('paketparcel'));
    }

    public function followToko($id)
    {
        $user = Auth::user();
        $toko = TokoUser::find($id); // Mengganti 'TokoUser' menjadi 'UserToko'

        // Pastikan 'users_toko' dan user ada
        if (!$toko || !$user) {
            return response()->json(['message' => 'Toko atau user tidak ditemukan'], 404);
        }

        // Cek apakah user sudah mengikuti 'users_toko'
        $existingFollow = Pengikut::where('user_id', $user->id)
            ->where('toko_id', $toko->id) // Mengganti 'toko_id' menjadi 'user_toko_id'
            ->first();

        if (!$existingFollow) {
            // Jika belum mengikuti, buat record pengikut baru
            Pengikut::create([
                'user_id' => $user->id,
                'toko_id' => $toko->id // Mengganti 'toko_id' menjadi 'user_toko_id'
            ]);

            // Tambah 1 pada jumlah pengikut 'users_toko'
            $toko->pengikut = $toko->pengikut + 1;
            $toko->save();

            return redirect()->back();
        } else {
            // Jika sudah mengikuti, berhenti mengikuti
            $existingFollow->delete();

            // Kurangi 1 dari jumlah pengikut 'users_toko'
            $toko->pengikut = $toko->pengikut - 1;
            $toko->save();

            return redirect()->back();
        }
    }

    public function daftartransaksi(Request $request)
{
    $user = Auth::user()->id;
    
    if ($request->has('cari')) {
        $transaksi_masters = TransaksiMaster::whereHas('transaksi', function($query) use ($user) {
            $query->where('user_id', $user);
        })->where('kode_transaksi', 'LIKE', '%'.$request->cari.'%')->get();
    } else {
        $transaksi_masters = TransaksiMaster::whereHas('transaksi', function($query) use ($user) {
            $query->where('user_id', $user);
        })->orderBy('created_at', 'desc')->get();
    }

    $data_transaksi = [];
    
    foreach ($transaksi_masters as $master) {
        $master_total = 0;
        $master_items = [];
        $createdDate = Carbon::parse($master->created_at)->format('d-m-Y');
        
        foreach ($master->transaksi as $transaksi) {
            $transaksiChildren = TransaksiBarangChildren::where('transaksi_id', $transaksi->id)->get();
            
            foreach ($transaksiChildren as $child) {
                $barang = DataBarang::find($child->barang_id);
                if (!$barang) continue;
                
                $subtotal = $child->harga * $child->jumlah;
                $master_total += $subtotal + $transaksi->biaya_pengiriman;
                
                $master_items[] = [
                    'transaksiId' => $transaksi->id,
                    'kodeTransaksi' => $transaksi->kode_transaksi,
                    'namaBarang' => $barang->nama_barang,
                    'toko' => $barang->user->nama,
                    'thumbnail' => $barang->thumbnail,
                    'thumbnail_readable' => $barang->thumbnail_readable,
                    'jumlah' => $child->jumlah,
                    'harga' => $child->harga,
                    'subtotal' => $subtotal,
                    'biayaPengiriman' => $transaksi->biaya_pengiriman,
                    'kurirPengiriman' => $transaksi->kurir_pengiriman,
                    'status' => $transaksi->status,
                    'statusReadable' => $transaksi->status_readable,
                    'tokoId' => $transaksi->toko_id,
                ];
            }
        }
        
        $master_total += $master->kode_unik;
        $totalHargaFormatted = number_format($master_total, 0, ',', '.');
        
        $data_transaksi[] = [
            'masterKode' => $master->kode_transaksi,
            'parcelId' => $master->transaksi->pluck('parcel_id')->unique()->first(),
            'createdDate' => $createdDate,
            'items' => $master_items,
            'totalHarga' => $master_total,
            'totalHargaFormatted' => 'Rp. ' . $totalHargaFormatted,
            'kodeUnik' => $master->kode_unik,
            'status' => $this->getMasterStatus($master->transaksi),
            'statusReadable' => $this->getMasterStatusReadable($master->transaksi),
        ];
    }
    
    return view('Portal::transaksi.daftartransaksi', ['data' => $data_transaksi]);
}

private function getMasterStatus($transactions)
{
    // If any transaction is still in process (status < 4), consider it in process
    foreach ($transactions as $trans) {
        if ($trans->status < 4) {
            return $trans->status;
        }
    }
    // If all are completed (status 4), return completed
    return 4;
}

private function getMasterStatusReadable($transactions)
{
    $statuses = [
        1 => 'Diproses',
        2 => 'Pembayaran Diterima',
        3 => 'Barang Dikirim',
        4 => 'Barang Diterima',
        44 => 'Barang Tidak Diterima'
    ];
    
    $status = $this->getMasterStatus($transactions);
    return $statuses[$status] ?? 'Diproses';
}

public function updateStatusMaster(Request $request)
{
    try {
        $masterKode = $request->input('masterKode');
        $newStatus = $request->input('newStatus');

        // Cari semua transaksi dengan kode master tersebut
        $transaksis = TransaksiBarang::where('kode_transaksi_master', $masterKode)->get();

        if ($transaksis->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Transaksi tidak ditemukan.']);
        }

        DB::beginTransaction();
        
        foreach ($transaksis as $transaksi) {
            // Update status transaksi
            $transaksi->status = $newStatus;
            $transaksi->save();

            // Kirim notifikasi untuk setiap transaksi
            $pesan = WatZapRepository::formatMessage($transaksi);
            $pesan .= "Barang Berhasil diterima\n\n Terima Kasih telah berbelanja di WarungAspoo";
            // WatZapRepository::sendTextMessage($transaksi->pembeli->nomor_telepon, $pesan);

            // Update terjual untuk setiap barang
            foreach ($transaksi->dataChildren as $tr_child) {
                $b = DataBarang::find($tr_child->barang_id);
                if ($b) {
                    $jumlah = $b->terjual;
                    $jumlah = intval($jumlah) + intval($tr_child->jumlah);
                    $b->terjual = $jumlah;
                    $b->save();
                }
            }

            // Buat record pengiriman
            Pengiriman::create([
                'transaksi_id' => $transaksi->id,
                'status' => $newStatus,
                'keterangan' => "Barang berhasil diterima",
            ]);
        }

        DB::commit();

        return response()->json(['success' => true]);
    } catch (Exception $e) {
        DB::rollBack();
        Log::error('Error updating master status: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}

public function updateStatusMasterGagal(Request $request)
{
    try {
        $masterKode = $request->input('masterKode');
        $newStatus = $request->input('newStatus');
        $barangtidakditerima = $request->input('barangtidakditerima');

        // Cari semua transaksi dengan kode master tersebut
        $transaksis = TransaksiBarang::where('kode_transaksi_master', $masterKode)->get();

        if ($transaksis->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Transaksi tidak ditemukan.']);
        }

        DB::beginTransaction();
        
        foreach ($transaksis as $transaksi) {
            // Update status transaksi
            $transaksi->status = $newStatus;
            $transaksi->save();

            // Buat record pengiriman
            Pengiriman::create([
                'transaksi_id' => $transaksi->id,
                'status' => $newStatus,
                'keterangan' => $barangtidakditerima,
            ]);
        }

        DB::commit();

        return response()->json(['success' => true]);
    } catch (Exception $e) {
        DB::rollBack();
        Log::error('Error updating master status: ' . $e->getMessage());
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}

    public function updateStatus(Request $request)
    {
        try {
            $transaksiId = $request->input('transaksiId');
            $newStatus = $request->input('newStatus');

            // Cari transaksi berdasarkan ID
            $transaksi = TransaksiBarang::find($transaksiId);
            $pesan = WatZapRepository::formatMessage($transaksi);
            $pesan .= "Barang Berhasil diterima\n\n Terima Kasih telah berbelanja di WarungAspoo";
            WatZapRepository::sendTextMessage($transaksi->pembeli->nomor_telepon, $pesan);
            if (!$transaksi) {
                // Transaksi tidak ditemukan, maka return response error
                return response()->json(['success' => false, 'message' => 'Transaksi not found.']);
            }

            // Update status transaksi
            $transaksi->status = $newStatus;
            $transaksi->save();

            foreach ($transaksi->dataChildren as $tr_child) {
                $b = DataBarang::find($tr_child->barang_id);

                $jumlah = $b->terjual;
                $jumlah = intval($jumlah) + intval($tr_child->jumlah);
                $b->terjual = $jumlah;
                $b->save();
            }

            $pengiriman = Pengiriman::create([
                'transaksi_id' => $transaksiId,
                'status' => 4,
                'keterangan' => "Barang berhasil diterima",

            ]);

            // Assuming the update was successful
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error updating status: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function updateStatusgagal(Request $request)
    {
        try {
            $transaksiId = $request->input('transaksiId');
            $newStatus = $request->input('newStatus');
            $barangtidakditerima = $request->input('barangtidakditerima');

            // Cari transaksi berdasarkan ID
            $transaksi = TransaksiBarang::find($transaksiId);

            if (!$transaksi) {
                // Transaksi tidak ditemukan, maka return response error
                return response()->json(['success' => false, 'message' => 'Transaksi not found.']);
            }

            // Update status transaksi
            $transaksi->status = $newStatus;
            $transaksi->save();


            $pengiriman = Pengiriman::create([
                'transaksi_id' => $transaksiId,
                'status' => 44,
                'keterangan' => $barangtidakditerima,

            ]);


            // Assuming the update was successful
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error updating status: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to update status.']);
        }
    }


    public function profile(Request $request)
    {

        $data = UserDetail::where('user_id', Auth::id())->with('userMaster')->first();
        // dd($data);
        $userMaster = UserModel::where('id', Auth::id())->first();
        $toko = MasterUMKM::where('user_id', Auth::id())->first();
        $provinsi = Provinsi::all();
        $kota = Kota::all();
        $asal_daerah = [
            'provinsi' => $provinsi,
            'kota' => $kota,
        ];

        return view('Portal::auth.profile', ['data' => $data, 'user' => $userMaster, 'asal' => $asal_daerah, 'toko' => $toko]);
    }
    public function updateProfile(Request $request)
{
    $payload = $request->all();
    $userid = $request->input('user_id');
    
    // Ambil data existing
    $existingData = UserDetail::where('user_id', $userid)->first();

    if (!empty($payload['kota'])) {
        $get_rajaongkircity = $payload['kota'];
        $rajaongkir_city = Kota::find($get_rajaongkircity);

        if ($rajaongkir_city) {
            $kota_rajaongkir = $rajaongkir_city->rajaongkir_city;
            $postal_rajaongkir = $rajaongkir_city->rajaongkir_postal;
        } else {
            $kota_rajaongkir = null;
            $postal_rajaongkir = null;
        }
    } else {
        // Pertahankan data lama jika kota kosong
        $kota_rajaongkir = $existingData ? $existingData->kota_rajaongkir : null;
        $postal_rajaongkir = $existingData ? $existingData->postal_rajaongkir : null;
    }

    $userDetail = [
        'user_id' => $request->input('user_id'),
        'alamat' => $request->input('alamat'),
        'telepon' => $request->input('telepon'),
        'tanggal_lahir' => $request->input('tanggal_lahir'),
        // Gunakan data baru jika ada, jika tidak gunakan data lama
        'provinsi' => $request->input('provinsi') ?: ($existingData ? $existingData->provinsi : null),
        'kota' => $request->input('kota') ?: ($existingData ? $existingData->kota : null),
        'kota_rajaongkir' => $kota_rajaongkir,
        'postal_rajaongkir' => $postal_rajaongkir,
        'kecamatan' => $request->input('kecamatan') ?: ($existingData ? $existingData->kecamatan : null),
        'kelurahan' => $request->input('kelurahan') ?: ($existingData ? $existingData->kelurahan : null),
        'jenis_kelamin' => $request->input('jenis_kelamin'),
    ];

    if ($request->hasFile('foto')) {
        $foto = FileHandler::store(file: $request->file('foto'), targetDir: "uploads/profile");
        $userDetail['foto'] = $foto;
    }

    $insert = UserDetail::updateOrInsert(['user_id' => $userid], $userDetail);

    $userMaster = User::find($userid);
    $userMaster->username = $request->input('username');
    $userMaster->email = $request->input('email');
    $userMaster->name = $request->input('nama');
    $userMaster->nomor_telepon = $request->input('telepon');
    $userMaster->save();

    if ($insert) {
        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    } else {
        return redirect()->back()->with('error', 'Profil gagal diperbarui');
    }
}

    public function detailproduk(Request $request)
    {
        return view('Portal::detailproduk');
    }
    public function keranjang(Request $request)
{
    $user = Auth::user();
    $keranjang = Keranjang::with(['barang', 'parcel'])
        ->where('user_id', $user->id)
        ->get();
    
    return view('Portal::transaksi.keranjang', compact('keranjang'));
}
    public function infotoko(Request $request)
    {
        return view('Portal::infotoko');
    }
    private function countRajaOngkir($origin, $destination, $weight, $courier)
    {
        $responseCost = Http::withHeaders([
            'key' => 'f4f21baace88e503f1f1602d7c07a23a'
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier,
        ]);

        return $responseCost['rajaongkir'];
    }
    public function checkout(Request $request)
{
    $user = UserDetail::where('user_id', Auth::id())->with('userMaster')->first();
    $userId = Auth::id();

    // Get selected items from session
    $selectedKeranjang = Session::get('checkout_keranjang', []);

    // Validate session data
    if (empty($selectedKeranjang)) {
        return redirect()->route('keranjang')->with('error', 'No items selected for checkout.');
    }

    // Fetch full cart item details for selected items and ensure they belong to the current user
    $data = collect($selectedKeranjang)
        ->filter(function ($item) use ($userId) {
            $keranjang = Keranjang::with(['barang', 'barang.user', 'parcel'])
                ->where('id', $item->id)
                ->where('user_id', $userId)
                ->first();
            return $keranjang !== null;
        })
        ->groupBy(function ($item) {
            $barang = DataBarang::find($item->barang_id);
            return $barang ? $barang->created_by_user_id : 0;
        })
        ->map(function ($group) {
            return collect($group)->map(function ($item) {
                return Keranjang::with(['barang', 'barang.user', 'parcel'])
                    ->where('id', $item->id)
                    ->first();
            })->filter();
        });

    // If no valid items remain after filtering, redirect with error
    if ($data->isEmpty()) {
        return redirect()->route('keranjang')->with('error', 'Selected items are invalid or do not belong to the current user.');
    }

    $userdata = UserDetail::where('user_id', Auth::id())->with('userMaster')->first();
    $kodeUnik = rand(10, 99);

    $ret = ['data' => $data, 'userdetail' => $userdata, 'user' => $user, 'kodeUnik' => $kodeUnik];

    return view('Portal::transaksi.checkout', $ret);
}
public function postCheckout(Request $request)
    {
        // Log request for debugging
        Log::info('postCheckout request:', $request->all());

        $user = User::find(Auth::id())->with('detail')->first();
        if (!$user || !$user->detail) {
            Log::error('User or UserDetail not found for user_id: ' . Auth::id());
            return JsonResponseHandler::setResult('User details not found.')->setCode(400)->send();
        }

        // Get selected items from session
        $selectedKeranjang = session('checkout_keranjang', []);
        if (empty($selectedKeranjang)) {
            Log::error('No selected items in checkout_keranjang session for user_id: ' . Auth::id());
            return JsonResponseHandler::setResult('No items selected for checkout.')->setCode(400)->send();
        }

        // Validate and fetch selected cart items
        $datas = collect($selectedKeranjang)
            ->map(function ($item) {
                return Keranjang::with(['barang', 'barang.user', 'parcel'])
                    ->where('id', $item->id)
                    ->where('user_id', Auth::id())
                    ->first();
            })
            ->filter()
            ->groupBy(function ($item) {
                return $item->barang->created_by_user_id . '-' . ($item->parcel_id ?? 'regular');
            });

        if ($datas->isEmpty()) {
            Log::error('No valid cart items found for user_id: ' . Auth::id());
            return JsonResponseHandler::setResult('Selected items are invalid or do not belong to the current user.')->setCode(400)->send();
        }

        $input = $request->all();
        $kode_master = "TR-" . Str::random(8);
        $total_biaya = $request->totalPembayaran;
        $kode_unik = $request->kodeUnik;
        $total_pengiriman = $request->totalPengiriman;

        // Validate required input
        if (!isset($input['checkout']['alamat']) || !isset($input['transaksi']['ongkir'])) {
            Log::error('Missing required checkout data for user_id: ' . Auth::id(), $input);
            return JsonResponseHandler::setResult('Invalid checkout data.')->setCode(400)->send();
        }

        $barangs_midtrans = [
            [
                'id' => 1398274,
                'price' => $total_pengiriman,
                'quantity' => 1,
                'name' => 'Ongkir'
            ],
            [
                'id' => 72133,
                'price' => $kode_unik,
                'quantity' => 1,
                'name' => 'Kode Unik'
            ]
        ];

        DB::beginTransaction();
        try {
            $i = 0;
            foreach ($datas as $groupKey => $barangs) {
                $total = 0;
                $parcel_id = $barangs->first()->parcel_id ?? null;

                $transaksi = TransaksiBarang::create([
                    'kode_transaksi' => "TR-" . Str::random(8),
                    'alamat' => $request->checkout['alamat'],
                    'biaya_pengiriman' => intval($request->transaksi['ongkir'][$i] ?? 0),
                    'kurir_pengiriman' => $request->transaksi['ongkirData'][$i] ?? 'jne',
                    'total_biaya' => 0,
                    'user_id' => Auth::id(),
                    'toko_id' => 0,
                    'kode_transaksi_master' => $kode_master,
                    'pesan' => $request->transaksi['pesan'][$i] ?? '',
                    'parcel_id' => $parcel_id,
                ]);

                $toko_id = 0;
                foreach ($barangs as $keranjang) {
                    $barang = $keranjang->barang;
                    $barangs_midtrans[] = [
                        'id' => $barang->id,
                        'price' => $barang->harga_user,
                        'quantity' => $keranjang->jumlah,
                        'name' => $barang->nama_barang,
                    ];

                    $tr_child = TransaksiBarangChildren::create([
                        'transaksi_id' => $transaksi->id,
                        'barang_id' => $keranjang->barang_id,
                        'harga' => $barang->harga_user,
                        'jumlah' => $keranjang->jumlah,
                    ]);
                    $total += intval($tr_child->harga) * intval($tr_child->jumlah);
                    $toko_id = $barang->created_by_user_id;
                    Keranjang::where('id', $keranjang->id)->delete();
                }
                $transaksi->total_biaya = $total + ($request->transaksi['ongkir'][$i] ?? 0);
                $transaksi->toko_id = $toko_id;
                $transaksi->save();
                $i++;
                $total_biaya += $transaksi->biaya_pengiriman;
            }

            $return = TransaksiMaster::create([
                'kode_transaksi' => $kode_master,
                'kode_unik' => $kode_unik,
                'total_biaya' => $total_biaya + $total_pengiriman + $kode_unik,
            ]);

            // Midtrans configuration
            Config::$serverKey = config('services.midtrans.serverKey');
            Config::$isProduction = config('services.midtrans.isProduction');
            Config::$isSanitized = config('services.midtrans.isSanitized');
            Config::$is3ds = config('services.midtrans.is3ds');

            $midtrans = [
                'transaction_details' => [
                    'order_id' => $kode_master,
                    'gross_amount' => (int) $return->total_biaya + $kode_unik,
                ],
                'item_details' => $barangs_midtrans,
                'enabled_payments' => [
                    'qris',
                    'bank_transfer',
                    'alfamart',
                    'alfamidi',
                ],
                'vtweb' => []
            ];

            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;
            TransaksiMaster::where('kode_transaksi', $kode_master)->update(['midtrans_link' => $paymentUrl]);

            $link = ['midtrans_link' => $paymentUrl];
            $dataResponse = array_merge($return->toArray(), $link);
            DB::commit();

            // Clear session
            session()->forget('checkout_keranjang');
            Log::info('Checkout session cleared for user_id: ' . Auth::id());

            return JsonResponseHandler::setResult($dataResponse)->send();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Checkout error for user_id: ' . Auth::id(), ['error' => $e->getMessage()]);
            return JsonResponseHandler::setResult($e->getMessage())->setCode(500)->send();
        }
    }
    public function listToko(Request $request)
    {
        // $results = TokoUser::paginate(25);

        $results = TokoUser::with('detail.kotaModel')->whereHas('user', function ($query) {
            $query->where('username', '!=', 'developer')
                ->where('username', '!=', 'ilyas@gmail.com');
        })->paginate(24);


        // $results = TokoUser::with('detail')->paginate(25);


        // dd($results);

        return view('Portal::listtoko', compact('results'));
    }

    // public function listBarang(Request $request)
    // {
    //     // Mengambil semua data barang dari database
    //     // $produk = DataBarang::paginate(24);
    //     $produk = DataBarang::paginate(12);
    //     $category = DataBarang::all();

    //     // Mengambil data dari jsonplaceholder
    //     $response = Http::get('https://jsonplaceholder.typicode.com/posts');

    //     // Mengkonversi respons JSON menjadi array
    //     $placeholder = $response->json(); // atau $response->json() jika ingin mendapatkan array

    //     return view('Portal::listbarang', compact('produk','category', 'placeholder'));
    // }

    public function listBarang(Request $request)
    {
        $produk = DataBarang::orderBy('created_at', 'desc')->paginate(16);
        $category = DataBarang::select('kategori_umum')->distinct()->get();
        
        return view('Portal::listbarang', compact('produk','category'));
    }
    

public function listBarangByKategori($kategori)
{
    $produk = DataBarang::where('kategori_umum', $kategori)->paginate(12);
    $category = DataBarang::select('kategori_umum')->distinct()->get();
    
    return view('Portal::listbarang', compact('produk','category', 'kategori'));
}


    public function listParcel(Request $request)
    {
        // Mengambil semua data dari database
        // $parcels = permintaanparcel::paginate(24);
        $parcels = permintaanparcel::whereHas('user', function ($query) {
            $query->where('username', 'developer');
        })->paginate(24);

        return view('Portal::listparcel', compact('parcels'));
    }

    public function setelahcheckout(Request $request)
    {
        $kode = $request->kode;
        $data = TransaksiMaster::where('kode_transaksi', $kode)->first();
        $rekening = Rekening::where('status', 1)->first();
        return view('Portal::transaksi.setelahcheckout', compact("data", "rekening"));
    }
    public function ratingdanulasan(Request $request)
    {
        return view('Portal::ratingdanulasan');
    }

    public function pusatbantuan(Request $request)
    {
        return view('Portal::pusatbantuan');
    }
    public function kebijakan(Request $request)
    {
        return view('Portal::kebijakan');
    }
    public function tentangaspoomarket(Request $request)
    {
        return view('Portal::tentangaspoomarket');
    }

    public function cekongkir(Request $request)
    {
        $response = Http::withHeaders([
            'key' => 'f4f21baace88e503f1f1602d7c07a23a'
        ])->get('https://api.rajaongkir.com/starter/city');

        $cities = $response['rajaongkir']['results'];


        return view('Portal::cekongkir', ['cities' => $cities, 'ongkir' => '']);
    }
    public function cekHasil(Request $request)
{
    $userDetail = UserDetail::where('user_id', Auth::id())->with('userMaster')->first();
    
    // Jika ini parcel, gunakan alamat dari parcel
    if ($request->is_parcel && $request->parcel_address) {
        $origin = $request->parcel_address['kota']['kota_rajaongkir'];
    } else {
        $origin = $userDetail->kota_rajaongkir;
    }

    $groupedKeranjang = Keranjang::with(['barang' => function ($query) {
        $query->with('user');
    }])->has('barang')->get()->groupBy('barang.created_by_user_id');

    $destinations = [];
    $weights = [];
    
    foreach ($groupedKeranjang as $userId => $keranjang) {
        foreach ($keranjang as $item) {
            $tokoUser = $item->barang->user;
            $userDetail = $tokoUser->detail;
            $destinations[] = $userDetail->kota_rajaongkir;
            $weights[] = $item->barang->berat;
        }
    }

    $responseCost = Http::withHeaders([
        'key' => 'f4f21baace88e503f1f1602d7c07a23a'
    ])->post('https://api.rajaongkir.com/starter/cost', [
        'origin' => $origin,
        'destination' => implode(',', array_unique($destinations)),
        'weight' => array_sum($weights),
        'courier' => $request->courier,
    ]);

    return JsonResponseHandler::setResult($responseCost['rajaongkir'])->send();
}

    // bagian db wilayah
    public function getProvinces()
    {
        $provinces = Provinsi::all();

        return response()->json($provinces);
    }

    public function getRegenciesByProvince($province_id)
    {
        $regencies = Kota::where('province_id', $province_id)->get();

        return response()->json($regencies);
    }

    public function getDistrictsByRegency($regency_id)
    {
        $districts = Kecamatan::where('regency_id', $regency_id)->get();

        return response()->json($districts);
    }

    public function getVillagesByDistrict($district_id)
    {
        $villages = Kelurahan::where('district_id', $district_id)->get();

        return response()->json($villages);
    }
    public function getkota(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');

        $data = Kota::where('province_id', $value)->get();

        $output = '<option value="">~ Pilih Asal Kota/Kabupaten ~ </option>';

        foreach ($data as $row) {
            $output .= '<option value="' . $row->id . '">' . $row->name . '</option>';
        }

        return response()->json($output);
    }
    public function getkecamatan(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');

        $data = Kecamatan::where('regency_id', $value)->get();

        $output = '<option value="">~ Pilih Asal Kecamatan ~</option>';

        foreach ($data as $row) {
            $output .= '<option value="' . $row->id . '">' . $row->name . '</option>';
        }

        return response()->json($output);
    }
    public function getkelurahan(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');

        $data = Kelurahan::where('district_id', $value)->get();

        $output = '<option value="">~ Pilih Asal Kelurahan ~ </option>';

        foreach ($data as $row) {
            $output .= '<option value="' . $row->id . '">' . $row->name . '</option>';
        }

        return response()->json($output);
    }

    public function submitParcelReview(Request $request, $id)
    {
        try {
            $parcel = permintaanparcel::findOrFail($id);
            
            $request->validate([
                'review_komposisi' => 'required|integer|min:1|max:5',
                'review_pelayanan' => 'required|integer|min:1|max:5',
            ]);
            
            $parcel->update([
                'review_komposisi' => $request->review_komposisi,
                'review_pelayanan' => $request->review_pelayanan,
            ]);
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function submitParcelComment(Request $request, $id)
{
    try {
        $request->validate([
            'komentar' => 'required|string|max:30'
        ]);

        $parcel = permintaanparcel::findOrFail($id);
        
        // Pastikan hanya pemilik parcel yang bisa mengomentari
        if ($parcel->user_id != Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $parcel->komentar = $request->komentar;
        $parcel->save();
        
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}

    public function pesanparcelapi(Request $request)
    {
        $auth = Auth::user();
        // $data = permintaanparcel::where('id',$id)->with(['user'])->first();
        
        // $barang = DataBarang::select('*')->with(['user'])->get();
        $barang = DataBarang::select('*')->with(['user'])->get();

        $parcel = permintaanparcel::with(['parcel_children.barang'])->where('review_komposisi', '!=', '')
                          ->get();


        $data = UserDetail::where('user_id', Auth::id())->with('userMaster')->first();
        // dd($data);
        $userMaster = UserModel::where('id', Auth::id())->first();
        $provinsi = Provinsi::all();
        $kota = Kota::all();
        $asal = [
            'provinsi' => $provinsi,
            'kota' => $kota,
        ];

        // Query dasar dengan eager loading
        $barangUnique = DataBarang::with(['user'])
        ->where('berat', '>', 0)
        ->where('stock_global', '>', 0)
            ->where('kategori_umum', '!=', 'Null')
            ->where('produsen', '!=', 'null')
            ->where('produsen', '!=', '-')
            // ->where('kategori_umum', '!=', '')
            // ->where('bahan_dasar', '!=', '')
            // ->where('basah_kering', '!=', '')
            // ->where('rasa', '!=', '')
            // ->where('produsen', '!=', '')
        ->get();

        $namaBarangUnique = DataBarang::with(['user'])
        ->where('berat', '>', 0)
        ->where('stock_global', '>', 0)
            // ->where('kategori_umum', '!=', '')
            // ->where('bahan_dasar', '!=', '')
            // ->where('basah_kering', '!=', '')
            // ->where('rasa', '!=', '')
            // ->where('produsen', '!=', '')
        ->get();

        $stokProduk = $barangUnique->groupBy('nama_barang')->map(function ($items) {
            return $items->sum(function ($item) {
                return isset($item->stock_global) ? $item->stock_global : 0;
            });
        });

        // Hitung semua kategori unik sekaligus
        $uniqueData = [
            // 'categories' => $barangUnique->pluck('kategori_umum')->unique()->sort()->values(),
            'categories' => $barangUnique->pluck('kategori_umum')->filter()->unique()->sort()->values(),
            'bahan' => $barangUnique->pluck('bahan_dasar')->filter()->unique()->sort()->values(),
            'basah_kering' => $barangUnique->pluck('basah_kering')->filter()->unique()->sort()->values(),
            'rasa' => $barangUnique->pluck('rasa')->filter()->unique()->sort()->values(),
            'produsen' => $barangUnique->pluck('produsen')->filter()->unique()->sort()->values(),
            // 'nama_produk' => $barangUnique->pluck('nama_barang')->filter()->unique()->sort()->values(),
            'nama_produk' => $namaBarangUnique->pluck('nama_barang')->filter()->unique()->sort()->values(),
        ];

        // Hitung jumlah per kategori (sekali saja)
        $counts = [
            'categories' => $barangUnique->countBy('kategori_umum'),
            'bahan' => $barangUnique->countBy('bahan_dasar'),
            'basah_kering' => $barangUnique->countBy('basah_kering'),
            'rasa' => $barangUnique->countBy('rasa'),
            'produsen' => $barangUnique->countBy('produsen'),
        ];

        // $selectedItems = ParcelChildren::where('parcel_id', $id)->with(['parcel','barang'])->get();
        // dd($selectedItems);

        $card = [
            'barang' => $barang,
            // 'selectedItems' => $selectedItems
        ];
        // dd($card);
        //return view('Portal::auth.profile', ['data' => $data, 'user' => $userMaster, 'asal' => $asal_daerah]);
        return view('Portal::pesanparcelapi', compact('auth', 'card', 'data', 'asal','parcel','barangUnique','uniqueData','counts','stokProduk'));
    }

    public function pesanparcel(Request $request)
    {
        $auth = Auth::user();
        // $data = permintaanparcel::where('id',$id)->with(['user'])->first();
        
        // $barang = DataBarang::select('*')->with(['user'])->get();
        $barang = DataBarang::select('*')->with(['user'])->get();

        $parcel = permintaanparcel::with(['parcel_children.barang'])->where('review_komposisi', '!=', '')
                          ->get();


        $data = UserDetail::where('user_id', Auth::id())->with('userMaster')->first();
        // dd($data);
        $userMaster = UserModel::where('id', Auth::id())->first();
        $provinsi = Provinsi::all();
        $kota = Kota::all();
        $asal = [
            'provinsi' => $provinsi,
            'kota' => $kota,
        ];

        // Query dasar dengan eager loading
        $barangUnique = DataBarang::with(['user'])
        ->where('berat', '>', 0)
        ->where('stock_global', '>', 0)
            ->where('kategori_umum', '!=', 'Null')
            ->where('produsen', '!=', 'null')
            ->where('produsen', '!=', '-')
            // ->where('kategori_umum', '!=', '')
            // ->where('bahan_dasar', '!=', '')
            // ->where('basah_kering', '!=', '')
            // ->where('rasa', '!=', '')
            // ->where('produsen', '!=', '')
        ->get();

        $namaBarangUnique = DataBarang::with(['user'])
        ->where('berat', '>', 0)
        ->where('stock_global', '>', 0)
        ->where(function($query) {
            $query->where('available', '<>', 'No')
                  ->orWhereNull('available'); // Jika ingin termasuk NULL
        })
            // ->where('kategori_umum', '!=', '')
            // ->where('bahan_dasar', '!=', '')
            // ->where('basah_kering', '!=', '')
            // ->where('rasa', '!=', '')
            // ->where('produsen', '!=', '')
        ->get();

        $stokProduk = $barangUnique->groupBy('nama_barang')->map(function ($items) {
            return $items->sum(function ($item) {
                return isset($item->stock_global) ? $item->stock_global : 0;
            });
        });

        // Hitung semua kategori unik sekaligus
        $uniqueData = [
            // 'categories' => $barangUnique->pluck('kategori_umum')->unique()->sort()->values(),
            'categories' => $barangUnique->pluck('kategori_umum')->filter()->unique()->sort()->values(),
            'bahan' => $barangUnique->pluck('bahan_dasar')->filter()->unique()->sort()->values(),
            'basah_kering' => $barangUnique->pluck('basah_kering')->filter()->unique()->sort()->values(),
            'rasa' => $barangUnique->pluck('rasa')->filter()->unique()->sort()->values(),
            'produsen' => $barangUnique->pluck('produsen')->filter()->unique()->sort()->values(),
            // 'nama_produk' => $barangUnique->pluck('nama_barang')->filter()->unique()->sort()->values(),
            'nama_produk' => $namaBarangUnique->pluck('nama_barang')->filter()->unique()->sort()->values(),
        ];

        // Hitung jumlah per kategori (sekali saja)
        $counts = [
            'categories' => $barangUnique->countBy('kategori_umum'),
            'bahan' => $barangUnique->countBy('bahan_dasar'),
            'basah_kering' => $barangUnique->countBy('basah_kering'),
            'rasa' => $barangUnique->countBy('rasa'),
            'produsen' => $barangUnique->countBy('produsen'),
        ];

        // $selectedItems = ParcelChildren::where('parcel_id', $id)->with(['parcel','barang'])->get();
        // dd($selectedItems);

        $card = [
            'barang' => $barang,
            // 'selectedItems' => $selectedItems
        ];
        // dd($card);
        //return view('Portal::auth.profile', ['data' => $data, 'user' => $userMaster, 'asal' => $asal_daerah]);
        return view('Portal::pesanparcel', compact('auth', 'card', 'data', 'asal','parcel','barangUnique','uniqueData','counts','stokProduk'));
    }

    public function getFilterStats(Request $request)
    {
        try {
            $cacheKey = 'filter_stats_optimal';
            
            return Cache::remember($cacheKey, 600, function () { // Cache 10 menit
                // Single query untuk semua statistik
                $rawData = DB::select("
                    SELECT 
                        'categories' as type, kategori_umum as name,
                        MIN(harga_umum) as min_price, MAX(harga_umum) as max_price,
                        MIN(berat) as min_weight, MAX(berat) as max_weight,
                        COUNT(*) as count
                    FROM barang 
                    WHERE berat > 0 AND stock_global > 0 
                        AND kategori_umum != 'Null' AND kategori_umum IS NOT NULL
                        AND produsen != 'null' AND produsen != '-' AND produsen IS NOT NULL
                        AND kategori_umum != '' AND kategori_umum != 'null' AND kategori_umum != '-'
                    GROUP BY kategori_umum
                    
                    UNION ALL
                    
                    SELECT 
                        'bahan' as type, bahan_dasar as name,
                        MIN(harga_umum) as min_price, MAX(harga_umum) as max_price,
                        MIN(berat) as min_weight, MAX(berat) as max_weight,
                        COUNT(*) as count
                    FROM barang 
                    WHERE berat > 0 AND stock_global > 0 
                        AND kategori_umum != 'Null' AND kategori_umum IS NOT NULL
                        AND produsen != 'null' AND produsen != '-' AND produsen IS NOT NULL
                        AND bahan_dasar IS NOT NULL AND bahan_dasar != '' AND bahan_dasar != 'null' AND bahan_dasar != '-'
                    GROUP BY bahan_dasar
                    
                    UNION ALL
                    
                    SELECT 
                        'basah_kering' as type, basah_kering as name,
                        MIN(harga_umum) as min_price, MAX(harga_umum) as max_price,
                        MIN(berat) as min_weight, MAX(berat) as max_weight,
                        COUNT(*) as count
                    FROM barang 
                    WHERE berat > 0 AND stock_global > 0 
                        AND kategori_umum != 'Null' AND kategori_umum IS NOT NULL
                        AND produsen != 'null' AND produsen != '-' AND produsen IS NOT NULL
                        AND basah_kering IS NOT NULL AND basah_kering != '' AND basah_kering != 'null' AND basah_kering != '-'
                    GROUP BY basah_kering
                    
                    UNION ALL
                    
                    SELECT 
                        'rasa' as type, rasa as name,
                        MIN(harga_umum) as min_price, MAX(harga_umum) as max_price,
                        MIN(berat) as min_weight, MAX(berat) as max_weight,
                        COUNT(*) as count
                    FROM barang 
                    WHERE berat > 0 AND stock_global > 0 
                        AND kategori_umum != 'Null' AND kategori_umum IS NOT NULL
                        AND produsen != 'null' AND produsen != '-' AND produsen IS NOT NULL
                        AND rasa IS NOT NULL AND rasa != '' AND rasa != 'null' AND rasa != '-'
                    GROUP BY rasa
                    
                    UNION ALL
                    
                    SELECT 
                        'produsen' as type, produsen as name,
                        MIN(harga_umum) as min_price, MAX(harga_umum) as max_price,
                        MIN(berat) as min_weight, MAX(berat) as max_weight,
                        COUNT(*) as count
                    FROM barang 
                    WHERE berat > 0 AND stock_global > 0 
                        AND kategori_umum != 'Null' AND kategori_umum IS NOT NULL
                        AND produsen != 'null' AND produsen != '-' AND produsen IS NOT NULL
                        AND produsen != '' AND produsen != 'null'
                    GROUP BY produsen
                    
                    UNION ALL
                    
                    SELECT 
                        'nama_produk' as type, nama_barang as name,
                        MIN(harga_umum) as min_price, MAX(harga_umum) as max_price,
                        MIN(berat) as min_weight, MAX(berat) as max_weight,
                        COUNT(*) as count
                    FROM barang 
                    WHERE berat > 0 AND stock_global > 0 
                        AND kategori_umum != 'Null' AND kategori_umum IS NOT NULL
                        AND produsen != 'null' AND produsen != '-' AND produsen IS NOT NULL
                        AND nama_barang IS NOT NULL AND nama_barang != '' AND nama_barang != 'null' AND nama_barang != '-'
                    GROUP BY nama_barang
                    
                    ORDER BY type, name
                ");
                
                // Group hasil berdasarkan type
                $grouped = collect($rawData)->groupBy('type');
                
                $response = [
                    'success' => true,
                    'data' => [
                        'categories' => $grouped->get('categories', collect())->map(function($item) {
                            return [
                                'name' => $item->name,
                                'min_price' => (float) $item->min_price,
                                'max_price' => (float) $item->max_price,
                                'min_weight' => (float) $item->min_weight,
                                'max_weight' => (float) $item->max_weight,
                                'count' => (int) $item->count
                            ];
                        })->values()->toArray(),
                        'bahan' => $grouped->get('bahan', collect())->map(function($item) {
                            return [
                                'name' => $item->name,
                                'min_price' => (float) $item->min_price,
                                'max_price' => (float) $item->max_price,
                                'min_weight' => (float) $item->min_weight,
                                'max_weight' => (float) $item->max_weight,
                                'count' => (int) $item->count
                            ];
                        })->values()->toArray(),
                        'basah_kering' => $grouped->get('basah_kering', collect())->map(function($item) {
                            return [
                                'name' => $item->name,
                                'min_price' => (float) $item->min_price,
                                'max_price' => (float) $item->max_price,
                                'min_weight' => (float) $item->min_weight,
                                'max_weight' => (float) $item->max_weight,
                                'count' => (int) $item->count
                            ];
                        })->values()->toArray(),
                        'rasa' => $grouped->get('rasa', collect())->map(function($item) {
                            return [
                                'name' => $item->name,
                                'min_price' => (float) $item->min_price,
                                'max_price' => (float) $item->max_price,
                                'min_weight' => (float) $item->min_weight,
                                'max_weight' => (float) $item->max_weight,
                                'count' => (int) $item->count
                            ];
                        })->values()->toArray(),
                        'produsen' => $grouped->get('produsen', collect())->map(function($item) {
                            return [
                                'name' => $item->name,
                                'min_price' => (float) $item->min_price,
                                'max_price' => (float) $item->max_price,
                                'min_weight' => (float) $item->min_weight,
                                'max_weight' => (float) $item->max_weight,
                                'count' => (int) $item->count
                            ];
                        })->values()->toArray(),
                        'nama_produk' => $grouped->get('nama_produk', collect())->map(function($item) {
                            return [
                                'name' => $item->name,
                                'min_price' => (float) $item->min_price,
                                'max_price' => (float) $item->max_price,
                                'min_weight' => (float) $item->min_weight,
                                'max_weight' => (float) $item->max_weight,
                                'count' => (int) $item->count
                            ];
                        })->values()->toArray()
                    ]
                ];
                
                return response()->json($response);
            });
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load filter stats: ' . $e->getMessage()
            ], 500);
        }
    }

    public function apibarang(Request $request){
        $barang = DataBarang::with(['user', 'user.detail', 'user.detail.kotaModel'])
        ->where('berat', '>', 0)
        ->where('stock_global', '>', 0)
        ->where(function($query) {
            $query->where('available', '<>', 'No')
                  ->orWhereNull('available'); // Jika ingin termasuk NULL
        })
        ->groupBy('nama_barang')
        ->get();
            
        return response()->json([
            'success' => true,
            'data' => $barang->map(function($item) {
                return [
                    'id' => $item->id,
                    'nama_barang' => $item->nama_barang,
                    'harga_user' => $item->harga_user,
                    'berat' => $item->berat,
                    'kategori_umum' => $item->kategori_umum,
                    'bahan_dasar' => $item->bahan_dasar,
                    'basah_kering' => $item->basah_kering,
                    'rasa' => $item->rasa,
                    'produsen' => $item->produsen,
                    'stock_global' => $item->stock_global,
                    'available' => $item->available,
                    'thumbnail_readable' => $item->thumbnail_readable ? URL::asset($item->thumbnail_readable) : null,
                    'user' => [
                        'nama' => $item->user->nama,
                        'detail' => [
                            'kotaModel' => [
                                'name' => $item->user->detail->kotaModel->name ?? 'Unknown'
                            ]
                        ]
                    ]
                ];
            })
        ]);
    }

    public function saveToCart(Request $request)
{
    $user = Auth::user();
    $datauser = UserDetail::where('user_id', Auth::id())->with('userMaster')->first();
    $items = $request->input('items');
    $parcelId = $request->input('parcel_id');
    $parcelQuantity = $request->input('parcel_quantity', 1); // Default to 1 if not provided
    
    // Make sure quantity is at least 1
    $parcelQuantity = max(1, intval($parcelQuantity));
    
    DB::beginTransaction();
    try {
        // Get parcel information
        $parcel = permintaanparcel::with(['parcel_children.barang'])
                        ->where('id', $parcelId)
                        ->first();
        
        // Prepare items list for WhatsApp message
        $itemsList = "";
        foreach ($items as $index => $item) {
            $barang = DataBarang::find($item['id']);
            $itemsList .= ($index + 1) . ". " . $barang->nama_barang . "\n";
        }
        
        foreach ($items as $item) {
            Keranjang::create([
                'user_id' => $user->id,
                'barang_id' => $item['id'],
                'jumlah' => $parcelQuantity, // Use the parcel quantity
                'parcel_id' => $parcelId,
                // 'harga' => $item['price'],
            ]);
        }
        
        DB::commit();
        
        // Send WhatsApp notification
        $whatsappMessage = "Halo " . $user->username . ", Pesanan Parcel ASPOO #" . $parcelId . "\n";
        // $whatsappMessage .= "Nama Parcel: " . ($parcel->nama_parcel ?? 'N/A') . "\n";
        // $whatsappMessage .= "ID Parcel: " . $parcelId . "\n";
        $whatsappMessage .= "Jumlah: " . $parcelQuantity . "\n";
        $whatsappMessage .= "Items:\n" . $itemsList;
        // $whatsappMessage .= "Pelanggan: " . $user->username . "\n";
        
        $response = Http::withHeaders([
            'Authorization' => 'RNnk34zGgGPPxF7KLn8L',
        ])->post('https://api.fonnte.com/send', [
            'target' => $datauser->telepon,
            'message' => $whatsappMessage,
        ]);

        // dd(json_decode($response, true));
        
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}

public function saveToCartApi(Request $request)
{
    $user = Auth::user();
    $datauser = UserDetail::where('user_id', Auth::id())->with('userMaster')->first();
    
    // Validate the input
    $request->validate([
        'items' => 'required|string', // Expecting a JSON string
        'parcel_id' => 'required|integer',
        'parcel_quantity' => 'nullable|integer|min:1',
    ]);
    
    // Decode the JSON string to an array
    try {
        $items = json_decode($request->input('items'), true);
        
        // Check if decoding was successful and items is an array
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($items)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid JSON format for items'
            ], 400);
        }
        
        // Validate that items array is not empty
        if (empty($items)) {
            return response()->json([
                'success' => false,
                'message' => 'Items array cannot be empty'
            ], 400);
        }
        
        // Validate each item has required fields
        foreach ($items as $item) {
            if (!isset($item['id']) || !is_numeric($item['id'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Each item must have a valid numeric ID'
                ], 400);
            }
        }
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error decoding items: ' . $e->getMessage()
        ], 400);
    }
    
    $parcelId = $request->input('parcel_id');
    $parcelQuantity = max(1, intval($request->input('parcel_quantity', 1))); // Default to 1 if not provided
    
    DB::beginTransaction();
    try {
        // Get parcel information
        $parcel = permintaanparcel::with(['parcel_children.barang'])
                        ->where('id', $parcelId)
                        ->first();
        
        if (!$parcel) {
            throw new \Exception('Parcel not found');
        }
        
        // Prepare items list for WhatsApp message
        $itemsList = "";
        foreach ($items as $index => $item) {
            $barang = DataBarang::find($item['id']);
            if (!$barang) {
                throw new \Exception('Item with ID ' . $item['id'] . ' not found');
            }
            $itemsList .= ($index + 1) . ". " . $barang->nama_barang . "\n";
        }
        
        // Save items to cart
        foreach ($items as $item) {
            Keranjang::create([
                'user_id' => $user->id,
                'barang_id' => $item['id'],
                'jumlah' => $parcelQuantity,
                'parcel_id' => $parcelId,
            ]);
        }
        
        DB::commit();
        
        // Send WhatsApp notification
        $whatsappMessage = "Halo " . $user->username . ", Pesanan Parcel ASPOO #" . $parcelId . "\n";
        $whatsappMessage .= "Jumlah: " . $parcelQuantity . "\n";
        $whatsappMessage .= "Items:\n" . $itemsList;
        
        $response = Http::withHeaders([
            'Authorization' => 'RNnk34zGgGPPxF7KLn8L',
        ])->post('https://api.fonnte.com/send', [
            'target' => $datauser->telepon,
            'message' => $whatsappMessage,
        ]);
        
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Error saving to cart: ' . $e->getMessage()
        ], 500);
    }
}

public function kirimpesanparcelapi(Request $request)
{
    $request->validate([
        'user_id' => 'required|string',
        'harga' => 'required|numeric',
        'berat' => 'required|numeric',
        'alamat' => 'required|string',
        'barang' => 'required|string',
        'tanggal' => 'required|date',
    ]);

    // Decode alamat JSON untuk menambahkan data RajaOngkir
    $alamat = json_decode($request->alamat, true);
    
    // Ambil data kota dari database
    $kota = Kota::find($alamat['kota']['id']);
    
    // Tambahkan data RajaOngkir ke alamat
    $alamat['kota']['kota_rajaongkir'] = $kota->rajaongkir_city;
    $alamat['kota']['postal_rajaongkir'] = $kota->rajaongkir_postal;

    $parcel = permintaanparcel::create([
        'user_id' => $request->user_id,
        'harga' => $request->harga,
        'berat' => $request->berat,
        'alamat' => json_encode($alamat), // Simpan kembali sebagai JSON
        'barang' => $request->barang,
        'tanggal' => $request->tanggal,
    ]);

    return response()->json([
        'success' => true,
        'parcel_id' => $parcel->id,
        'harga' => $parcel->harga
    ]);
}
public function kirimpesanparcel(Request $request)
{
    $request->validate([
        'user_id' => 'required|string',
        'harga' => 'required|numeric',
        'berat' => 'required|numeric',
        'alamat' => 'required|string',
        'barang' => 'required|string',
        'tanggal' => 'required|date',
    ]);

    // Decode alamat JSON untuk menambahkan data RajaOngkir
    $alamat = json_decode($request->alamat, true);
    
    // Ambil data kota dari database
    $kota = Kota::find($alamat['kota']['id']);
    
    // Tambahkan data RajaOngkir ke alamat
    $alamat['kota']['kota_rajaongkir'] = $kota->rajaongkir_city;
    $alamat['kota']['postal_rajaongkir'] = $kota->rajaongkir_postal;

    $parcel = permintaanparcel::create([
        'user_id' => $request->user_id,
        'harga' => $request->harga,
        'berat' => $request->berat,
        'alamat' => json_encode($alamat), // Simpan kembali sebagai JSON
        'barang' => $request->barang,
        'tanggal' => $request->tanggal,
    ]);

    return response()->json([
        'success' => true,
        'parcel_id' => $parcel->id,
        'harga' => $parcel->harga
    ]);
}
    public function paymentparcel(Request $request)
    {
        $harga = $request->harga;

        $rekening = Rekening::select('*')->get();

        return view('Portal::parcelkonfirmasi', compact('rekening', 'harga'));
    }
    public function tutorialparcel(Request $request)
    {

        return view('Portal::tutorialparcel');
    }
    public function daftarparcel(Request $request)
    {
        $userId = Auth::user()->id;

        // Mengambil data parcel berdasarkan user yang sedang login
        $parcels = PermintaanParcel::with(['parcel_children.barang'])
            ->where('user_id', $userId)
            ->get();

        return view('Portal::transaksi.daftarparcel', compact('parcels'));
    }

    
    public function searchItems(Request $request)
    {
        $searchTerms = $request->input('search_terms', '');

        // Assuming `DataBarang` is the model for your items
        $items = DataBarang::where('nama_barang', 'LIKE', '%' . $searchTerms . '%')->with(['satuan', 'foto'])->get();

        return response()->json($items);
    }
}
