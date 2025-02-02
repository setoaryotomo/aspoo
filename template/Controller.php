<?php

namespace App\Modules\module_name\Controllers;

use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Modules\module_name\Repositories\module_nameRepository;
use App\Modules\module_name\Requests\module_nameCreateRequest;
use App\Modules\Permission\Repositories\PermissionRepository;
use Illuminate\Http\Request;

class module_nameController extends Controller
{
    public function index(Request $request)
    {
        $permissions = PermissionRepository::getPermissionStatusOnMenuPath($request->path());
        return view('module_name::index', ['permissions' => $permissions]);
    }

    public function datatable(Request $request)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $data = module_nameRepository::datatable($per_page);
        return JsonResponseHandler::setResult($data)->send();
    }

    public function create()
    {
        return view('module_name::create');
    }

    public function store(module_nameCreateRequest $request)
    {
        $payload = $request->all();
        $module_variable = module_nameRepository::create($payload);
        return JsonResponseHandler::setResult($module_variable)->send();
    }

    public function show(Request $request, $id)
    {
        $module_variable = module_nameRepository::get($id);
        return JsonResponseHandler::setResult($module_variable)->send();
    }

    public function edit($id)
    {
        return view('module_name::edit', ['module_variable_id' => $id]);
    }

    public function update(Request $request, $id)
    {
        $payload = $request->all();
        unset($payload['created_at']);
        unset($payload['updated_at']);
        $module_variable = module_nameRepository::update($id, $payload);
        return JsonResponseHandler::setResult($module_variable)->send();
    }

    public function destroy(Request $request, $id)
    {
        $delete = module_nameRepository::delete($id);
        return JsonResponseHandler::setResult($delete)->send();
    }
}
