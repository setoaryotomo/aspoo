<?php

namespace App\Modules\Satuan\Controllers;

use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Modules\Satuan\Repositories\SatuanRepository;
use App\Modules\Satuan\Requests\SatuanCreateRequest;
use App\Modules\Permission\Repositories\PermissionRepository;
use App\Modules\Satuan\Models\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    public function index(Request $request)
    {
        $permissions = PermissionRepository::getPermissionStatusOnMenuPath($request->path());
        return view('Satuan::index', ['permissions' => $permissions]);
    }

    public function datatable(Request $request)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $data = SatuanRepository::datatable($per_page);
        return JsonResponseHandler::setResult($data)->send();
    }

    public function create()
    {
        return view('Satuan::create');
    }

    public function store(SatuanCreateRequest $request)
    {
        $payload = $request->all();
        $satuan = SatuanRepository::create($payload);
        return JsonResponseHandler::setResult($satuan)->send();
    }

    public function show(Request $request, $id)
    {
        $satuan = SatuanRepository::get($id);
        return JsonResponseHandler::setResult($satuan)->send();
    }
    public function all(Request $request)
    {
        $modules = Satuan::get();
        return JsonResponseHandler::setResult($modules)->send();
    }

    public function edit($id)
    {
        return view('Satuan::edit', ['satuan_id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();
        unset($payload['created_at']);
        unset($payload['updated_at']);
        $satuan = SatuanRepository::update($id, $payload);
        return JsonResponseHandler::setResult($satuan)->send();
    }

    public function destroy(Request $request, $id)
    {
        $delete = SatuanRepository::delete($id);
        return JsonResponseHandler::setResult($delete)->send();
    }
}
