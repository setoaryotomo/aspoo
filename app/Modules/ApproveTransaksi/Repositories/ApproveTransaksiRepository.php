<?php

namespace App\Modules\ApproveTransaksi\Repositories;

use App\Modules\ApproveTransaksi\Models\ApproveTransaksi;

class ApproveTransaksiRepository
{
    public static function datatable($per_page = 15, $keyword = '')
    {
        $query = ApproveTransaksi::whereNull('status')->with(['pembeli', 'penjual']);

        // Apply keyword search if provided
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('kode_transaksi_master', 'LIKE', "%{$keyword}%")
                ->orWhere('kode_transaksi','LIKE', "%{$keyword}%")
                  ->orWhereHas('pembeli', function ($pembeliQuery) use ($keyword) {
                      $pembeliQuery->where('name', 'LIKE', "%{$keyword}%");
                  })
                  ->orWhereHas('penjual', function ($penjualQuery) use ($keyword) {
                      $penjualQuery->where('name', 'LIKE', "%{$keyword}%");
                  });
            });
        }

        $data = $query->paginate($per_page);
        return $data;
    }

    public static function datatableByToko($per_page = 15, $tokoIds, $keyword = '')
    {
        $query = ApproveTransaksi::whereIn('toko_id', $tokoIds)
            ->whereNull('status')
            ->with(['pembeli', 'penjual']);

        // Apply keyword search if provided
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('kode_transaksi_master', 'LIKE', "%{$keyword}%")
                  ->orWhere('kode_transaksi','LIKE', "%{$keyword}%")
                  ->orWhereHas('pembeli', function ($pembeliQuery) use ($keyword) {
                      $pembeliQuery->where('name', 'LIKE', "%{$keyword}%");
                  })
                  ->orWhereHas('penjual', function ($penjualQuery) use ($keyword) {
                      $penjualQuery->where('name', 'LIKE', "%{$keyword}%");
                  });
            });
        }

        $data = $query->paginate($per_page);
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