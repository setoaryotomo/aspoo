<?php

namespace App\Modules\Komposisi\Models;

use App\Modules\Satuan\Models\Satuan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PivotKomposisiSupplier extends Model
{
    protected $table = 'pivot_komposisi_supplier';
    protected $guarded = [];

    public function supplier(){
        return $this->belongsTo(KomposisiSupplier::class,"id_supplier");
    }

  
}