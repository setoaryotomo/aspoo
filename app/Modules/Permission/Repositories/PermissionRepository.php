<?php

namespace App\Modules\Permission\Repositories;

use App\Modules\Menu\Model\MenuModel;
use App\Modules\Permission\Model\PermissionModel;
use App\Modules\Role\Model\RolePermissionModel;
use Illuminate\Support\Facades\Auth;

class PermissionRepository
{
    static public function getPermissionStatusOnMenuPath($menu_path)
    {
        $menu = MenuModel::where("path", $menu_path)->first();
        return PermissionRepository::getPermissionStatusOnMenu($menu->id);
    }

    static public function getPermissionStatusOnMenu($menu_id)
    {
        $user = Auth::user();
        $user_role_ids = $user->roleIds;
        $menu_permissions = PermissionModel::where("menu_id", $menu_id)->get();
        $user_permissions = RolePermissionModel::whereIn('role_id', $user_role_ids)->whereHas('permission.menu', function ($query) use ($menu_id) {
            $query->where('id', $menu_id);
        })->get()->toArray();
        $user_permission_ids = array_map(function($permission){
            return $permission['permission_id'];
        }, $user_permissions);
        
        $user_permission_status = array();
        foreach($menu_permissions as $permission) {
            $user_permission_status[$permission->code] = in_array($permission->id, $user_permission_ids) == true ? 'true' : 'false';
        }
        return $user_permission_status;
    }
}
