<?php

namespace App\Modules\Satuan\Models;
    
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Satuan extends Model
{
    protected $table = 'satuan';
    protected $guarded = [];
    protected $fillable = ['satuan_nama','satuan_simbol'];
}