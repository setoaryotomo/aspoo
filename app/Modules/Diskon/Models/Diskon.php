<?php

namespace App\Modules\Diskon\Models;
    
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diskon extends Model
{
   protected $primaryKey = "id";
    protected $table = 'diskon';
    protected $fillable = ['jumlah_diskon','kode_diskon'];

}