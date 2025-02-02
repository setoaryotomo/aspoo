<?php

namespace App\Modules\Portal\Model;

use App\Models\User;
use App\Modules\TransaksiBarang\Models\TransaksiBarang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;

class Rekening extends Model
{
    use SoftDeletes;
    protected $table = 'rekening';
    protected $fillable = ['kode_rekening', 'pemilik_rekening', 'status'];
    protected $guarded = [];
}