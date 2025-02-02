<?php

namespace App\Modules\Presensi\Controllers;

use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Modules\Presensi\Repositories\PresensiRepository;
use App\Modules\Presensi\Requests\PresensiCreateRequest;
use App\Modules\Permission\Repositories\PermissionRepository;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    public function index(Request $request)
    {
        $permissions = PermissionRepository::getPermissionStatusOnMenuPath($request->path());
        return view('Presensi::index', ['permissions' => $permissions]);
    }

    public function datatable(Request $request)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $data = PresensiRepository::datatable($per_page);
        return JsonResponseHandler::setResult($data)->send();
    }

    public function create()
    {
        return view('Presensi::create');
    }

    public function store(PresensiCreateRequest $request)
    {
        $payload = $request->all();
        $presensi = PresensiRepository::create($payload);
        return JsonResponseHandler::setResult($presensi)->send();
    }

    public function show(Request $request, $id)
    {
        $presensi = PresensiRepository::get($id);
        return JsonResponseHandler::setResult($presensi)->send();
    }

    public function edit($id)
    {
        return view('Presensi::edit', ['presensi_id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();
        unset($payload['created_at']);
        unset($payload['updated_at']);
        $presensi = PresensiRepository::update($id, $payload);
        return JsonResponseHandler::setResult($presensi)->send();
    }

    public function destroy(Request $request, $id)
    {
        $delete = PresensiRepository::delete($id);
        return JsonResponseHandler::setResult($delete)->send();
    }
}
