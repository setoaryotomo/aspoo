<?php

namespace App\Modules\TransaksiBarang\Models;

use App\Models\User;
use App\Modules\Portal\Model\TransaksiMaster;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransaksiBarang extends Model
{
    use SoftDeletes;
    protected $table = 'transaksi';
    protected $guarded = [];
    
    protected $appends = ['status_readable','total_biaya_readable'];
    public function getTotalBiayaReadableAttribute(){
        $rupiah = "Rp. " . number_format(($this->total_biaya + $this->biaya_pengiriman), 0, ',', '.');
        return $rupiah;
    }
    
    public function dataChildren(){
        return $this->hasMany(TransaksiBarangChildren::class,"transaksi_id");
    }
    public function pembeli(){
        return $this->hasOne(User::class,"id","user_id");
    }
    public function master(){
        return $this->belongsTo(TransaksiMaster::class,'kode_transaksi_master');
    }
    public function penjual(){
        return $this->hasOne(User::class,"id","toko_id");
    }
    
    public function getStatusReadableAttribute(){
        switch($this->status){
            case "":
                return "Menunggu Persetujuan";
                break;
            case 1:
                return " Disetujui Penjual";
                break;
            case 2:
                return "Uang Telah Diterima";
                break;
            case 3:
                return "Dikirim";
                break;
            case 4:
                return "Diterima";
                break;
            case 44:
                return "Barang Gagal Diterima";
                break;
            case 33:
                return "Barang Gagal Dikirim";
                break;
            case 22:
                return "Uang Gagal Diterima";
                break;
            case 44:
                return "Gagal Disetujui Penjual";
                break;
                default:
                    return "Menunggu Persetujuan";
                    break;
            }
        }
    }
            
