<?php

namespace App\Modules\DataBarang\Models;

use App\Models\ParcelChildren;
use App\Models\User;
use App\Modules\Keranjang\Models\Keranjang;
use App\Modules\Komposisi\Models\Komposisi;
use App\Modules\PortalUser\Models\TokoUser;
use App\Modules\Satuan\Models\Satuan;
use App\Modules\User\Model\UserRoleModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isNull;

class DataBarang extends Model
{
    use SoftDeletes;
    protected $table = 'barang';
    protected $guarded = [];
    protected $fillable = ['nama_barang','kategori_umum','kategori_nama','kategori_produk','bahan_dasar','kekhasan','basah_kering','rasa','jenis_kemasan','komposisi','harga_supplier','harga_umum','diskon','berat','keterangan','info_penting','stock_global','created_by_user_id','satuan_id','thumbnail','expired','dimensi','scm_barang_id','panjang','lebar','tinggi'];
    protected $appends = ['harga_user','harga_user_asli','thumbnail_readable'];

    // public function getThumbnailReadableAttribute(){
    //     // if(Storage::exists($this->thumbnail)){
    //         return url($this->thumbnail);
    //     // }else{
    //     //     return url("/img/portal/produk.png");

    //     // }
    //     // if($this->thumbnail == null){
    //     //     return url("/img/portal/produk.png");
    //     // }else{
    //     //     return url("storage/".$this->thumbnail);
    //     // }
    // }

    public function getThumbnailReadableAttribute(){
        // Jika thumbnail sudah dalam format URL lengkap
       
        
        // Jika thumbnail adalah link Google Drive
        if (strpos($this->thumbnail, 'https://drive.google.com/') === 0) {
            // Ekstrak ID dari URL Google Drive
            $pattern = '/\/d\/([^\/]+)/';
            preg_match($pattern, $this->thumbnail, $matches);
            
            if (isset($matches[1])) {
                $fileId = $matches[1];
                // return "https://drive.google.com/thumbnail?id=" . $fileId . "&sz=w1000";
                // w500 (lebar 500px) dengan aspek ratio 1:1 (persegi)
            return "https://drive.google.com/thumbnail?id=" . $fileId . "&sz=w500&v=1";
            }
            
            return $this->thumbnail;
        }
        
        // Default: ambil dari storage lokal
        return url("storage/" . $this->thumbnail);
    }
    

    public function getHargaUserAsliAttribute(){
        $user = Auth::user();
        if($user){
            $role = UserRoleModel::where('user_id',$user->id)->first();
            // if($role == "2"){
            if($role == "3"){
                return $this->harga_umum;
            } else{
                return $this->harga_umum;
            }
        }else{
            return $this->harga_umum;
        }
    }

    public function keranjang(){
        return $this->hasMany(Keranjang::class,"barang_id");
    }

    public function getHargaUserAttribute(){
        return $this->harga_user_asli - ($this->harga_user_asli *($this->diskon /100));
    }
    public function satuan(){
        return $this->hasOne(Satuan::class,"id","satuan_id");
    }
    public function user(){
        return $this->hasOne(TokoUser::class,"user_id","created_by_user_id");
    }
    public function foto(){
        return $this->hasMany(DataBarangFoto::class,"barang_id",'id');
    }
    public function komposisi(){
        return $this->belongsToMany(Komposisi::class,'barang_komposisi','id_barang','id_komposisi')->withPivot('jumlah');
    }
    public static function getHargaBarang($user, $barang){
        $role = UserRoleModel::where('user_id',$user->id)->first();
        if($role == "2"){
            return $barang->harga_umum;
        } else{
            return $barang->harga_supplier;
        }
    }
    public function parcel_children(){
        return $this->hasMany(ParcelChildren::class,"barang_id");
    }

    
}