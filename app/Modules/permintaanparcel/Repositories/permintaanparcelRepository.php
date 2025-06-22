<?php

namespace App\Modules\permintaanparcel\Repositories;

use App\Modules\permintaanparcel\Models\permintaanparcel;

class permintaanparcelRepository
{
    public static function datatable($per_page = 15, $keyword = '')
{
    $query = permintaanparcel::with('user', 'transaksi');

    // Apply keyword search if provided
    if (!empty($keyword)) {
        $query->where(function ($q) use ($keyword) {
            $q->where('tanggal', 'LIKE', "%{$keyword}%")
              ->orWhereHas('user', function ($userQuery) use ($keyword) {
                  $userQuery->where('name', 'LIKE', "%{$keyword}%");
              })
              ->orWhereHas('transaksi', function ($transaksiQuery) use ($keyword) {
                  // Mapping status teks ke nilai numerik
                  $statusMapping = [
                      'disetujui' => 1,
                      'uang telah diterima' => 2,
                      'dikirim' => 3,
                      'diterima' => 4
                  ];
                  
                  // Cek apakah keyword ada di mapping
                  $lowerKeyword = strtolower(trim($keyword));
                  if (array_key_exists($lowerKeyword, $statusMapping)) {
                      $transaksiQuery->where('status', $statusMapping[$lowerKeyword]);
                  } else {
                      // Jika tidak ada di mapping, coba cari sebagai angka
                      if (is_numeric($keyword)) {
                          $transaksiQuery->where('status', $keyword);
                      }
                  }
              });
        });
    }

    $data = $query->orderByDesc('created_at')->paginate($per_page);
    return $data;
}
    public static function get($permintaan_parcel_id)
    {
        $permintaan_parcel = permintaanparcel::where('id', $permintaan_parcel_id)->first();
        return $permintaan_parcel;
    }
    public static function create($permintaan_parcel)
    {
        $permintaan_parcel = permintaanparcel::create($permintaan_parcel);
        return $permintaan_parcel;
    }

    public static function update($permintaan_parcel_id, $permintaan_parcel)
    {
        permintaanparcel::where('id', $permintaan_parcel_id)->update($permintaan_parcel);
        $permintaan_parcel = permintaanparcel::where('id', $permintaan_parcel_id)->first();
        return $permintaan_parcel;
    }

    public static function delete($permintaan_parcel_id)
    {
        $delete = permintaanparcel::where('id', $permintaan_parcel_id)->delete();
        return $delete;
    }
}
