<?php

namespace App\Modules\module_name\Models;
    
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class module_name extends Model
{
    use SoftDeletes;
    protected $table = 'module_variable';
    protected $guarded = [];
}