<?php

namespace App\Modules\ApproveUser\Models;

use App\Modules\Role\Model\RoleModel;
use App\Modules\User\Model\UserRoleModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApproveUser extends Model
{
    use SoftDeletes;
    protected $table = 'users';
    protected $guarded = [];
    protected $appends = ['role_nama'];
    public function getRoleNamaAttribute(){
        $userRole = UserRoleModel::where('user_id',$this->id)->first();
        if($userRole){
            $role = RoleModel::where("id",$userRole->role_id)->first();
            return $role->name;
        }else{
            return "";
        }
    }

    public function role(){
        return $this->hasMany(UserRoleModel::class,"user_id","id");
    }
}
