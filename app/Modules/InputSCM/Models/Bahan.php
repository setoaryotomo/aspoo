<?php

namespace App\Modules\InputSCM\Models;
    
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bahan extends Model
{
    use SoftDeletes;
    protected $table = 'scm_bahan_baku';
    protected $primaryKey = "id_bahan_baku";
    protected $guarded = [];

    protected $appends = ['id'];
    public function getIdAttribute(){
        return $this->id_bahan_baku;
    }
    public function supplier(){
        return $this->hasMany(Supplier::class,"id_bahan_baku");
    }
}
