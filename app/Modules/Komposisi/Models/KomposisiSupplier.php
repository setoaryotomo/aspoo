<?php

namespace App\Modules\Komposisi\Models;

use App\Modules\Satuan\Models\Satuan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Modules\InputSCM\Models\Alamat\Kecamatan;
use App\Modules\InputSCM\Models\Alamat\Kelurahan;
use App\Modules\InputSCM\Models\Alamat\Kota;
use App\Modules\InputSCM\Models\Alamat\Provinsi;
use App\Modules\Komposisi\Models\Komposisi;

class KomposisiSupplier extends Model
{
    protected $table = 'komposisi_supplier';
    protected $guarded = [];

    public function kecamatan(){
        return $this->belongsTo(Kecamatan::class,"id_kecamatan");
    }
    public function kelurahan(){
        return $this->belongsTo(Kelurahan::class,"id_kelurahan");
    }
    public function kota(){
        return $this->belongsTo(Kota::class,"id_kota");
    }
    public function provinsi(){
        return $this->belongsTo(Provinsi::class,"id_provinsi");
    }
    public function komposisi(){
        return $this->belongsToMany(Komposisi::class,"pivot_komposisi_supplier",'id_supplier','id_komposisi');
    }
  
}