<?php

namespace App\Modules\permintaanparcel\Models;

use App\Models\ParcelChildren;
use App\Models\User;
use App\Modules\TransaksiBarang\Models\TransaksiBarang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class permintaanparcel extends Model
{
    use SoftDeletes;
    protected $table = 'parcel';
    protected $fillable = ['user_id','harga','berat','alamat','barang','tanggal','review_komposisi','review_pelayanan']; //review_komposisi isinya 1-5
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function parcel_children(){
        return $this->hasMany(ParcelChildren::class,"parcel_id");
    }
    public function transaksi()
{
    return $this->hasOne(TransaksiBarang::class, 'parcel_id');
}
}