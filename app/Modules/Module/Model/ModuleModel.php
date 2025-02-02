<?php

namespace App\Modules\Module\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModuleModel extends Model {
    use SoftDeletes;
    protected $table = 'module';
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
}