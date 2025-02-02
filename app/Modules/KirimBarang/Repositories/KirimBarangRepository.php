<?php

namespace App\Modules\KirimBarang\Repositories;

use App\Modules\KirimBarang\Models\KirimBarang;

class KirimBarangRepository
{
    public static function datatable($per_page = 15)
    {
    }
    public static function get($kirim_barang_id)
    {
        $kirim_barang = KirimBarang::where('id', $kirim_barang_id)->first();
        return $kirim_barang;
    }
    public static function create($kirim_barang)
    {
        $kirim_barang = KirimBarang::create($kirim_barang);
        return $kirim_barang;
    }

    public static function update($kirim_barang_id, $kirim_barang)
    {
        KirimBarang::where('id', $kirim_barang_id)->update($kirim_barang);
        $kirim_barang = KirimBarang::where('id', $kirim_barang_id)->first();
        return $kirim_barang;
    }

    public static function delete($kirim_barang_id)
    {
        $delete = KirimBarang::where('id', $kirim_barang_id)->delete();
        return $delete;
    }
}
