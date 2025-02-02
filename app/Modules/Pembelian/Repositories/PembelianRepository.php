<?php

namespace App\Modules\Pembelian\Repositories;

use App\Modules\Pembelian\Models\Pembelian;

class PembelianRepository
{
    public static function datatable($per_page = 15)
    {
        $data = Pembelian::paginate($per_page);
        return $data;
    }
    public static function get($pembelian_id)
    {
        $pembelian = Pembelian::where('id', $pembelian_id)->first();
        return $pembelian;
    }
    public static function create($pembelian)
    {
        $pembelian = Pembelian::create($pembelian);
        return $pembelian;
    }

    public static function update($pembelian_id, $pembelian)
    {
        Pembelian::where('id', $pembelian_id)->update($pembelian);
        $pembelian = Pembelian::where('id', $pembelian_id)->first();
        return $pembelian;
    }

    public static function delete($pembelian_id)
    {
        $delete = Pembelian::where('id', $pembelian_id)->delete();
        return $delete;
    }
}
