<?php

namespace App\Modules\ApproveTransaksi\Models;

use App\Models\User;
use App\Modules\TransaksiBarang\Models\TransaksiBarangChildren;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengiriman extends Model
{
    use SoftDeletes;
    protected $table = 'pengiriman';
    protected $guarded = [];
    protected $appends = ['status_readable'];

    public function barangchildren(){
        return $this->belongsTo(TransaksiBarangChildren::class,"transaksi_id","id");
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
