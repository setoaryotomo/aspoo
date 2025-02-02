<?php

namespace App\Modules\Satuan\Repositories;

use App\Modules\Satuan\Models\Satuan;

class SatuanRepository
{
    public static function datatable($per_page = 15)
    {
        $data = Satuan::paginate($per_page);
        return $data;
    }
    public static function get($satuan_id)
    {
        $satuan = Satuan::where('id', $satuan_id)->first();
        return $satuan;
    }
    public static function create($satuan)
    {
        $satuan = Satuan::create($satuan);
        return $satuan;
    }

    public static function update($satuan_id, $satuan)
    {
        Satuan::where('id', $satuan_id)->update($satuan);
        $satuan = Satuan::where('id', $satuan_id)->first();
        return $satuan;
    }

    public static function delete($satuan_id)
    {
        $delete = Satuan::where('id', $satuan_id)->delete();
        return $delete;
    }
}
