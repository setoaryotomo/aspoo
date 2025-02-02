<?php

namespace App\Modules\InputSCM\Models;
    
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;
    protected $primaryKey = "id_supplier";
    protected $table = 'scm_supplier';
    protected $guarded = [];
    protected $appends = ['id'];
    public function getIdAttribute(){
        return $this->id_supplier;
    }
}
