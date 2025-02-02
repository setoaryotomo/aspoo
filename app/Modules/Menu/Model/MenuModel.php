<?php

namespace App\Modules\Menu\Model;

use App\Handler\ModelSearchHandler;
use App\Modules\Module\Model\ModuleModel;
use App\Modules\Permission\Model\PermissionModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuModel extends Model
{
    use SoftDeletes;
    protected $table = 'menus';
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];

    // Relation
    public function permissions()
    {
        return $this->hasMany(PermissionModel::class, 'menu_id', 'id');
    }
    public function childs()
    {
        return $this->hasMany(MenuModel::class, 'parent_id', 'id');
    }
    public function parent()
    {
        return $this->belongsTo(MenuModel::class, 'parent_id', 'id');
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(ModuleModel::class, 'module_id', 'id');
    }

    // Scope
    public function scopeSearch($query, $keyword)
    {
        $searchable = ['name', 'path', 'description', 'parent.name'];
        return ModelSearchHandler::handle($query, $searchable, $keyword);
    }
}
