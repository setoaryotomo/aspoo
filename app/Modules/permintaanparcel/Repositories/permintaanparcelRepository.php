<?php

namespace App\Modules\permintaanparcel\Repositories;

use App\Modules\permintaanparcel\Models\permintaanparcel;

class permintaanparcelRepository
{
    public static function datatable($per_page = 15, $keyword = '')
    {
        $query = permintaanparcel::with('user');

        // Apply keyword search if provided
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('tanggal', 'LIKE', "%{$keyword}%")
                  ->orWhereHas('user', function ($userQuery) use ($keyword) {
                      $userQuery->where('name', 'LIKE', "%{$keyword}%");
                  });
            });
        }

        $data = $query->paginate($per_page);
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
