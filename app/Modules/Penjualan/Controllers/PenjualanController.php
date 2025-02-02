<?php

namespace App\Modules\Penjualan\Controllers;

use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Modules\Penjualan\Models\Penjualan;
use App\Modules\Penjualan\Repositories\PenjualanRepository;
use App\Modules\Penjualan\Requests\PenjualanCreateRequest;
use App\Modules\Permission\Repositories\PermissionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PenjualanController extends Controller
{

    public function checkNomorFaktur(Request $request){
        $hasil = Penjualan::where('nomor_faktur',$request->nomor_faktur)->exists();
        return JsonResponseHandler::setResult(['is_error' => $hasil])->send();

    }
    public function index(Request $request)
    {
        $permissions = PermissionRepository::getPermissionStatusOnMenuPath($request->path());
        return view('Penjualan::index', ['permissions' => $permissions]);
    }

    public function datatable(Request $request)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $data = PenjualanRepository::datatable($per_page);
        return JsonResponseHandler::setResult($data)->send();
    }
    public function redirectPos(){
        return view('Penjualan::index');
    }

    public function create()
    {
        return view('Penjualan::create');
    }

    public function store(PenjualanCreateRequest $request)
    {
        $payload = $request->all();
        $penjualan = PenjualanRepository::create($payload);
        return JsonResponseHandler::setResult($penjualan)->send();
    }

    public function show(Request $request, $id)
    {
        $penjualan = PenjualanRepository::get($id);
        return JsonResponseHandler::setResult($penjualan)->send();
    }

    public function edit($id)
    {
        return view('Penjualan::edit', ['penjualan_id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();
        unset($payload['created_at']);
        unset($payload['updated_at']);
        $penjualan = PenjualanRepository::update($id, $payload);
        return JsonResponseHandler::setResult($penjualan)->send();
    }

    public function destroy(Request $request, $id)
    {
        $delete = PenjualanRepository::delete($id);
        return JsonResponseHandler::setResult($delete)->send();
    }
}
