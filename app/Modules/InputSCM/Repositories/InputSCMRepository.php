<?php

namespace App\Modules\InputSCM\Repositories;

use App\Modules\InputSCM\Models\InputSCM;
use App\Modules\InputSCM\Models\UMKM;

class InputSCMRepository
{
    public static function datatable($per_page = 15)
    {
        $data = UMKM::paginate($per_page);
        return $data;
    }
    public static function get($input_scm_id)
    {
        $input_scm = UMKM::where('id_umkm', $input_scm_id)->first();
        return $input_scm;
    }
    public static function create($input_scm)
    {
        $input_scm = UMKM::create($input_scm);
        return $input_scm;
    }

    public static function update($input_scm_id, $input_scm)
    {
        UMKM::where('id', $input_scm_id)->update($input_scm);
        $input_scm = UMKM::where('id', $input_scm_id)->first();
        return $input_scm;
    }

    public static function delete($input_scm_id)
    {
        $delete = UMKM::where('id_umkm', $input_scm_id)->delete();
        return $delete;
    }
}
