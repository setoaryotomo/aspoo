<?php

namespace App\Modules\Penjualan\Repositories;

use App\Modules\Penjualan\Models\Penjualan;

class PenjualanRepository
{
    public static function datatable($per_page = 15)
    {
        $data = Penjualan::paginate($per_page);
        return $data;
    }
    public static function get($penjualan_id)
    {
        $penjualan = Penjualan::where('id', $penjualan_id)->first();
        return $penjualan;
    }
    public static function create($penjualan)
    {
        $penjualan = Penjualan::create($penjualan);
        return $penjualan;
    }

    public static function update($penjualan_id, $penjualan)
    {
        Penjualan::where('id', $penjualan_id)->update($penjualan);
        $penjualan = Penjualan::where('id', $penjualan_id)->first();
        return $penjualan;
    }

    public static function delete($penjualan_id)
    {
        $delete = Penjualan::where('id', $penjualan_id)->delete();
        return $delete;
    }
}
