<?php

namespace App\Modules\Slider\Models;
    
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use SoftDeletes;
    protected $table = 'slider';
    protected $guarded = [];
    protected $appends = ['url_foto'];
    public function getUrlFotoAttribute(){
        return url("storage/".$this->foto);
    }
}