<?php

namespace App\Modules\Komposisi\Models;

use App\Modules\Satuan\Models\Satuan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Komposisi extends Model
{
    use SoftDeletes;
    protected $table = 'komposisi';
    protected $guarded = [];

    public function satuan(){
        return $this->belongsTo(Satuan::class,"satuan_id");
    }
}