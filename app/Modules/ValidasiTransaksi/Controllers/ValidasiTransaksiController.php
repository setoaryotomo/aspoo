<?php

namespace App\Modules\ValidasiTransaksi\Controllers;

use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Modules\ApproveTransaksi\Models\Pengiriman;
use App\Modules\Pembelian\Repositories\WatZapRepository;
use App\Modules\ValidasiTransaksi\Repositories\ValidasiTransaksiRepository;
use App\Modules\ValidasiTransaksi\Requests\ValidasiTransaksiCreateRequest;
use App\Modules\Permission\Repositories\PermissionRepository;
use App\Modules\Portal\Model\Rekening;
use App\Modules\Portal\Model\TransaksiMaster;
use App\Modules\TransaksiBarang\Models\TransaksiBarang;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValidasiTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $permissions = PermissionRepository::getPermissionStatusOnMenuPath($request->path());
        return view('ValidasiTransaksi::index', ['permissions' => $permissions]);
    }
    
    public function datatable(Request $request)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $data = ValidasiTransaksiRepository::datatable($per_page);
        return JsonResponseHandler::setResult($data)->send();
    }
    public function deletePreview(Request $request,$kode){
        $datas= TransaksiBarang::where('kode_transaksi_master',$kode)->get();
        try{
            DB::beginTransaction();
            foreach($datas as $data){
                
                $data->status = 22;
                $data->save();
                
                Pengiriman::create([
                    'transaksi_id' => $data->id,
                    'status' => 22,
                    'keterangan' => $request->pesan,
                ]);

            }
            DB::commit();
            $return = [
                'status' => 200,
                'message' => "Berhasil menolak",
                'body' => $datas
            ];

        }catch(Exception $e){
            DB::rollBack();
            $return = [
                'status' => 400,
                'message' => $e->getMessage(),
            ];
        }
        return JsonResponseHandler::setResult($return)->send();
    }
    
    public function preview(Request $request, $kode){
        $data = TransaksiMaster::where('kode_transaksi',$kode)->with('transaksi')->first();
        $rekening = Rekening::where('status',1)->first();
        return view('ValidasiTransaksi::preview',compact('data','rekening'));
    }
    
    public function approve(Request $request,$kode){
        $datas = TransaksiBarang::where('kode_transaksi_master',$kode)->get();
        try{
            DB::beginTransaction();
            $pesan = "Transaksi Anda ".$kode."\n";
            $i = 1;
            foreach($datas as $data){
                $telp = $data->pembeli->nomor_telepon;
                foreach($data->dataChildren as $child){
                    $barang = $child->barang;

                    $pesan .= $i++.". ".$barang->nama_barang." x".$child->jumlah."\n";
                }
             

                $data->status = 2;
                $data->save();
                Pengiriman::create([
                    'transaksi_id' => $data->id,
                    'status' => 2,
                    'keterangan' => 'Transaksi telah di validasi oleh ASPOO',
                ]);
            }
            $pesan .="Transaksi telah di validasi oleh ASPOO";
            WatZapRepository::sendTextMessage($telp,$pesan);

            DB::commit();
            
            $result = [
                'status' => 200,
                'message' => 'Data berhasil disimpan',
                'body' => $datas
            ];
        }catch(Exception $e){
            DB::rollBack();
            $result = [
                'status' => 400,
                'message' => $e->getMessage()
            ];
        }
        return JsonResponseHandler::setResult($result)->send();
    }
    
    public function create()
    {
        return view('ValidasiTransaksi::create');
    }
    
    public function store(ValidasiTransaksiCreateRequest $request)
    {
        $payload = $request->all();
        $validasi_transaksi = ValidasiTransaksiRepository::create($payload);
        return JsonResponseHandler::setResult($validasi_transaksi)->send();
    }
    
    public function show(Request $request, $id)
    {
        $validasi_transaksi = ValidasiTransaksiRepository::get($id);
        return JsonResponseHandler::setResult($validasi_transaksi)->send();
    }
    
    public function edit($id)
    {
        return view('ValidasiTransaksi::edit', ['validasi_transaksi_id' => $id]);
    }
    
    public function update(Request $request, $id)
    {
        $payload = $request->all();
        unset($payload['created_at']);
        unset($payload['updated_at']);
        $validasi_transaksi = ValidasiTransaksiRepository::update($id, $payload);
        return JsonResponseHandler::setResult($validasi_transaksi)->send();
    }
    
    public function destroy(Request $request, $id)
    {
        $delete = ValidasiTransaksiRepository::delete($id);
        return JsonResponseHandler::setResult($delete)->send();
    }
}
