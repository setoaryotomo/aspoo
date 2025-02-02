<?php

namespace App\Modules\KategoriProduk\Models;

use App\Modules\DataBarang\Models\DataBarang;
use Illuminate\Database\Eloquent\Model;

class PivotKategoriProduk extends Model
{
    protected $table = 'pivot_kategori_produk';
    protected $guarded = [];

    public function barang(){
        return $this->belongsTo(DataBarang::class,"barang_id");
    }
    public function kategoriproduk(){
        return $this->belongsTo(KategoriProduk::class,"kategori_produk_id");
    }
}