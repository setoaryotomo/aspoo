<?php

namespace App\Modules\ApproveTransaksi\Repositories;

use App\Modules\ApproveTransaksi\Models\ApproveTransaksi;

class ApproveTransaksiRepository
{
    public static function datatable($per_page = 15)
    {
        $data = ApproveTransaksi::whereNull('status')->with("pembeli")->paginate($per_page);
        return $data;
    }
    public static function get($approve_transaksi_id)
    {
        $approve_transaksi = ApproveTransaksi::where('id', $approve_transaksi_id)->first();
        return $approve_transaksi;
    }
    public static function create($approve_transaksi)
    {
        $approve_transaksi = ApproveTransaksi::create($approve_transaksi);
        return $approve_transaksi;
    }

    public static function update($approve_transaksi_id, $approve_transaksi)
    {
        ApproveTransaksi::where('id', $approve_transaksi_id)->update($approve_transaksi);
        $approve_transaksi = ApproveTransaksi::where('id', $approve_transaksi_id)->first();
        return $approve_transaksi;
    }

    public static function delete($approve_transaksi_id)
    {
        $delete = ApproveTransaksi::where('id', $approve_transaksi_id)->delete();
        return $delete;
    }
}
