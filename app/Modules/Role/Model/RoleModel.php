<?php

namespace App\Modules\Role\Model;

use App\Handler\ModelSearchHandler;
use App\Modules\Permission\Model\PermissionModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleModel extends Model
{
    use SoftDeletes;
    protected $table = 'roles';
    protected $guarded = [];

    // Scope
    public function scopeSearch($query, $keyword)
    {
        $searchable = ['name'];
        return ModelSearchHandler::handle($query, $searchable, $keyword);
    }

    // Relation
    public function permissions() {
        return $this->belongsToMany(PermissionModel::class, 'role_permissions', 'role_id', 'permission_id', 'id', 'id');
    }
}
