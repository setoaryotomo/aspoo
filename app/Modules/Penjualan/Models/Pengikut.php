<?php

namespace App\Modules\Penjualan\Models;

use App\Modules\PortalUser\Models\TokoUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Pengikut extends Model
{
    protected $table = 'pengikut';
    protected $guarded = [];

    public function a(){
        $toko = TokoUser::where('id',1)->first();
        Pengikut::create([
            'user_id' => Auth::user()->id,
            'toko_id' => $toko->id
        ]);

        $toko->pengikut = intval($toko->pengikut + 1);
        $toko->save();
    }
}