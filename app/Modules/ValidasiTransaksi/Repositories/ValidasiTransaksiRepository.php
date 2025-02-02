<?php

namespace App\Modules\ValidasiTransaksi\Repositories;

use App\Modules\Portal\Model\TransaksiMaster;
use App\Modules\ValidasiTransaksi\Models\ValidasiTransaksi;

class ValidasiTransaksiRepository
{
    public static function datatable($per_page = 15)
    {
        $data = TransaksiMaster::with(['transaksi'])->whereHas('transaksi',function($query){
            $query->where('status',1);  
        })->paginate($per_page);

        return $data;
    }
    public static function get($validasi_transaksi_id)
    {
        $validasi_transaksi = ValidasiTransaksi::where('kode_transaksi', $validasi_transaksi_id)->first();
        return $validasi_transaksi;
    }
    public static function create($validasi_transaksi)
    {
        $validasi_transaksi = ValidasiTransaksi::create($validasi_transaksi);
        return $validasi_transaksi;
    }

    public static function update($validasi_transaksi_id, $validasi_transaksi)
    {
        ValidasiTransaksi::where('kode_transaksi', $validasi_transaksi_id)->update($validasi_transaksi);
        $validasi_transaksi = ValidasiTransaksi::where('kode_transaksi', $validasi_transaksi_id)->first();
        return $validasi_transaksi;
    }

    public static function delete($validasi_transaksi_id)
    {
        $delete = ValidasiTransaksi::where('kode_transaksi', $validasi_transaksi_id)->delete();
        return $delete;
    }
}
