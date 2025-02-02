<?php

namespace App\Modules\Presensi\Models;
    
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Presensi extends Model
{
    use SoftDeletes;
    protected $table = 'presensi';
    protected $guarded = [];
}