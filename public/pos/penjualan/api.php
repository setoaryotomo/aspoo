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
    case "kirimData":
        $waw = json_decode($_POST['allData'], true);
        extract($waw);
        extract($penjualan);

        // Ambil user_id dari session
        $user_id = $_SESSION['data']['id'];

        // Simpan data penjualan dengan user_id
        $q = $conn->query("INSERT INTO penjualan(penjualan_total_harga, penjualan_pelanggan_id, penjualan_bayar, penjualan_kembali, user_id) 
                           VALUES ($total, $id_pelanggan, $bayar, $kembali, $user_id)");
        handleError($q);

        $id_penjualan = $conn->insert_id;

        foreach ($obat as $arr) {
            if ($arr['convertSatuan'] == true) {
                $stmt = $conn->prepare("INSERT INTO penjualan_child(penjualan_parent_id, penjualan_child_obat_id, penjualan_child_jumlah, penjualan_child_subtotal, penjualan_child_satuan_rubah_id, penjualan_child_satuan_rubah_jumlah) VALUES (?,?,?,?,?,?)");
                $stmt->bind_param("ssssss", $id_penjualan, $arr['id'], $arr['jumlah_data'], $arr['subtotal'], $arr['dc_satuan_id'], $arr['dc_jumlah']);
            } else {
                $stmt = $conn->prepare("INSERT INTO penjualan_child(penjualan_parent_id, penjualan_child_obat_id, penjualan_child_jumlah, penjualan_child_subtotal) VALUES (?,?,?,?)");
                $stmt->bind_param("ssss", $id_penjualan, $arr['id'], $arr['jumlah_data'], $arr['subtotal']);
            }
            handleError($stmt->execute());

            // Kurangi stok barang
            kurangiStok($conn, $arr['id'], $arr['jumlah_data'], $user_id);
        }
        return header("Location: " . $url . "penjualan");
        break;
    // Kasus lainnya tetap sama
}

function kurangiStok($conn, $id_barang, $jumlah, $user_id) {
    // Pastikan barang tersebut dibuat oleh user yang sama
    $query = $conn->query("SELECT stock_global FROM barang WHERE id = '$id_barang' AND created_by_user_id = '$user_id'");
    if ($query->num_rows == 0) {
        throw new Exception("Anda tidak memiliki izin untuk mengurangi stok barang ini.");
    }

    // Kurangi stok
    $stok_sekarang = $query->fetch_assoc()['stock_global'];
    $stok_baru = $stok_sekarang - $jumlah;

    if ($stok_baru < 0) {
        throw new Exception("Stok barang tidak mencukupi.");
    }

    $conn->query("UPDATE barang SET stock_global = $stok_baru WHERE id = '$id_barang'");
}