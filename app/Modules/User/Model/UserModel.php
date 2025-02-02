<?php

namespace App\Modules\User\Model;

use App\Handler\ModelSearchHandler;
use App\Modules\Portal\Model\UserDetail;
use App\Modules\Role\Model\RoleModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserModel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    protected $table = 'users';
    protected $guarded = [];


    // Scope
    public function scopeSearch($query, $keyword)
    {
        $searchable = ['name'];
        return ModelSearchHandler::handle($query, $searchable, $keyword);
    }

    // Relations
    public function roles()
    {
        return $this->belongsToMany(RoleModel::class, 'user_roles', 'user_id', 'role_id')->withPivot('deleted_at')->wherePivot('deleted_at', NULL);
    }

    public function detail(){
        return $this->hasOne(UserDetail::class,"user_id");
    }
    // Function
    protected function getRoles() {
        return $this->roles();
    }

    protected function getRoleIdsAttribute() {
        $roles = $this->roles->toArray();
        return array_map(function($role) {
            return $role['id'];
        }, $roles);
    }

    public function isFollowing($tokoId)
    {
        return $this->pengikut()->where('toko_id', $tokoId)->exists();
    }

    public function pengikut()
    {
        return $this->hasMany('App\Modules\Penjualan\Models\Pengikut', 'user_id');
    }

}
