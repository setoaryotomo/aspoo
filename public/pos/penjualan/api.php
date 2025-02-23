<?php

require '../config.php';
if (isset($_GET['delete'])) {
    $del = $_GET['delete'];
    query("DELETE FROM penjualan_child WHERE penjualan_child_id = '$del'");
    return header("Location: " . $url . "/laporan");
}
if (!isset($_POST['request'])) exit();
header("Content-type:application/json");
$req = $_POST['request'];

switch ($req) {
    case "dataObat":
        $id = $_POST['id'];
        $query = $conn->query("SELECT barang.id, barang.nama_barang, barang.harga_umum, barang.stock_global, satuan.satuan_nama 
                               FROM barang 
                               INNER JOIN satuan ON barang.satuan_id = satuan.id 
                               WHERE barang.id = '$id'");
        echo json_encode($query->fetch_assoc());
        break;
    case  "kirimData":
        $waw = json_decode($_POST['allData'], true);
        extract($waw);
        extract($penjualan);
        $q = $conn->query("INSERT INTO penjualan(penjualan_total_harga,penjualan_pelanggan_id,penjualan_bayar,penjualan_kembali) VALUES($total,$id_pelanggan,$bayar,$kembali)");
        handleError($q);

        $id_penjualan = $conn->insert_id;
        // $id_penjualan = 5;

        foreach ($obat as $arr) {
            if ($arr['convertSatuan'] == true) {
                $stmt = $conn->prepare("INSERT INTO penjualan_child(penjualan_parent_id,penjualan_child_obat_id,penjualan_child_jumlah,penjualan_child_subtotal,penjualan_child_satuan_rubah_id,penjualan_child_satuan_rubah_jumlah) VALUES (?,?,?,?,?,?)");

                $stmt->bind_param("ssssss", $id_penjualan, $arr['id'], $arr['jumlah_data'], $arr['subtotal'], $arr['dc_satuan_id'], $arr['dc_jumlah']);
            } else {
                $stmt = $conn->prepare("INSERT INTO penjualan_child(penjualan_parent_id,penjualan_child_obat_id,penjualan_child_jumlah,penjualan_child_subtotal) VALUES (?,?,?,?)");

                $stmt->bind_param("ssss", $id_penjualan, $arr['id'], $arr['jumlah_data'], $arr['subtotal']);
            }
            handleError($stmt->execute());
        }
        return header("Location: " . $url . "/penjualan");
        break;
    case "editData":
        $waw = json_decode($_POST['allData'], true);
        $irs = $waw['id_penjualan'];
        extract($waw);
        extract($penjualan);
        query("UPDATE penjualan SET penjualan_total_harga='$total',penjualan_pelanggan_id='$id_pelanggan',penjualan_bayar='$bayar',penjualan_kembali='$kembali' WHERE penjualan_id='$irs'");

        $id_penjualan = $waw['id_penjualan'];
        foreach ($obat as $arr) {
            if (!isset($arr['penjualan_child_id'])) {
                $stmt = $conn->prepare("INSERT INTO penjualan_child(penjualan_parent_id,penjualan_child_obat_id,penjualan_child_jumlah,penjualan_child_subtotal) VALUES (?,?,?,?)");
                $stmt->bind_param("ssss", $id_penjualan, $arr['id'], $arr['jumlah_data'], $arr['subtotal']);
            } else {
                $stmt = $conn->prepare("UPDATE penjualan_child SET penjualan_child_obat_id=?,penjualan_child_jumlah=?,penjualan_child_subtotal=? WHERE penjualan_parent_id=?");
                $stmt->bind_param("ssss", $arr['id'], $arr['jumlah_data'], $arr['subtotal'], $id_penjualan);
            }
            handleError($stmt->execute());
        }
        if (isset($dataHapus[0])) {
            foreach ($dataHapus as $data) {
                $irt = $data['penjualan_child_id'];
                query("DELETE FROM penjualan_child WHERE penjualan_child_id='$irt'");
            }
        }

        return header("Location: " . $url . "/penjualan");
        break;
    case "getDataEdit":
        $idPenjualan = $_POST['id'];
        $dataPenjualan = getData("SELECT * FROM penjualan_child a INNER JOIN obat b ON a.`penjualan_child_obat_id`=b.`id` INNER JOIN satuan c  ON b.`obat_satuan_id`=c.`satuan_id` WHERE penjualan_parent_id='$idPenjualan'");

        echo json_encode($dataPenjualan);
        break;
    case "getSatuan":
        $id = $_POST['id'];
        $data = getData("SELECT * FROM satuan WHERE satuan_id != '$id'");
        echo json_encode($data);
        break;
}
