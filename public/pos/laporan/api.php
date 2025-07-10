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
            $user_id = (int)$_POST['user_id'];
            $tanggal_input = $_POST['hari'];
            
            // Validasi tanggal
            if (!DateTime::createFromFormat('Y-m-d', $tanggal_input)) {
                echo json_encode(['error' => 'Format tanggal tidak valid']);
                exit();
            }
        
            $tanggal = new DateTime($tanggal_input);
            $startDate = $tanggal->format("Y-m-d 00:00:00");
            $endDate = $tanggal->format("Y-m-d 23:59:59");
        
            // Query penjualan yang sudah diperbaiki
            $query = "
                SELECT 
                    p.penjualan_id,
                    p.penjualan_dibuat,
                    p.penjualan_total_harga,
                    IFNULL(pl.pelanggan_nama, 'Pelanggan Umum') AS pelanggan_nama,
                    GROUP_CONCAT(CONCAT(b.nama_barang, '|', pc.penjualan_child_jumlah, '|', b.harga_umum) SEPARATOR '||') AS items
                FROM penjualan p
                LEFT JOIN penjualan_child pc ON pc.penjualan_parent_id = p.penjualan_id
                LEFT JOIN barang b ON pc.penjualan_child_obat_id = b.id
                LEFT JOIN pelanggan pl ON p.penjualan_pelanggan_id = pl.pelanggan_id
                WHERE p.user_id = ?
                AND p.penjualan_dibuat BETWEEN ? AND ?
                GROUP BY p.penjualan_id
                ORDER BY p.penjualan_dibuat DESC
            ";
            
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iss", $user_id, $startDate, $endDate);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $return['penjualan'] = $result->fetch_all(MYSQLI_ASSOC);
            
            // Hitung total uang masuk
            $sumQuery = $conn->query("
                SELECT COALESCE(SUM(penjualan_total_harga), 0) AS uang_masuk 
                FROM penjualan 
                WHERE user_id = $user_id 
                AND penjualan_dibuat BETWEEN '$startDate' AND '$endDate'
            ");
            $return['uang_masuk'] = $sumQuery->fetch_assoc() ?: ['uang_masuk' => 0];
            
            echo json_encode($return);
            break;
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>