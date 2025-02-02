<?php

namespace App\Modules\Pembelian\Controllers;

use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Modules\Pembelian\Repositories\PembelianRepository;
use App\Modules\Pembelian\Requests\PembelianCreateRequest;
use App\Modules\Permission\Repositories\PermissionRepository;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    public function index(Request $request)
    {
        $permissions = PermissionRepository::getPermissionStatusOnMenuPath($request->path());
        return view('Pembelian::index', ['permissions' => $permissions]);
    }

    public function datatable(Request $request)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $data = PembelianRepository::datatable($per_page);
        return JsonResponseHandler::setResult($data)->send();
    }

    public function create()
    {
        return view('Pembelian::create');
    }

    public function store(PembelianCreateRequest $request)
    {
        $payload = $request->all();
        $pembelian = PembelianRepository::create($payload);
        return JsonResponseHandler::setResult($pembelian)->send();
    }

    public function show(Request $request, $id)
    {
        $pembelian = PembelianRepository::get($id);
        return JsonResponseHandler::setResult($pembelian)->send();
    }

    public function edit($id)
    {
        return view('Pembelian::edit', ['pembelian_id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();
        unset($payload['created_at']);
        unset($payload['updated_at']);
        $pembelian = PembelianRepository::update($id, $payload);
        return JsonResponseHandler::setResult($pembelian)->send();
    }

    public function destroy(Request $request, $id)
    {
        $delete = PembelianRepository::delete($id);
        return JsonResponseHandler::setResult($delete)->send();
    }
}
