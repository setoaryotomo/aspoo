<?php

namespace App\Modules\ApproveTransaksi\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApproveTransaksi extends Model
{
    use SoftDeletes;
    protected $table = 'transaksi';
    protected $guarded = [];
    protected $appends = ['total_biaya_readable'];

    public function getTotalBiayaReadableAttribute(){
        $rupiah = "Rp. " . number_format(($this->total_biaya + $this->biaya_pengiriman), 0, ',', '.');
        return $rupiah;
    }


    public function pembeli(){
        return $this->hasOne(User::class,"id","user_id");
    }
}