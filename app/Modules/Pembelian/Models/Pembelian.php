<?php

namespace App\Modules\Pembelian\Models;
    
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembelian extends Model
{
    use SoftDeletes;
    protected $table = 'pembelian';
    protected $guarded = [];
}