<?php

namespace App\Modules\Diskon\Controllers;

use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Modules\Diskon\Repositories\DiskonRepository;
use App\Modules\Diskon\Requests\DiskonCreateRequest;
use App\Modules\Permission\Repositories\PermissionRepository;
use Illuminate\Http\Request;

class DiskonController extends Controller
{
    public function index(Request $request)
    {
        $permissions = PermissionRepository::getPermissionStatusOnMenuPath($request->path());
        return view('Diskon::index', ['permissions' => $permissions]);
    }

    public function datatable(Request $request)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $data = DiskonRepository::datatable($per_page);
        return JsonResponseHandler::setResult($data)->send();
    }

    public function create()
    {
        return view('Diskon::create');
    }

    public function store(DiskonCreateRequest $request)
    {
        $payload = $request->all();
        $diskon = DiskonRepository::create($payload);
        return JsonResponseHandler::setResult($diskon)->send();
    }

    public function show(Request $request, $id)
    {
        $diskon = DiskonRepository::get($id);
        return JsonResponseHandler::setResult($diskon)->send();
    }

    public function edit($id)
    {
        return view('Diskon::edit', ['diskon_id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();
        unset($payload['created_at']);
        unset($payload['id']);
        unset($payload['updated_at']);
        $diskon = DiskonRepository::update($id, $payload);
        return JsonResponseHandler::setResult($diskon)->send();
    }

    public function destroy(Request $request, $id)
    {
        $delete = DiskonRepository::delete($id);
        return JsonResponseHandler::setResult($delete)->send();
    }
}
