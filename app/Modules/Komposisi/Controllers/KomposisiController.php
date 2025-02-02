<?php

namespace App\Modules\Komposisi\Controllers;

use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Modules\Komposisi\Models\Komposisi;
use App\Modules\Komposisi\Repositories\KomposisiRepository;
use App\Modules\Komposisi\Requests\KomposisiCreateRequest;
use App\Modules\Permission\Repositories\PermissionRepository;
use Illuminate\Http\Request;

class KomposisiController extends Controller
{
    public function index(Request $request)
    {
        $permissions = PermissionRepository::getPermissionStatusOnMenuPath($request->path());
        return view('Komposisi::index', ['permissions' => $permissions]);
    }

    public function datatable(Request $request)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $data = KomposisiRepository::datatable($per_page);
        return JsonResponseHandler::setResult($data)->send();
    }

    public function create()
    {
        return view('Komposisi::create');
    }

    public function store(KomposisiCreateRequest $request)
    {
        $payload = $request->all();
        $komposisi = KomposisiRepository::create($payload);
        return JsonResponseHandler::setResult($komposisi)->send();
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
