<?php

namespace App\Modules\Keranjang\Models;

use App\Modules\DataBarang\Models\DataBarang;
use App\Modules\permintaanparcel\Models\permintaanparcel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Keranjang extends Model
{
    protected $table = 'keranjang';
    protected $guarded = [];
    protected $appends = ['jumlah_harga'];
    public function barang(){
        return $this->belongsTo(DataBarang::class,'barang_id');
    }
    public function parcel()
    {
        return $this->belongsTo(permintaanparcel::class, 'parcel_id', 'id');
    }
    public function getJumlahHargaAttribute(){
        return [
            'harga_supplier' => intval($this->barang->harga_supplier) * $this->jumlah,
            'harga_umum' => intval($this->barang->harga_umum) * $this->jumlah,
        ];
    }
}