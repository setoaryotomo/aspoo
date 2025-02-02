<?php

namespace App\Modules\Penjualan\Models;
    
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $guarded = [];
}