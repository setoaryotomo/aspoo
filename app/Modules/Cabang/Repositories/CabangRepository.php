<?php

namespace App\Modules\cabang\Repositories;

use App\Modules\cabang\Models\cabang;

class cabangRepository
{
    public static function datatable($per_page = 15)
    {
        $data = cabang::with('user')->paginate($per_page);
        return $data;
    }
    public static function get($cabang_id)
    {
        $cabang = cabang::where('id', $cabang_id)->first();
        return $cabang;
    }
    public static function create($cabang)
    {
        $cabang = cabang::create($cabang);
        return $cabang;
    }

    public static function update($cabang_id, $cabang)
    {
        cabang::where('id', $cabang_id)->update($cabang);
        $cabang = cabang::where('id', $cabang_id)->first();
        return $cabang;
    }

    public static function delete($cabang_id)
    {
        $delete = cabang::where('id', $cabang_id)->delete();
        return $delete;
    }
}
