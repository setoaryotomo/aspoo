<?php

namespace App\Modules\InputSCM\Repositories;

use App\Modules\InputSCM\Models\Alamat\Kecamatan;
use App\Modules\InputSCM\Models\Alamat\Kelurahan;
use App\Modules\InputSCM\Models\Alamat\Kota;
use App\Modules\InputSCM\Models\Alamat\Provinsi;
use App\Modules\InputSCM\Models\InputSCM;

class AlamatRepository
{
    public static function getProvinsi(){
        $data =Provinsi::all();
        return $data;
    }
    public static function getKota($id){
        $data = Kota::where("province_id",$id)->get();
        return $data;
    }
    public static function getKecamatan($id){
        $data = Kecamatan::where("regency_id",$id)->get();
        return $data;
    }
    public static function getKelurahan($id){
        $data = Kelurahan::where("district_id",$id)->get();
        return $data;
    }
}