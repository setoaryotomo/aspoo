<?php

namespace App\Modules\InputSCM\Repositories;

use App\Modules\InputSCM\Models\BarangSCM;

class BarangSCMRepository
{
    public static function datatable($per_page = 15,$id_umkm)
    {
        $data = BarangSCM::where('id_umkm',$id_umkm)->paginate($per_page);
        return $data;
    }
    public static function get($input_scm_id)
    {
        $input_scm = BarangSCM::where('id', $input_scm_id)->first();
        return $input_scm;
    }
    public static function create($input_scm)
    {
        $input_scm = BarangSCM::create($input_scm);
        return $input_scm;
    }

    public static function update($input_scm_id, $input_scm)
    {
        BarangSCM::where('id', $input_scm_id)->update($input_scm);
        $input_scm = BarangSCM::where('id', $input_scm_id)->first();
        return $input_scm;
    }

    public static function delete($input_scm_id)
    {
        $delete = BarangSCM::where('id_barang', $input_scm_id)->delete();
        return $delete;
    }
}
