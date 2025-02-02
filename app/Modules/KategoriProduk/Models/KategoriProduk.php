<?php

namespace App\Modules\KategoriProduk\Models;
    
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KategoriProduk extends Model
{
    use SoftDeletes;
    protected $table = 'kategori_produk';
    protected $guarded = [];
}