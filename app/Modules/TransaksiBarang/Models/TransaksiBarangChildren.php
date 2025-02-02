<?php

namespace App\Modules\TransaksiBarang\Models;

use App\Modules\DataBarang\Models\DataBarang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransaksiBarangChildren extends Model
{
    use SoftDeletes;
    protected $table = 'transaksi_children';
    protected $guarded = [];
    public function barang(){
        return $this->belongsTo(DataBarang::class,"barang_id");
    }
}