<?php

require '../config.php';
if (!isset($_POST['request'])) {
    echo "<h3>403 Forbidden</h3>";
    exit();
}
header("Content-type:application/json");
$req = $_POST['request'];
// $req = "ambilObat";
// $_POST['idObat'] = 5;
switch ($req) {
    case "ambilObat":
        $data = array();
        $data[0] = false;
        $data[1] = getData("SELECT * FROM obat WHERE obat_id = '$_POST[idObat]'")[0];
        $srt = getData("SELECT * FROM pembelian WHERE pembelian_obat_id = '$_POST[idObat]' ORDER BY pembelian_dibuat DESC");
        if (isset($srt[0])) {
            $data[0] = true;
            $data[2] = $srt[0];
        }
        echo json_encode($data);

        break;
}
