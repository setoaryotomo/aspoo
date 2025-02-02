<?php

namespace App\Modules\InputSCM\Controllers;

use App\Handler\FileHandler;
use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Modules\InputSCM\Models\Bahan;
use App\Modules\InputSCM\Models\Supplier;
use App\Modules\InputSCM\Models\UMKM;
use App\Modules\InputSCM\Repositories\BahanRepository;
use App\Modules\InputSCM\Repositories\BarangSCMRepository;
use App\Modules\InputSCM\Repositories\SupplierRepository;
use App\Modules\InputSCM\Requests\InputSCMCreateRequest;
use App\Modules\Permission\Repositories\PermissionRepository;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request,$id)
    {
        $bahan = Bahan::find($id);
        $permissions = PermissionRepository::getPermissionStatusOnMenuPath("input-scm");
        return view('InputSCM::supplier.index', ['permissions' => $permissions, 'bahan'=> $bahan, 'urlnow' => $request->path()]);
    }

    public function datatable(Request $request,$id)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $data = SupplierRepository::datatable($per_page,$id);
        return JsonResponseHandler::setResult($data)->send();
    }

    public function create(Request $request,$id)
    {
        $bahan = Bahan::find($id);
     
        return view('InputSCM::supplier.create',["bahan" => $bahan, 'urlnow' => $request->path()]);
    }

    public function store(Request $request,$id)
    {
        $payload = $request->all();
        $payload['id_bahan_baku'] = $id;
        $input_scm = SupplierRepository::create($payload);
        return JsonResponseHandler::setResult($input_scm)->send();
    }

    public function show(Request $request, $id)
    {
        $input_scm = InputSCMRepository::get($id);
        return JsonResponseHandler::setResult($input_scm)->send();
    }

    public function edit($id)
    {
        return view('InputSCM::edit', ['input_scm_id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();
        unset($payload['created_at']);
        unset($payload['updated_at']);
        $input_scm = InputSCMRepository::update($id, $payload);
        return JsonResponseHandler::setResult($input_scm)->send();
    }

    public function destroy(Request $request, $id,$ids)
    {
        $delete = SupplierRepository::delete($ids);
        return JsonResponseHandler::setResult($delete)->send();
    }
}
