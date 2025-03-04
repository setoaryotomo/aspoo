<?php

namespace App\Modules\DataBarang\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InputStok extends Model
{
    // use SoftDeletes;
    protected $table = 'input_stok';
    protected $guarded = [];

    public function barang(){
        return $this->belongsTo(DataBarang::class,'id_barang_master');
    }
 
       
}