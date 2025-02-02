<?php

namespace App\Modules\Komposisi\Repositories;

use App\Modules\Komposisi\Models\Komposisi;

class KomposisiRepository
{
    public static function datatable($per_page = 15)
    {
        $data = Komposisi::paginate($per_page);
        return $data;
    }
    public static function get($komposisi_id)
    {
        $komposisi = Komposisi::where('id', $komposisi_id)->first();
        return $komposisi;
    }
    public static function create($komposisi)
    {
        $komposisi = Komposisi::create($komposisi);
        return $komposisi;
    }

    public static function update($komposisi_id, $komposisi)
    {
        Komposisi::where('id', $komposisi_id)->update($komposisi);
        $komposisi = Komposisi::where('id', $komposisi_id)->first();
        return $komposisi;
    }

    public static function delete($komposisi_id)
    {
        $delete = Komposisi::where('id', $komposisi_id)->delete();
        return $delete;
    }
}
