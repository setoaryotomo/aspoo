<?php

namespace App\Modules\KategoriProduk\Repositories;

use App\Modules\KategoriProduk\Models\KategoriProduk;

class KategoriProdukRepository
{
    public static function datatable($per_page = 15)
    {
        $data = KategoriProduk::paginate($per_page);
        return $data;
    }
    public static function get($kategoriproduk_id)
    {
        $kategoriproduk = KategoriProduk::where('id', $kategoriproduk_id)->first();
        return $kategoriproduk;
    }
    public static function create($kategoriproduk)
    {
        $kategoriproduk = KategoriProduk::create($kategoriproduk);
        return $kategoriproduk;
    }

    public static function update($kategoriproduk_id, $kategoriproduk)
    {
        KategoriProduk::where('id', $kategoriproduk_id)->update($kategoriproduk);
        $kategoriproduk = KategoriProduk::where('id', $kategoriproduk_id)->first();
        return $kategoriproduk;
    }

    public static function delete($kategoriproduk_id)
    {
        $delete = KategoriProduk::where('id', $kategoriproduk_id)->delete();
        return $delete;
    }
}
