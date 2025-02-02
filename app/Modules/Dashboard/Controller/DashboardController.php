<?php

namespace App\Modules\Dashboard\Controller;

use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Dashboard\Repository\DashboardRepository;
use App\Modules\DataBarang\Models\DataBarang;
use App\Modules\InputSCM\Models\BarangSCM;
use App\Modules\InputSCM\Models\UMKM;
use App\Modules\Komposisi\Models\Komposisi;
use App\Modules\Portal\Model\UserDetail;
use App\Modules\PortalUser\Models\TokoUser;
use App\Modules\TransaksiBarang\Models\TransaksiBarang;
use App\Modules\TransaksiBarang\Models\TransaksiBarangChildren;
use App\Modules\User\Model\UserRoleModel;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Midtrans\Transaction;

class DashboardController extends Controller
{

    public function importdb(){
        $umkms = UMKM::all();
        DB::enableQueryLog();
        DB::beginTransaction();
        try{
        foreach($umkms as $umkm){
            $stringWithoutSpaces = str_replace(' ', '', $umkm->nama);
            $username = strtolower($stringWithoutSpaces);
            $number = rand(0,30);
            $user = User::create([
                'name' =>$umkm->nama,
                'email' => $username.$number."@gmail.com",
                'email_verified_at' => "2023-10-02 09:11:39",
                'email_verifier_id' =>"38" ,
                'username' =>   $username.$number."@gmail.com",
                'password' => Hash::make("aspoo"),
            ]);
            $randomNumber = mt_rand(1000000, 9999999);
            $fakePhoneNumber = "081" . $randomNumber;
            UserDetail::create([
                'user_id' => $user->id,
                'foto' => "uploads/profile/651fe78d948ed0.62155423.jpg",
                'alamat' => $umkm->alamat,
                'telepon' =>$fakePhoneNumber,
                'jenis_kelamin' => 'Laki-Laki',
                'tanggal_lahir' => '2002-12-03',
                'provinsi' => $umkm->provinsi,
                'kota' => $umkm->kota,
                'kecamatan' => $umkm->kecamatan,
                'kelurahan' => $umkm->kelurahan,
            ]);
            UserRoleModel::create([
                'user_id' => $user->id,
                'role_id' => '3'
            ]);
            TokoUser::create([
                'user_id' => $user->id,
                'foto' => "uploads/profile/651fe78d948ed0.62155423.jpg",
                'nama' => $umkm->nama,
                'keterangan' => "",
                'pengikut' => 0,
                'tautan' => ''
            ]);

            $barangs = BarangSCM::where('id_umkm',$umkm->id)->get();
        
            foreach($barangs as $barang){
                $keterangan ="
                <p>Tipe Barang : ".$barang->tipe_barang."</p>
                <p>Jenis Barang : ".$barang->jenis_barang."</p>
                <p>Kategori daya tahan barang : ".$barang->kategori_daya_tahan_barang."</p>
                <p>Periode Barang : ".$barang->periode_barang." </p>
                <p>Jenis rata rata penjualana : ".$barang->jenis_rata2_penjualan."</p>
            ";
                DataBarang::create([
                    'nama_barang' => $barang->nama,
                    'keterangan'=> $keterangan,
                    'thumbnail'=> '/uploads/barang/teh jawa.jpg',
                    'info_penting' => 'asd',
                    'diskon' => 0,
                    'harga_supplier' => 10000,
                    'harga_umum' => 12000,
                    'stock_global' => 10,
                    'satuan_id' => 1,
                    'created_by_user_id' => $user->id,
                    'scm_barang_id' => $barang->id,
                ]);
            }
        }
        echo "berhasil";
        DB::commit();
    }catch(QueryException $e){
        $query = DB::getQueryLog();
        print_r($e);
        exit();
    }

    }
    public function dummypost(Request $request){
        echo "Input data berikut <br>";
        print_r($request->all());
        echo "Sedang training";
    }
    public function dummyget(Request $request){
        echo "mencari barang";
        echo "barang ditemukan: prediksi barang harganya 15000";
    }
    public function index(Request $request)
    {
        $user = Auth::user();
        $userid = $user->id;
        $total_stock = DataBarang::where('created_by_user_id', $userid)->sum('stock_global');
        $total_barang = DataBarang::where('created_by_user_id', $userid)->get();
        $transaksi_berhasil = TransaksiBarang::where('toko_id', $userid)
        ->where('status',1)->get();
        $transaksi_gagal = TransaksiBarang::where('toko_id', $userid)
        ->where('status','=',11)->get();
        $uang_diterima = TransaksiBarang::where('toko_id', $userid)
        ->where('status',2)->get();
        $uang_ditolak = TransaksiBarang::where('toko_id', $userid)
        ->where('status','=',22)->get();
        $barang_dikirim = TransaksiBarang::where('toko_id', $userid)
        ->where('status',3)->get();
        $barang_tidak_dikirim = TransaksiBarang::where('toko_id', $userid)
        ->where('status','=',33)->get();
        $barang_diterima = TransaksiBarang::where('toko_id', $userid)
        ->where('status',4)->get();
        $barang_tidak_diterima = TransaksiBarang::where('toko_id', $userid)
        ->where('status','=',44)->get();
        $transaksi_dibuat = TransaksiBarang::where('toko_id', $userid)
        ->where('status','')->get();
        $get_data = DataBarang::select('*')->where('created_by_user_id', $userid)->limit(5)->get();
        $komposisi_list = Komposisi::all();


        $total_transaksi = TransaksiBarang::where('toko_id', $userid)->get();

        $card = [

            'total_barang' => count($total_barang),
            'total_stock' => $total_stock,
            'transaksi_berhasil' => count($transaksi_berhasil),
            'transaksi_gagal' => count($transaksi_gagal),
            'total_transaksi' => count($total_transaksi),
            'uang_diterima' => count($uang_diterima),
            'komposisi_list' => $komposisi_list,
            'uang_ditolak' => count($uang_ditolak),
            'barang_dikirim' => count($barang_dikirim),
            'barang_tidak_dikirim' => count($barang_tidak_dikirim),
            'barang_diterima' => count($barang_diterima),
            'barang_tidak_diterima' => count($barang_tidak_diterima),           
            'transaksi_dibuat' => count($transaksi_dibuat),
            'get_data' => $get_data         

        ];

        return view('Dashboard::index', ['data' => $card]);
    }

    public function cekKomposisi(Request $request) {
        $periode = $request->periode;
        $tanggal = DashboardRepository::getTanggal($periode);
    
        $transaksi_list = TransaksiBarangChildren::with('barang.komposisi')
            ->when($tanggal, function ($query) use ($tanggal) {
                $query->where('created_at', '>', $tanggal);
            })
            ->get()
            ->groupBy('barang_id');
    
        $listData = [];
    
        $transaksi_list->each(function ($transaksiList, $head) use (&$listData) {
            $barang = DataBarang::find($head);
    
            if ($barang) {
                $transaksiList->each(function ($transaksi) use ($barang, &$listData) {
                    $barang->komposisi->each(function ($komposisi) use ($transaksi, &$listData) {
                        $listData[$komposisi->nama] = ($listData[$komposisi->nama] ?? 0) + $transaksi->barang->komposisi->sum('pivot.jumlah');
                    });
                });
            }
        });
        return JsonResponseHandler::setResult($listData)->send();
    }
    
}
