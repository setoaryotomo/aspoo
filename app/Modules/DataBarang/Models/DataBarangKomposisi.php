<?php

namespace App\Modules\DataBarang\Models;

use App\Models\User;
use App\Modules\Komposisi\Models\Komposisi;
use App\Modules\Satuan\Models\Satuan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataBarangKomposisi extends Model
{
    use SoftDeletes;
    protected $table = 'barang_komposisi';
    protected $guarded = [];

    public function komposisi(){
        return $this->belongsTo(Komposisi::class,"id_komposisi");
    }
    public function barang(){
        return $this->belongsTo(DataBarang::class,'id_barang');
    }
 
    

    
}