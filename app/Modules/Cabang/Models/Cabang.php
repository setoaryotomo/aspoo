<?php
// namespace App\Models;
namespace App\Modules\Cabang\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cabang extends Model
{
    use SoftDeletes;
    protected $table = 'cabang';
    protected $fillable = ['created_by_user_id','alamat'];
    protected $guarded = [];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by_user_id', 'id');
    }
    // public function cabang_children(){
    //     return $this->hasMany(CabangChildren::class,"cabang_id");
    // }


}