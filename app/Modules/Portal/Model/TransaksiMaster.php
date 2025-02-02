<?php

namespace App\Modules\Portal\Model;

use App\Models\User;
use App\Modules\TransaksiBarang\Models\TransaksiBarang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;

class TransaksiMaster extends Model
{
    use SoftDeletes;
    protected $table = 'transaksi_master';
    protected $guarded = [];
    
    public function transaksi(){
        return $this->hasMany(TransaksiBarang::class,"kode_transaksi_master","kode_transaksi");
    }
}