<?php

namespace App\Modules\DataBarang\Models;

use App\Models\User;
use App\Modules\Satuan\Models\Satuan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataBarangFoto extends Model
{
    use SoftDeletes;
    protected $table = 'barang_foto';
    protected $guarded = [];
    protected $appends = ['url_foto'];
 
    public function satuan(){
        return $this->hasOne(Satuan::class,"id","satuan_id");
    }
    public function user(){
        return $this->hasOne(User::class,"id","created_by_user_id");
    }
    public function getUrlFotoAttribute(){
        return url($this->foto);
    }

    
}