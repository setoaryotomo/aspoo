<?php

namespace App\Modules\MasterUMKM\Repositories;

use App\Modules\DataBarang\Models\DataBarang;
use App\Modules\MasterUMKM\Models\MasterUMKM;

class MasterUMKMRepository
{
    public static function datatable($per_page = 15, $keyword = '')
    {
        $query = MasterUMKM::query();

        // Apply keyword search if provided
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'LIKE', "%{$keyword}%");
            });
        }

        $data = $query->paginate($per_page);
        return $data;
    }

    public static function barang_datatable($per_page = 15)
    {
        $data = DataBarang::with(['user', 'satuan'])->paginate($per_page);
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