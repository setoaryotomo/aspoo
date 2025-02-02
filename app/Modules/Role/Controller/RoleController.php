<?php

namespace App\Modules\Role\Controller;

use App\Handler\JsonResponseHandler;
use App\Http\Controllers\Controller;
use App\Modules\Permission\Model\PermissionModel;
use App\Modules\Role\Model\RoleModel;
use App\Modules\Role\Model\RolePermissionModel;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return view('Role::index');
    }
    public function datatable(Request $request)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $keyword = $request->input('keyword') != null ? $request->input('keyword') : null;
        $roles = RoleModel::search($keyword)->paginate($per_page);
        return JsonResponseHandler::setResult($roles)->send();
    }

    public function detail(Request $request, $role_id)
    {
        $role = RoleModel::where('id', $role_id)->first();
        return JsonResponseHandler::setResult($role)->send();
    }

    public function create()
    {
        return view('Role::create');
    }

    public function store(Request $request)
    {
        $payload = $request->all();
        $role = RoleModel::create($payload);
        return JsonResponseHandler::setResult($role)->send();
    }

    public function edit(Request $request, $role_id)
    {
        return view('Role::edit', ['role_id' => $role_id]);
    }

    public function update(Request $request, $role_id)
    {
        $payload = $request->all();
        unset($payload['created_at']);
        unset($payload['updated_at']);

        $role = RoleModel::where('id', $role_id)->update($payload);
        return JsonResponseHandler::setResult($role)->send();
    }

    public function all(Request $request)
    {
        $roles = RoleModel::get();
        return JsonResponseHandler::setResult($roles)->send();
    }

    public function permissionDatatable(Request $request, $role_id)
    {
        $per_page = $request->input('per_page') != null ? $request->input('per_page') : 15;
        $keyword = $request->input('keyword') != null ? $request->input('keyword') : null;
        $role = RoleModel::where('id', $role_id)->first();
        $permissions = $role->permissions()->with('menu')->search($keyword)->orderBy('menu_id')->paginate($per_page);
        return JsonResponseHandler::setResult($permissions)->send();
    }

    public function addPermission(Request $request, $role_id)
    {
        $permission_id = $request->input('permission_id');
        $menu_id = $request->input('menu_id');
        if ($permission_id == "all") {
            $permissions = PermissionModel::where('menu_id', $menu_id)->get();
            foreach ($permissions as $permission) {
                $upsert = RolePermissionModel::firstOrCreate(['role_id' => $role_id, 'permission_id' => $permission->id], ['role_id' => $role_id, 'permission_id' => $permission->id]);
            }
        } else {
            $upsert = RolePermissionModel::firstOrCreate(['role_id' => $role_id, 'permission_id' => $permission_id], ['role_id' => $role_id, 'permission_id' => $permission_id]);
        }
        return JsonResponseHandler::setResult($upsert)->send();
    }

    public function deletePermission(Request $request, $role_id, $permission_id)
    {
        $delete = RolePermissionModel::where('role_id', $role_id)->where('permission_id', $permission_id)->delete();
        return JsonResponseHandler::setResult($delete)->send();
    }
}
