<?php

namespace App\Modules\Diskon\Repositories;

use App\Modules\Diskon\Models\Diskon;

class DiskonRepository
{
    public static function datatable($per_page = 15)
    {
        $data = Diskon::paginate($per_page);
        return $data;
    }
    public static function get($diskon_id)
    {
        $diskon = Diskon::where('id', $diskon_id)->first();
        return $diskon;
    }
    public static function create($diskon)
    {
        $diskon = Diskon::create($diskon);
        return $diskon;
    }

    public static function update($diskon_id, $diskon)
    {
        Diskon::where('id', $diskon_id)->update($diskon);
        $diskon = Diskon::where('id', $diskon_id)->first();
        return $diskon;
    }

    public static function delete($diskon_id)
    {
        $delete = Diskon::where('id', $diskon_id)->delete();
        return $delete;
    }
}
