<?php

namespace App\Modules\ApproveTransaksi\Controllers;

use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Modules\ApproveTransaksi\Models\Pengiriman;
use App\Modules\ApproveTransaksi\Repositories\ApproveTransaksiRepository;
use App\Modules\ApproveTransaksi\Requests\ApproveTransaksiCreateRequest;
use App\Modules\DataBarang\Models\DataBarang;
use App\Modules\Pembelian\Repositories\WatZapRepository;
use App\Modules\Permission\Repositories\PermissionRepository;
use App\Modules\TransaksiBarang\Models\TransaksiBarang;
use App\Modules\TransaksiBarang\Models\TransaksiBarangChildren;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApproveTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $permissions = PermissionRepository::getPermissionStatusOnMenuPath($request->path());
        return view('ApproveTransaksi::index', ['permissions' => $permissions]);
    }
    public function preview(Request $request,$kode){
        $data = TransaksiBarang::where('kode_transaksi',$kode)->with(['dataChildren','pembeli','penjual','dataChildren.barang'])->first();
        // dd($data);
        return view('ApproveTransaksi::preview',compact("data"));
    }

  
    public function postPreview(Request $request){
        DB::beginTransaction();
        try{
            $kode = $request->kode;
            $data = TransaksiBarang::with(['pembeli','dataChildren','dataChildren.barang'])->where("kode_transaksi",$kode)->first();
            $telp = $data->pembeli->nomor_telepon;
            $pesan = WatZapRepository::formatMessage($data);
            $pesan .="Telah di Approve oleh Seller";
            WatZapRepository::sendTextMessage($telp,$pesan);
            $data->status = 1;
            $data->save();
            $approve_transaksi = Pengiriman::create([
                'transaksi_id' => $data->id,
                'status' => 1,
                'keterangan' => 'Telah di Approve Oleh Seller'
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

    public function datatable(Request $request)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $data = ApproveTransaksiRepository::datatable($per_page);
        return JsonResponseHandler::setResult($data)->send();
    }
    public function tolak(Request $request,$kode){
        $transaksi = TransaksiBarang::where('kode_transaksi',$kode)->first();
        $transaksi->status = 11;
        $transaksi->save();
        
        $pengiriman = Pengiriman::create([
            'transaksi_id' => $transaksi->id,
            'keterangan' =>  $request->pesan,
            'status' => 11,
        ]);
        
        return JsonResponseHandler::setResult($pengiriman)->send();
    }

    public function create()
    {
        return view('ApproveTransaksi::create');
    }

    public function store(ApproveTransaksiCreateRequest $request)
    {
        $payload = $request->all();
        $approve_transaksi = ApproveTransaksiRepository::create($payload);
        return JsonResponseHandler::setResult($approve_transaksi)->send();
    }

    public function show(Request $request, $id)
    {
        $approve_transaksi = ApproveTransaksiRepository::get($id);
        return JsonResponseHandler::setResult($approve_transaksi)->send();
    }

    public function edit($id)
    {
        return view('ApproveTransaksi::edit', ['approve_transaksi_id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();
        unset($payload['created_at']);
        unset($payload['updated_at']);
        $approve_transaksi = ApproveTransaksiRepository::update($id, $payload);
        return JsonResponseHandler::setResult($approve_transaksi)->send();
    }
    public function destroy(Request $request, $id)
    {
        $delete = ApproveTransaksiRepository::delete($id);
        return JsonResponseHandler::setResult($delete)->send();
    }
}
