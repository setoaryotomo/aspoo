<?php

namespace App\Modules\Cabang\Repositories;

use App\Modules\Cabang\Models\Cabang;

class CabangRepository
{
    public static function datatable($per_page = 15)
    {
        $data = Cabang::with('user')->paginate($per_page);
        return $data;
    }
    public static function get($cabang_id)
    {
        $cabang = Cabang::where('id', $cabang_id)->first();
        return $cabang;
    }
    public static function create($cabang)
    {
        $cabang = Cabang::create($cabang);
        return $cabang;
    }

    public static function update($cabang_id, $cabang)
    {
        Cabang::where('id', $cabang_id)->update($cabang);
        $cabang = Cabang::where('id', $cabang_id)->first();
        return $cabang;
    }

    public static function delete($cabang_id)
    {
        $delete = Cabang::where('id', $cabang_id)->delete();
        return $delete;
    }
}
