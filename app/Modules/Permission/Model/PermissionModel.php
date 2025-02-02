<?php

namespace App\Modules\Permission\Model;

use App\Handler\ModelSearchHandler;
use App\Modules\Menu\Model\MenuModel;
use App\Modules\Role\Model\RoleModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermissionModel extends Model
{
    use SoftDeletes;
    protected $table = 'permissions';
    protected $guarded = [];

    // Scope
    public function scopeSearch($query, $keyword)
    {
        $searchable = ['code', 'menu.name','description'];
        return ModelSearchHandler::handle($query, $searchable, $keyword);
    }

    // Relation
    public function roles()
    {
        return $this->belongsToMany(RoleModel::class, 'role_permissions', 'permission_id', 'role_id');
    }
    public function menu()
    {
        return $this->belongsTo(MenuModel::class, 'menu_id', 'id');
    }

}
