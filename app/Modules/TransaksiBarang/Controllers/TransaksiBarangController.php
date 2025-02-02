<?php

namespace App\Modules\TransaksiBarang\Controllers;

use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Modules\DataBarang\Models\DataBarang;
use App\Modules\TransaksiBarang\Repositories\TransaksiBarangRepository;
use App\Modules\TransaksiBarang\Requests\TransaksiBarangCreateRequest;
use App\Modules\Permission\Repositories\PermissionRepository;
use App\Modules\TransaksiBarang\Models\TransaksiBarang;
use App\Modules\TransaksiBarang\Models\TransaksiBarangChildren;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiBarangController extends Controller
{
    public function index(Request $request)
    {
        $permissions = PermissionRepository::getPermissionStatusOnMenuPath($request->path());
        return view('TransaksiBarang::index', ['permissions' => $permissions]);
    }
    
    public function datatable(Request $request)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $data = TransaksiBarangRepository::datatable($per_page);
        return JsonResponseHandler::setResult($data)->send();
    }
    
    public function create()
    {
        return view('TransaksiBarang::create');
    }
    
    public function store(TransaksiBarangCreateRequest $request)
    {
        $payload = $request->all();
        $user = Auth::user();
        $payload['user_id'] = $user->id;
        $details = $payload['detail_barang'];
        unset($payload['detail_barang']);
        try{
            DB::beginTransaction();
            $payload['total_biaya'] = 0;
            $transaksi = TransaksiBarang::create($payload);
            $jumlah_transaksi = 0;
            foreach($details as $detail){
                $barang = DataBarang::find($detail['barang_id'])->first();
                if($barang){
                    $detail['harga'] = DataBarang::getHargaBarang($user,$barang);
                    $detail['transaksi_id'] = $transaksi->id;
                    $jumlah_transaksi += intval($detail['harga']) * intval($detail['jumlah']);
                    TransaksiBarangChildren::create($detail);
                }
            }
            $transaksi->total_biaya = $jumlah_transaksi;
            $transaksi->update();
            $response = TransaksiBarang::where('id',$transaksi->id)->with(['dataChildren','dataChildren.barang'])->get();
            DB::commit();
            
            return JsonResponseHandler::setResult($response)->send();

        }catch(Exception $e){
            DB::rollBack();
            dd($e);
            
        }
    }
    
    public function show(Request $request, $id)
    {
        $transaksi_barang = TransaksiBarangRepository::get($id);
        return JsonResponseHandler::setResult($transaksi_barang)->send();
    }
    
    public function edit($id)
    {
        return view('TransaksiBarang::edit', ['transaksi_barang_id' => $id]);
    }
    
    public function update(Request $request, $id)
    {
        $payload = $request->all();
        unset($payload['created_at']);
        unset($payload['updated_at']);
        $transaksi_barang = TransaksiBarangRepository::update($id, $payload);
        return JsonResponseHandler::setResult($transaksi_barang)->send();
    }
    
    public function destroy(Request $request, $id)
    {
        $delete = TransaksiBarangRepository::delete($id);
        TransaksiBarangChildren::where('transaksi_id',$id)->delete();
        return JsonResponseHandler::setResult($delete)->send();
    }
}
