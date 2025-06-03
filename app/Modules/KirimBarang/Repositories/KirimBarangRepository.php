<?php

namespace App\Modules\KirimBarang\Repositories;

use App\Modules\KirimBarang\Models\KirimBarang;

class KirimBarangRepository
{
    public static function datatable($per_page = 15, $keyword = '', $toko_id = null)
    {
        $query = KirimBarang::with('pembeli')
            ->where('status', 2);

        // Apply toko_id filter for non-admin users
        if ($toko_id !== null) {
            $query->where('toko_id', $toko_id);
        }

        // Apply keyword search if provided
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('kode_transaksi', 'LIKE', "%{$keyword}%")
                  ->orWhere('tanggal', 'LIKE', "%{$keyword}%")
                  ->orWhereHas('pembeli', function ($pembeliQuery) use ($keyword) {
                      $pembeliQuery->where('name', 'LIKE', "%{$keyword}%");
                  });
            });
        }

        $data = $query->paginate($per_page);
        return $data;
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
