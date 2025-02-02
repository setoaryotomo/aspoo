<?php

namespace App\Models;

use App\Modules\DataBarang\Models\DataBarang;
use App\Modules\permintaanparcel\Models\permintaanparcel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParcelChildren extends Model
{
    use HasFactory;
    protected $table = 'parcel_children';
    protected $fillable = ['parcel_id','barang_id', 'total_harga'];

    public function parcel()
    {
        return $this->belongsTo(permintaanparcel::class, 'parcel_id', 'id');
    }
    public function barang()
    {
        return $this->belongsTo(DataBarang::class, 'barang_id', 'id');
    }
}
