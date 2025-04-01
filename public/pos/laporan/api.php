<?php
header("Content-type:application/json");
require '../config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_POST['request'])) {
    echo json_encode(['error' => 'No request specified']);
    exit();
}

$req = $_POST['request'];

try {
    switch ($req) {
        case "ambilData":
            $return = array();
            $realHari = $_POST['hari'];
            $user_id = $_POST['user_id'];
            $hari = new DateTime($_POST['hari']);
            $hari1 = $hari->format("Y-m-d H:i:s");
            $hari->modify('+1 day');
            $hari2 = $hari->format("Y-m-d H:i:s");

            // Query penjualan
            $query = "
                SELECT penjualan_child.*, barang.nama_barang, barang.harga_umum 
                FROM penjualan_child 
                INNER JOIN penjualan ON penjualan_child.penjualan_parent_id = penjualan.penjualan_id 
                INNER JOIN barang ON penjualan_child.penjualan_child_obat_id = barang.id 
                WHERE penjualan.user_id = '$user_id' 
                AND penjualan.penjualan_dibuat BETWEEN '$hari1' AND '$hari2' 
                ORDER BY barang.id
            ";
            $return['penjualan'] = getData($query);

            // Query pembelian
            $str = getData("SELECT * FROM pembelian_faktur INNER JOIN pos_supplier ON pos_supplier.supplier_id = pembelian_faktur.nama_supplier WHERE tanggal_faktur = CAST('$realHari' AS DATE)");
            if (isset($str[0])) {
                for ($i = 0; $i < sizeof($str); $i++) {
                    $str[$i]['jumlahData'] = getData("SELECT SUM(pembelian_jumlah) AS jumlah FROM pembelian WHERE pembelian_nomor_faktur = '" . $str[$i]['pembelian_faktur_id'] . "'")[0]['jumlah'];
                }
            }
            $return['pembelian'] = $str;

            // Query uang masuk
            $return['uang_masuk'] = $conn->query("SELECT SUM(CAST(penjualan_total_harga AS UNSIGNED)) AS uang_masuk FROM penjualan WHERE penjualan_dibuat BETWEEN '$hari1' AND '$hari2' AND user_id = '$user_id'")->fetch_assoc();

            // Query uang keluar dan piutang
            $return['uang_keluar'] = $conn->query("SELECT SUM(CAST(pembelian_harga_beli AS UNSIGNED) * CAST(pembelian_jumlah AS UNSIGNED)) AS uang_keluar FROM pembelian WHERE pembelian_lunas='Lunas' AND pembelian_tanggal_faktur = CAST('$realHari' AS DATE)")->fetch_assoc();
            $return['uang_piutang'] = $conn->query("SELECT SUM(CAST(pembelian_harga_beli AS UNSIGNED) * CAST(pembelian_jumlah AS UNSIGNED)) AS uang_keluar FROM pembelian WHERE pembelian_lunas='Belum Lunas' AND pembelian_tanggal_faktur = CAST('$realHari' AS DATE)")->fetch_assoc();

            echo json_encode($return);
            break;
        default:
            echo json_encode(['error' => 'Invalid request']);
            break;
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>