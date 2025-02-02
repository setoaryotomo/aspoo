<?php

namespace App\Modules\MasterUMKM\Repositories;

use App\Modules\MasterUMKM\Models\MasterUMKM;

class MasterUMKMRepository
{
    public static function datatable($per_page = 15)
    {
        $data = MasterUMKM::paginate($per_page);
        return $data;
    }
    public static function get($masterumkm_id)
    {
        $masterumkm = MasterUMKM::where('id', $masterumkm_id)->first();
        return $masterumkm;
    }
    public static function create($masterumkm)
    {
        $masterumkm = MasterUMKM::create($masterumkm);
        return $masterumkm;
    }

    public static function update($masterumkm_id, $masterumkm)
    {
        MasterUMKM::where('id', $masterumkm_id)->update($masterumkm);
        $masterumkm = MasterUMKM::where('id', $masterumkm_id)->first();
        return $masterumkm;
    }

    public static function delete($masterumkm_id)
    {
        $delete = MasterUMKM::where('id', $masterumkm_id)->delete();
        return $delete;
    }
}
