<?php

namespace App\Modules\Presensi\Repositories;

use App\Modules\Presensi\Models\Presensi;

class PresensiRepository
{
    public static function datatable($per_page = 15)
    {
        $data = Presensi::paginate($per_page);
        return $data;
    }
    public static function get($presensi_id)
    {
        $presensi = Presensi::where('id', $presensi_id)->first();
        return $presensi;
    }
    public static function create($presensi)
    {
        $presensi = Presensi::create($presensi);
        return $presensi;
    }

    public static function update($presensi_id, $presensi)
    {
        Presensi::where('id', $presensi_id)->update($presensi);
        $presensi = Presensi::where('id', $presensi_id)->first();
        return $presensi;
    }

    public static function delete($presensi_id)
    {
        $delete = Presensi::where('id', $presensi_id)->delete();
        return $delete;
    }
}
