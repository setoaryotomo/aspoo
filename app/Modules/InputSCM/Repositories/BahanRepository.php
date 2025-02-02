<?php

namespace App\Modules\InputSCM\Repositories;

use App\Modules\InputSCM\Models\Bahan;

class BahanRepository
{
    public static function datatable($per_page = 15,$id_barang)
    {
        $data = Bahan::where('id_barang',$id_barang)->paginate($per_page);
        return $data;
    }
    public static function get($input_scm_id)
    {
        $input_scm = Bahan::where('id', $input_scm_id)->first();
        return $input_scm;
    }
    public static function create($input_scm)
    {
        $input_scm = Bahan::create($input_scm);
        return $input_scm;
    }

    public static function update($input_scm_id, $input_scm)
    {
        Bahan::where('id', $input_scm_id)->update($input_scm);
        $input_scm = Bahan::where('id', $input_scm_id)->first();
        return $input_scm;
    }

    public static function delete($input_scm_id)
    {
        $delete = Bahan::where('id_bahan_baku', $input_scm_id)->delete();
        return $delete;
    }
}