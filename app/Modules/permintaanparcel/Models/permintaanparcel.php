<?php

namespace App\Modules\permintaanparcel\Models;

use App\Models\ParcelChildren;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class permintaanparcel extends Model
{
    use SoftDeletes;
    protected $table = 'parcel';
    protected $fillable = ['user_id','harga','berat','alamat','barang', 'tanggal'];
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function parcel_children(){
        return $this->hasMany(ParcelChildren::class,"parcel_id");
    }
}