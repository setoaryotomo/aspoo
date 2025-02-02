<?php

namespace App\Modules\Pembelian\Repositories;

use App\Modules\Pembelian\Models\Pembelian;
use App\Modules\TransaksiBarang\Models\TransaksiBarang;

class WatZapRepository
{
    public static function formatMessage(TransaksiBarang $data){
        $pesan = "Transaksi Anda ".$data->kode_transaksi."\n";
        $i = 1;
        foreach($data->dataChildren as $child){
            $barang = $child->barang;
            $pesan .= $i++.". ".$barang->nama_barang." x".$child->jumlah."\n";
        }
        return $pesan;
    }
    public static function sendTextMessage($phone,$message){
        
        $dataSending = Array();
        $dataSending["api_key"] = env("WATZAP_API_KEY");
        $dataSending["number_key"] = env("WATZAP_NUMBER_KEY");
        $dataSending["phone_no"] = $phone;
        $dataSending["message"] = $message;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.watzap.id/v1/send_message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($dataSending),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
    }
}
