<?php

namespace App\Modules\Role\Model;

use App\Modules\Permission\Model\PermissionModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RolePermissionModel extends Model
{
    protected $table = 'role_permissions';
    protected $guarded = [];

    public function permission(): BelongsTo {
        return $this->belongsTo(PermissionModel::class, 'permission_id', 'id');
    }
}
