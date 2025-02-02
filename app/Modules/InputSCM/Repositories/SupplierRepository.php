<?php

namespace App\Modules\InputSCM\Repositories;

use App\Modules\InputSCM\Models\Supplier;

class SupplierRepository
{
    public static function datatable($per_page = 15,$id_bahan)
    {
        $data = Supplier::where('id_bahan_baku',$id_bahan)->paginate($per_page);
        return $data;
    }
    public static function get($input_scm_id)
    {
        $input_scm = Supplier::where('id', $input_scm_id)->first();
        return $input_scm;
    }
    public static function create($input_scm)
    {
        $input_scm = Supplier::create($input_scm);
        return $input_scm;
    }
    public static function update($input_scm_id, $input_scm)
    {
        Supplier::where('id', $input_scm_id)->update($input_scm);
        $input_scm = Supplier::where('id', $input_scm_id)->first();
        return $input_scm;
    }

    public static function delete($input_scm_id)
    {
        $delete = Supplier::where('id_supplier', $input_scm_id)->delete();
        return $delete;
    }
}