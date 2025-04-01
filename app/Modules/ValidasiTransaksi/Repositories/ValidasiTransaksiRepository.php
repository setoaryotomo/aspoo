<?php

namespace App\Modules\ValidasiTransaksi\Repositories;

use App\Modules\Portal\Model\TransaksiMaster;
use App\Modules\ValidasiTransaksi\Models\ValidasiTransaksi;

class ValidasiTransaksiRepository
{
    public static function datatable($per_page = 15)
    {
        // Ambil semua TransaksiMaster yang memiliki transaksi
        $data = TransaksiMaster::with(['transaksi'])
            // Pastikan minimal ada 1 transaksi dengan status = 1
            ->whereHas('transaksi', function ($query) {
                $query->where('status', 1);
            })
            // Pastikan tidak ada transaksi dengan status != 1
            ->whereDoesntHave('transaksi', function ($query) {
                $query->where('status', '!=', 1);
            })
            // Pastikan semua transaksi (count) sama dengan transaksi yang status = 1
            ->has('transaksi', '=', function ($subQuery) {
                $subQuery->selectRaw('COUNT(*)')
                    ->from('transaksi')
                    ->whereColumn('transaksi.kode_transaksi_master', 'transaksi_master.kode_transaksi')
                    ->where('transaksi.status', 1);
            })
            ->paginate($per_page);

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
