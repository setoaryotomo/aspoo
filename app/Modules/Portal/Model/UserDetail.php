<?php

namespace App\Modules\Portal\Model;

use App\Models\User;
use App\Modules\InputSCM\Models\Alamat\Kecamatan;
use App\Modules\InputSCM\Models\Alamat\Kelurahan;
use App\Modules\InputSCM\Models\Alamat\Kota;
use App\Modules\InputSCM\Models\Alamat\Provinsi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;

class UserDetail extends Model
{
    protected $table = 'user_details';
    protected $guarded = [];
    protected $appends = ['foto_readable'];

    public function getFotoReadableAttribute(){
        if($this->foto == null){
            return URL::asset('/img/portal/user-icon.png');
        }else{
            return url("storage/".$this->foto);

        }
    }
    public function userDetails()
    {
        return $this->hasOne(UserDetail::class, 'user_id');
    }
    public function userMaster(){
        return $this->belongsTo(User::class,"user_id");
    }
    public function provinsiModel(){
        return $this->hasOne(Provinsi::class, 'id','provinsi');
    }
    public function kotaModel(){
        return $this->hasOne(Kota::class, 'id','kota');
    }
    public function kecamatanModel(){
        return $this->hasOne(Kecamatan::class, 'id','kecamatan');
    }
    public function kelurahanModel(){
        return $this->hasOne(Kelurahan::class, 'id','kelurahan');
    }
}