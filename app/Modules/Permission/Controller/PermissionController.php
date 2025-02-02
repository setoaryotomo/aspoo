<?php

namespace App\Modules\Permission\Controller;

use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Modules\Permission\Model\PermissionModel;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        return view('Permission::index');
    }
    public function datatable(Request $request)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $keyword = $request->input('keyword') != null ? $request->input('keyword') : null;
        $permissions = PermissionModel::search($keyword)->with('menu')->paginate($per_page);
        return JsonResponseHandler::setResult($permissions)->send();
    }

    public function detail(Request $request, $permission_id)
    {
        $permission = PermissionModel::where('id', $permission_id)->first();
        return JsonResponseHandler::setResult($permission)->send();
    }

    public function create()
    {
        return view('Permission::create');
    }

    public function store(Request $request)
    {
        $payload = $request->all();
        $permission = PermissionModel::create($payload);
        return JsonResponseHandler::setResult($permission)->send();
    }

    public function edit(Request $request, $permission_id)
    {
        return view('Permission::edit', ['permission_id' => $permission_id]);
    }

    public function update(Request $request, $permission_id)
    {
        $payload = $request->all();
        unset($payload['created_at']);
        unset($payload['updated_at']);

        $permission = PermissionModel::where('id', $permission_id)->update($payload);
        return JsonResponseHandler::setResult($permission)->send();
    }
}
