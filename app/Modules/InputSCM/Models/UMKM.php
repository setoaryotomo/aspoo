<?php

namespace App\Modules\InputSCM\Models;
    
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Modules\InputSCM\Models\Alamat\Kecamatan;
use App\Modules\InputSCM\Models\Alamat\Kelurahan;
use App\Modules\InputSCM\Models\Alamat\Kota;
use App\Modules\InputSCM\Models\Alamat\Provinsi;

class UMKM extends Model
{
    use SoftDeletes;
    protected $primaryKey = "id_umkm";
    protected $table = 'scm_umkm';
    protected $guarded = [];
    protected $appends = ['id'];
    public function getIdAttribute(){
        return $this->id_umkm;
    }

    public function barang(){
        return $this->hasMany(BarangSCM::class,"id_umkm",'id_umkm');
    }
    public function kecamatan(){
        return $this->belongsTo(Kecamatan::class,"kecamatan");
    }
    public function kelurahan(){
        return $this->belongsTo(Kelurahan::class,"kelurahan");
    }
    public function kota(){
        return $this->belongsTo(Kota::class,"kota");
    }
    public function provinsi(){
        return $this->belongsTo(Provinsi::class,"provinsi");
    }
    public function user(){
        return $this->hasOne(TokoUser::class,"user_id","user_id");
    }
}