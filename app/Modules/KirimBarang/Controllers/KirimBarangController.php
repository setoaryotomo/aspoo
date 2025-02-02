<?php

namespace App\Modules\KirimBarang\Controllers;

use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Modules\ApproveTransaksi\Models\Pengiriman;
use App\Modules\DataBarang\Models\DataBarang;
use App\Modules\KirimBarang\Repositories\KirimBarangRepository;
use App\Modules\KirimBarang\Requests\KirimBarangCreateRequest;
use App\Modules\Pembelian\Repositories\WatZapRepository;
use App\Modules\Permission\Repositories\PermissionRepository;
use App\Modules\TransaksiBarang\Models\TransaksiBarang;
use App\Modules\TransaksiBarang\Models\TransaksiBarangChildren;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KirimBarangController extends Controller
{
    public function index(Request $request)
    {
        $permissions = PermissionRepository::getPermissionStatusOnMenuPath($request->path());
        return view('KirimBarang::index', ['permissions' => $permissions]);
    }

    public function datatable(Request $request)
    {
        $auth = Auth::user();
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $role = $auth->role_ids[0];
        $kirim = TransaksiBarang::with("pembeli");
        if($role != 1){
            $kirim = $kirim->where('toko_id',$auth->id);
        }
        
        $kirim = $kirim->where('status',2)->paginate($per_page);
        return JsonResponseHandler::setResult($kirim)->send();
    }

    public function preview(Request $request,$kode){
        $data = TransaksiBarang::where('kode_transaksi',$kode)->with(['dataChildren','pembeli','penjual','dataChildren.barang'])->first();
        return view('KirimBarang::preview',compact("data"));
    }
    public function postPreview(Request $request){
        DB::beginTransaction();
        try{
            $kode = $request->kode;
            $data = TransaksiBarang::where("kode_transaksi",$kode)->first();
            $pesan = WatZapRepository::formatMessage($data);
            $pesan .="Barang Telah di kirim oleh Seller";
            WatZapRepository::sendTextMessage($data->pembeli->nomor_telepon,$pesan);
            $data->status = 3;
            $data->save();
            $approve_transaksi = Pengiriman::create([
                'transaksi_id' => $data->id,
                'status' => 3,
                'keterangan' => 'Seller telah mengirim barang'
            ]);

            $transaksi_childrens = TransaksiBarangChildren::where('transaksi_id',$data->id)->get();
            foreach($transaksi_childrens as $transaksi_children){
                $barang = DataBarang::where('id',$transaksi_children->barang_id)->first();
                $barang->stock_global = intval($barang->stock_global) - intval($transaksi_children->jumlah);
                $barang->save();
            }
            DB::commit();
            return JsonResponseHandler::setResult($approve_transaksi)->send();

        }catch(Exception $e){
            DB::rollBack();
            return JsonResponseHandler::setResult($e->getMessage())->send();
        }
    }
    public function tolak(Request $request,$kode){
        $transaksi = TransaksiBarang::where('kode_transaksi',$kode)->first();
        $transaksi->status = 33;
        $transaksi->save();
        $pengiriman = Pengiriman::create([
            'transaksi_id' => $transaksi->id,
            'keterangan' =>  $request->pesan,
            'status' => 33,
        ]);
        
        return JsonResponseHandler::setResult($pengiriman)->send();
    }

    public function create()
    {
        return view('KirimBarang::create');
    }

    public function store(KirimBarangCreateRequest $request)
    {
        $payload = $request->all();
        $kirim_barang = KirimBarangRepository::create($payload);
        return JsonResponseHandler::setResult($kirim_barang)->send();
    }

    public function show(Request $request, $id)
    {
        $kirim_barang = KirimBarangRepository::get($id);
        return JsonResponseHandler::setResult($kirim_barang)->send();
    }

    public function edit($id)
    {
        return view('KirimBarang::edit', ['kirim_barang_id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();
        unset($payload['created_at']);
        unset($payload['updated_at']);
        $kirim_barang = KirimBarangRepository::update($id, $payload);
        return JsonResponseHandler::setResult($kirim_barang)->send();
    }

    public function destroy(Request $request, $id)
    {
        $delete = KirimBarangRepository::delete($id);
        return JsonResponseHandler::setResult($delete)->send();
    }
}
