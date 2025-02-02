<?php
header("Content-type:application/json");
require '../config.php';

if (!isset($_POST['request'])) exit();
$req = $_POST['request'];


// $_POST['hari'] = "2020-07-05";
// $req = "ambilData";

switch ($req) {
    case "ambilData":
        $return = array();
        $realHari = $_POST['hari'];
        $hari = new DateTime($_POST['hari']);
        $hari1 = $hari->format("Y-m-d H:i:s");
        $hari->modify('+1 day');
        $hari2 = $hari->format("Y-m-d H:i:s");

        // Cari Penjualan
        $return['penjualan'] = getData("SELECT * FROM penjualan_child INNER JOIN obat ON penjualan_child.`penjualan_child_obat_id` = obat.`obat_id` WHERE penjualan_child_dibuat   BETWEEN '$hari1' AND '$hari2'  ORDER BY obat.`obat_id`");
        $arr = [];
        if (isset($return['penjualan'][0])) {
            $s = $return['penjualan'];
            for ($i = 0; $i < count($s); $i++) {
                $rt = $i + 1;
                if (isset($s[$rt])) {
                    if ($s[$i]['obat_id'] == $s[$rt]['obat_id']) {
                        $s[$rt]['penjualan_child_jumlah'] = intval($s[$i]['penjualan_child_jumlah']) + intval($s[$rt]['penjualan_child_jumlah']);
                        array_push($arr, $i);
                    }
                }
            }
        }
        for ($i = 0; $i < count($arr); $i++) {
            unset($s[$arr[$i]]);
        }

        // Cari Pembelian
        $str  = getData("SELECT * FROM pembelian_faktur INNER JOIN supplier ON supplier.supplier_id = pembelian_faktur.nama_supplier WHERE tanggal_faktur = CAST('$realHari' AS DATE)");
        if (isset($str[0])) {
            for ($i = 0; $i < sizeof($str); $i++) {
                $str[$i]['jumlahData']  = getData("SELECT SUM(pembelian_jumlah) AS jumlah FROM pembelian WHERE pembelian_nomor_faktur = '" . $str[$i]['pembelian_faktur_id'] . "'")[0]['jumlah'];
            }
        }
        $return['penjualan'] =  array_values($s);
        $return['pembelian'] = $str;
        $return['uang_masuk'] = $conn->query("SELECT SUM(CAST(penjualan_total_harga AS UNSIGNED)) AS uang_masuk FROM penjualan WHERE penjualan_dibuat BETWEEN '$hari1' AND '$hari2' ")->fetch_assoc();
        $return['uang_keluar'] = $conn->query("SELECT SUM(CAST(pembelian_harga_beli AS UNSIGNED) * CAST(pembelian_jumlah AS UNSIGNED)) AS uang_keluar FROM pembelian WHERE pembelian_lunas='Lunas' AND pembelian_tanggal_faktur = CAST('$realHari' AS DATE)")->fetch_assoc();
        $return['uang_piutang'] = $conn->query("SELECT SUM(CAST(pembelian_harga_beli AS UNSIGNED) * CAST(pembelian_jumlah AS UNSIGNED)) AS uang_keluar FROM pembelian WHERE pembelian_lunas='Belum Lunas' AND pembelian_tanggal_faktur = CAST('$realHari' AS DATE)")->fetch_assoc();


        echo json_encode($return);
        break;
}
