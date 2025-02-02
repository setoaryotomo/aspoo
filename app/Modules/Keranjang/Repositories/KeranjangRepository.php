<?php

namespace App\Modules\Keranjang\Repositories;

use App\Modules\Keranjang\Models\Keranjang;

class KeranjangRepository
{
    public static function datatable($per_page = 15)
    {
        $data = Keranjang::paginate($per_page);
        return $data;
    }
    public static function get($keranjang_id)
    {
        $keranjang = Keranjang::where('id', $keranjang_id)->first();
        return $keranjang;
    }
    public static function create($keranjang)
    {
        $keranjang = Keranjang::create($keranjang);
        return $keranjang;
    }

    public static function update($keranjang_id, $keranjang)
    {
        Keranjang::where('id', $keranjang_id)->update($keranjang);
        $keranjang = Keranjang::where('id', $keranjang_id)->first();
        return $keranjang;
    }

    public static function delete($keranjang_id)
    {
        $delete = Keranjang::where('id', $keranjang_id)->delete();
        return $delete;
    }
}
