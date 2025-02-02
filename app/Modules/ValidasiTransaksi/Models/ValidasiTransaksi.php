<?php

namespace App\Modules\ValidasiTransaksi\Models;
    
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ValidasiTransaksi extends Model
{
    use SoftDeletes;
    protected $table = 'transaksi_master';
    protected $guarded = [];


}