<?php

namespace App\Modules\KirimBarang\Models;
    
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KirimBarang extends Model
{
    use SoftDeletes;
    protected $table = 'transaksi';
    protected $guarded = [];
}