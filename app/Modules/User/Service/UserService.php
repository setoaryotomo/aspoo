<?php

namespace App\Modules\User\Service;

use App\Modules\Permission\Model\PermissionModel;
use App\Modules\User\Model\UserModel;

class UserService
{
    public static function checkIsHavePermission($user_id, $permission_code)
    {
        $user_with_permission = UserModel::with([
            'roles',
            'roles.permissions'
        ])
        ->where('id', $user_id)
        ->whereHas('roles.permissions', function ($q) use ($permission_code) {
            $q->where('code', $permission_code);
        })->first();
        
        if($user_with_permission == null) {
            return false;
        }

        return true;
    }
}
