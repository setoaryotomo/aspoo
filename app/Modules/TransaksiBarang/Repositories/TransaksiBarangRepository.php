<?php

namespace App\Modules\TransaksiBarang\Repositories;

use App\Modules\TransaksiBarang\Models\TransaksiBarang;

class TransaksiBarangRepository
{
    public static function datatable($per_page = 15)
    {
        $data = TransaksiBarang::with(['dataChildren','dataChildren.barang'])->paginate($per_page);
        return $data;
    }
    public static function get($transaksi_barang_id)
    {
        $transaksi_barang = TransaksiBarang::with(['dataChildren','dataChildren.barang'])->where('id', $transaksi_barang_id)->first();
        return $transaksi_barang;
    }
    public static function create($transaksi_barang)
    {
        $transaksi_barang = TransaksiBarang::create($transaksi_barang);
        return $transaksi_barang;
    }

    public static function update($transaksi_barang_id, $transaksi_barang)
    {
        TransaksiBarang::where('id', $transaksi_barang_id)->update($transaksi_barang);
        $transaksi_barang = TransaksiBarang::where('id', $transaksi_barang_id)->first();
        return $transaksi_barang;
    }

    public static function delete($transaksi_barang_id)
    {
        $delete = TransaksiBarang::where('id', $transaksi_barang_id)->delete();
        return $delete;
    }
}
