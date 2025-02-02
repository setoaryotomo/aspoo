<?php

namespace App\Modules\Komposisi\Controllers;

use App\Handler\FileHandler;
use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\DataBarang\Models\DataBarang;
use App\Modules\DataBarang\Models\DataBarangKomposisi;
use App\Modules\DataBarang\Repositories\DataBarangRepository;
use App\Modules\DataBarang\Requests\DataBarangCreateRequest;
use App\Modules\Komposisi\Models\KomposisiSupplier;
use App\Modules\Komposisi\Models\PivotKomposisiSupplier;
use App\Modules\Permission\Repositories\PermissionRepository;
use App\Type\JsonResponseType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KomposisiSupplierController extends Controller
{
    public function index(Request $request,$id)
    {
        return view('Komposisi::supplier.index');
    }

    public function datatable(Request $request)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $data = KomposisiSupplier::with(['provinsi','kecamatan','kota','kelurahan'])->paginate($per_page);
        return JsonResponseHandler::setResult($data)->send();
    }
    public function datatable_komposisi(Request $request,$idbarang,$id)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $data = KomposisiSupplier::with(['provinsi','kecamatan','kota','kelurahan','komposisi'])->whereHas('komposisi',function($query) use ($id,$idbarang){
            $query->where('id_komposisi',$id);
            $query->where('id_barang',$idbarang);
        })->paginate(25);
        return JsonResponseHandler::setResult($data)->send();
    }

    public function create()
    {
        return view('Komposisi::supplier.create');
    }

    public function store(Request $request,$idbarang,$id)
    {
        DB::beginTransaction();
        try{
            $payload = $request->all();
            if(isset($payload['is_from_id'])){
                $pivot = PivotKomposisiSupplier::create([
                    'id_komposisi' => $id,
                    'id_barang' => $idbarang,
                    'id_supplier' => $payload['id_supplier']
                ]);
            }else{
                $supplier = KomposisiSupplier::create($payload);
                $pivot = PivotKomposisiSupplier::create([
                    'id_komposisi' => $id,
                    'id_supplier' => $supplier->id
                ]);
            }

            DB::commit();
            return JsonResponseHandler::setResult($pivot)->send();
        }catch(Exception $e){
            DB::rollBack();
            return JsonResponseHandler::setResult($e->getMessage())->setCode(JsonResponseType::ERROR)->setStatus(400)->send();
        }

    }

    public function all(){
        $komposisi = Komposisi::with("satuan")->has('satuan')->get();
        return JsonResponseHandler::setResult($komposisi)->send();
    }

    public function show(Request $request, $id)
    {
        $komposisi = KomposisiRepository::get($id);
        return JsonResponseHandler::setResult($komposisi)->send();
    }

    public function edit($id)
    {
        return view('Komposisi::edit', ['komposisi_id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();
        unset($payload['created_at']);
        unset($payload['updated_at']);
        $komposisi = KomposisiRepository::update($id, $payload);
        return JsonResponseHandler::setResult($komposisi)->send();
    }

    public function destroy(Request $request, $id)
    {
        $delete = KomposisiRepository::delete($id);
        return JsonResponseHandler::setResult($delete)->send();
    }
}
