<?php

namespace App\Modules\MasterUMKM\Controllers;

use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Modules\DataBarang\Models\DataBarang;
use App\Modules\MasterUMKM\Models\MasterUMKM;
use App\Modules\MasterUMKM\Repositories\MasterUMKMRepository;
use App\Modules\MasterUMKM\Requests\MasterUMKMCreateRequest;
use App\Modules\Permission\Repositories\PermissionRepository;
use Illuminate\Http\Request;

class MasterUMKMController extends Controller
{
    public function index(Request $request)
    {
        $permissions = PermissionRepository::getPermissionStatusOnMenuPath($request->path());
        return view('MasterUMKM::index', ['permissions' => $permissions]);
    }

    public function datatable(Request $request)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $data = MasterUMKMRepository::datatable($per_page);
        return JsonResponseHandler::setResult($data)->send();
    }

    public function create()
    {
        return view('MasterUMKM::create');
    }

    public function store(MasterUMKMCreateRequest $request)
    {
        $payload = $request->all();
        $masterumkm = MasterUMKMRepository::create($payload);
        return JsonResponseHandler::setResult($masterumkm)->send();
    }

    public function show(Request $request, $id)
    {
        $masterumkm = MasterUMKMRepository::get($id);
        return JsonResponseHandler::setResult($masterumkm)->send();
    }

    public function edit($id)
    {
        return view('MasterUMKM::edit', ['masterumkm_id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();
        unset($payload['created_at']);
        unset($payload['updated_at']);
        $masterumkm = MasterUMKMRepository::update($id, $payload);
        return JsonResponseHandler::setResult($masterumkm)->send();
    }

    public function destroy(Request $request, $id)
    {
        $delete = MasterUMKMRepository::delete($id);
        return JsonResponseHandler::setResult($delete)->send();
    }

    public function barang_index(Request $request, $id)
{
    
    $umkm = MasterUMKM::where('user_id',$id)->first();
    
    // You don't need to fetch the barang data here since you're using the datatable
    // Just pass the UMKM ID
    return view('MasterUMKM::barang_index', [
        'id' => $id,
        'umkm' => $umkm
    ]);
}

public function barang_datatable(Request $request, $id)
{
    $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
    $data = DataBarang::where('created_by_user_id', $id)->with(['user', 'satuan'])->paginate($per_page);
    return JsonResponseHandler::setResult($data)->send();
}

}
