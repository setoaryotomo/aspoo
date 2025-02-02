<?php

namespace App\Modules\InputSCM\Models;

use App\Modules\DataBarang\Models\DataBarang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BarangSCM extends Model
{
    use SoftDeletes;
    protected $table = 'scm_barang';
    protected $primaryKey = "id_barang";
    protected $guarded = [];
    protected $appends = ['id','harga_user'];
    public function getHargaUserAttribute(){
        return 10000;
    }
    public function getIdAttribute(){
        return $this->id_barang;
    }
    public function bahan(){
        return $this->hasMany(Bahan::class,"id_barang");
    }
    public function barang(){
        return $this->hasOne(DataBarang::class,"id","id_barang_master");
    }
}