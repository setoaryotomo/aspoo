<?php

namespace App\Modules\MasterUMKM\Models;

use App\Models\User;
use App\Modules\Portal\Model\UserDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterUMKM extends Model
{
    use SoftDeletes;
    protected $table = 'users_toko';
    protected $guarded = [];

    public function detail(){
        return $this->hasOne(UserDetail::class,"user_id","user_id");
    }
    
    

    public function getFotoReadableAttribute(){
        if($this->foto == null){
            return url("/img/portal/produk.png");
        }else{
            return url($this->foto);
        }
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}