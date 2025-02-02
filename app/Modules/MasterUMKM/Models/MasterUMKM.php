<?php

namespace App\Modules\MasterUMKM\Models;
    
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterUMKM extends Model
{
    use SoftDeletes;
    protected $table = 'users_toko';
    protected $guarded = [];
}