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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
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
    public function postKeranjangToCheckout(Request $request)
    {
        $datas = json_decode($request->data);
        foreach ($datas->data_keranjang as $data) {
            $keranjang = Keranjang::where('id', $data->id)->first();
            $keranjang->jumlah = $data->jumlah;
            $keranjang->save();
        }
        return JsonResponseHandler::setResult($keranjang)->send();
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

        // Hanya jalankan pencarian jika nilai 'q' tidak kosong
        if (!empty($q)) {
            if ($tipe == 'barang') {
                $results = DataBarang::where("nama_barang", "LIKE", "%" . $q . "%")->get();
                return view('Portal::cari.cari', compact('results', 'q', 'tipe'));
            } elseif ($tipe == 'toko') {
                $results = TokoUser::where("nama", "LIKE", "%" . $q . "%")->with(['user', 'user.kotaModel'])->get();
                return view('Portal::cari.caritoko', compact('results', 'q', 'tipe'));
            } else {
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
        return view('Portal::dashboard.dashboard');
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
        $user = Auth::user()->id;
        $transaksi_barang = TransaksiBarang::where('user_id', $user)->where('kode_transaksi', $kode)->first();
        $transaksiChildren = TransaksiBarangChildren::where('transaksi_id', $transaksi_barang->id)->first();
        $pengiriman = Pengiriman::where('transaksi_id', $transaksi_barang->id)->orderBy('created_at', 'desc')->get();
        $barang = DataBarang::find($transaksiChildren->barang_id);

        $keterangan_pengiriman = $pengiriman->first()->keterangan;
        $kurir = $transaksi_barang->kurir_pengiriman;
        $image_product = $barang->thumbnail_readable;

        $status_pengiriman = [
            'transaksi' => $transaksi_barang,
            'transaksi_child' => $transaksiChildren,
            'pengiriman' => $pengiriman,
            'keterangan' => $keterangan_pengiriman,
            'kurir' => $kurir,
            'resi' => $kode,
            'image_product' => $image_product
        ];


        return view('Portal::statuspengiriman', ['data' => $status_pengiriman]);
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
            $transaksi_barang = TransaksiBarang::where('user_id', $user)->where('kode_transaksi', $request->cari)->get();
        } else {
            $transaksi_barang = TransaksiBarang::where('user_id', $user)->get();
        }
        $data_transaksi = [];
        foreach ($transaksi_barang as $transaksi) {
            $transaksiChildren = TransaksiBarangChildren::where('transaksi_id', $transaksi->id)->first();
            if ($transaksiChildren) {
                $barang = DataBarang::find($transaksiChildren->barang_id);
                if (!$barang) {
                    continue;
                }
                $jumlah = $transaksiChildren->jumlah;
                $totalHarga = $transaksi->biaya_pengiriman + $transaksi->total_biaya;
                $totalHargaFormatted = number_format($totalHarga, 0, ',', '.');
                $createdDate = Carbon::parse($transaksi->created_at)->format('d-m-Y');

                $transaksiId = $transaksi->id;
                $kodeTransaksi = $transaksi->kode_transaksi;
                $alamat = $transaksi->alamat;
                $biayaPengiriman = $transaksi->biaya_pengiriman;
                $kurirPengiriman = $transaksi->kurir_pengiriman;
                $pesan = $transaksi->pesan;
                $totalBiaya = $transaksi->total_biaya;
                $userId = $transaksi->user_id;
                $tokoId = $transaksi->toko_id;
                $namaBarang = $barang->nama_barang;
                $thumbnail = $barang->thumbnail_readable;
                $status = $transaksi->status;


                $data_transaksi[] = [
                    'transaksiId' => $transaksiId,
                    'kodeTransaksi' => $kodeTransaksi,
                    'createdDate' => $createdDate,
                    'alamat' => $alamat,
                    'biayaPengiriman' => $biayaPengiriman,
                    'kurirPengiriman' => $kurirPengiriman,
                    'pesan' => $pesan,
                    'totalBiaya' => $totalBiaya,
                    'userId' => $userId,
                    'tokoId' => $tokoId,
                    'namaBarang' => $namaBarang,
                    'thumbnail' => $thumbnail,
                    'jumlah' => $jumlah,
                    'totalHarga' => $totalHarga,
                    'totalHargaFormatted' => 'Rp. ' . $totalHargaFormatted,
                    'statusReadable' => $transaksi->status_readable,
                    'status' => $status,
                ];
            }
        }
        return view('Portal::transaksi.daftartransaksi', ['data' => $data_transaksi]);
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
        $provinsi = Provinsi::all();
        $kota = Kota::all();
        $asal_daerah = [
            'provinsi' => $provinsi,
            'kota' => $kota,
        ];

        return view('Portal::auth.profile', ['data' => $data, 'user' => $userMaster, 'asal' => $asal_daerah]);
    }
    public function updateProfile(Request $request)
    {
        $payload = $request->all();

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
            $kota_rajaongkir = null;
            $postal_rajaongkir = null;
        }

        $userDetail = [
            'user_id' => $request->input('user_id'),
            'alamat' => $request->input('alamat'),
            'telepon' => $request->input('telepon'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
            'provinsi' => $request->input('provinsi'),
            'kota' => $request->input('kota'),
            'kota_rajaongkir' => $kota_rajaongkir,
            'postal_rajaongkir' => $postal_rajaongkir,
            'kecamatan' => $request->input('kecamatan'),
            'kelurahan' => $request->input('kelurahan'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
        ];

        if ($request->hasFile('foto')) {
            $foto = FileHandler::store(file: $request->file('foto'), targetDir: "uploads/profile");
            $userDetail['foto'] = $foto;
        }

        $userid = $request->input('user_id');

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
        return view('Portal::transaksi.keranjang');
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
        // $user = User::find(Auth::id())->with(['detail'])->first();
        $user = UserDetail::where('user_id', Auth::id())->with('userMaster')->first();
        $userid = $user->id;



        $data = Keranjang::with(['barang' => function ($query) {
        }, 'barang.user'])->has('barang')->get()->groupBy('barang.created_by_user_id');

        $userdata = UserDetail::where('user_id', Auth::id())->with('userMaster')->first();
        $kodeUnik = rand(10, 99);

        // $rajaongkir = $this->countRajaOngkir($origin, $destination, $weight, $courier);
        $ret = ['data' => $data, 'userdetail' => $userdata, 'user' => $user, 'kodeUnik' => $kodeUnik];

        return view('Portal::transaksi.checkout', $ret);
    }
    public function postCheckout(Request $request)
    {
        $user = User::find(Auth::id())->with('detail')->first();
        $userid = $user->id;
        $datas = Keranjang::with(['barang', 'barang.user'])->where('user_id', Auth::user()->id)->get()->groupBy('barang.created_by_user_id');
        $input = $request->all();
        $kode_master = "TR-" . Str::random(8);
        $total_biaya = $request->totalPembayaran;
        $kode_unik = $request->kodeUnik;
        $total_pengiriman = $request->totalPengiriman;

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
            foreach ($datas as $barangs) {
                $total = 0;
                $transaksi = TransaksiBarang::create([
                    'kode_transaksi' => "TR-" . Str::random(8),
                    'alamat' => $request->checkout['alamat'],
                    'biaya_pengiriman' => intval($request->transaksi['ongkir'][$i]),
                    'kurir_pengiriman' => $request->transaksi['ongkirData'][$i],
                    'total_biaya' => $total_biaya + $total_pengiriman + $kode_unik,

                    'user_id' => Auth::id(),
                    'toko_id' => 0, // temp
                    'kode_transaksi_master' => $kode_master,
                    'pesan' => $request->transaksi['pesan'][$i],
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
                $transaksi->total_biaya = $total;
                $transaksi->toko_id = $toko_id;
                $transaksi->save();
                $i++;
                $total_biaya += $transaksi->biaya_pengiriman;
            }

            $return = TransaksiMaster::create([
                'kode_transaksi' => $kode_master,
                'kode_unik' => $kode_unik,
                'total_biaya' => $total_biaya,
            ]);


            // Midtrans
            // Konfigurasi midtrans
            Config::$serverKey = config('services.midtrans.serverKey');
            Config::$isProduction = config('services.midtrans.isProduction');
            Config::$isSanitized = config('services.midtrans.isSanitized');
            Config::$is3ds = config('services.midtrans.is3ds');

            $midtrans = [
                'transaction_details' => array(
                    'order_id' =>  $kode_master,
                    'gross_amount' => (int) $return->total_biaya + $kode_unik,
                ),
                // 'customer_details' => array(
                //     'first_name'    => $transaction->patient->name,
                //     'email'         => $transaction->patient->email,
                // ),
                'item_details' => $barangs_midtrans,
                'enabled_payments' => [
                    'qris',
                    'bank_transfer',
                    'alfamart',
                    'alfamidi',
                ],
                'vtweb' => array()
            ];


            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;
            // $return->midtrans_link = $paymentUrl;
            // $return->save();
            TransaksiMaster::where('kode_transaksi', $kode_master)->update(['midtrans_link' => $paymentUrl]);

            $link = [
                'midtrans_link' => $paymentUrl,
            ];
            $dataResponse = array_merge($return->toArray(), $link);
            DB::commit();


            return JsonResponseHandler::setResult($dataResponse)->send();
        } catch (Exception $e) {
            DB::rollBack();
            return JsonResponseHandler::setResult($e->getMessage())->send();
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
    public function listBarang(Request $request)
    {
        // Mengambil semua data barang dari database
        $produk = DataBarang::paginate(24);

        // Mengambil data dari jsonplaceholder
        $response = Http::get('https://jsonplaceholder.typicode.com/posts');

        // Mengkonversi respons JSON menjadi array
        $placeholder = $response->json(); // atau $response->json() jika ingin mendapatkan array

        return view('Portal::listbarang', compact('produk', 'placeholder'));
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
    $origin = $userDetail->kota_rajaongkir;

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
    public function pesanparcel(Request $request)
    {
        $auth = Auth::user();
        // $data = permintaanparcel::where('id',$id)->with(['user'])->first();
        $barang = DataBarang::select('*')->with(['user'])->get();

        $data = UserDetail::where('user_id', Auth::id())->with('userMaster')->first();
        // dd($data);
        $userMaster = UserModel::where('id', Auth::id())->first();
        $provinsi = Provinsi::all();
        $kota = Kota::all();
        $asal = [
            'provinsi' => $provinsi,
            'kota' => $kota,
        ];

        // $selectedItems = ParcelChildren::where('parcel_id', $id)->with(['parcel','barang'])->get();
        // dd($selectedItems);

        $card = [
            'barang' => $barang,
            // 'selectedItems' => $selectedItems
        ];
        // dd($card);
        //return view('Portal::auth.profile', ['data' => $data, 'user' => $userMaster, 'asal' => $asal_daerah]);
        return view('Portal::pesanparcel', compact('auth', 'card', 'data', 'asal'));
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

        $parcel = permintaanparcel::create([
            'user_id' => $request->user_id,
            'harga' => $request->harga,
            'berat' => $request->berat,
            'alamat' => $request->alamat,
            'barang' => $request->barang,
            'tanggal' => $request->tanggal,
        ]);
        // return response()->json([
        //     'success' => true,
        //     'parcel_id' => $parcel->id  // Assuming $parcel is the newly created parcel model
        // ]);
        // return redirect()->route('paymentparcel', ['harga' => $parcel->harga]);
        
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
