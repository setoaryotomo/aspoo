<?php
require '../config.php';
middleware();
if (isset($_POST['obat'])) {
    extract($_POST);
    $id = $_SESSION['data']['user_id'];
    $ed = $_GET['edit'];
    $edit_query = "UPDATE obat SET ";
    $res = $conn->query("SELECT * FROM pembelian WHERE pembelian_id='$ed'")->fetch_assoc();
    $obast = $res['pembelian_obat_id'];
    $obatku = $conn->query("SELECT * FROM obat WHERE obat_id='$obast'")->fetch_assoc();
    $stok = intval($obatku['obat_stok']) + intval($jumlah) - intval($obatku['obat_stok']);
    $last = $conn->query("SELECT * FROM pembelian ORDER BY pembelian_id DESC LIMIT 1")->fetch_assoc();
    if ($last['pembelian_id'] == $res['pembelian_id']) {
        $edit_query .= "obat_harga_beli='" . $harga_beli . "', ";
        $edit_query .= "obat_harga_jual='" . $harga_jual . "',";
    }
    $edit_query .= "obat_stok = '$stok',obat_user_id='$id' WHERE obat_id ='$obast'";
    query($edit_query);

    // Logic Nomor Faktur
    $check = getData("SELECT * FROM pembelian_faktur WHERE pembelian_faktur_nomor = '$no_faktur'");
    if (!isset($check[0])) {
        $insert = $conn->query("INSERT INTO pembelian_faktur(pembelian_faktur_nomor,nama_supplier,tanggal_faktur) VALUES('$no_faktur','$supplier','$tanggal_faktur')");
        $no_faktur = $conn->insert_id;
    } else {
        $conn->query("UPDATE pembelian_faktur SET nama_supplier = '$supplier', tanggal_faktur = '$tanggal_faktur' WHERE pembelian_faktur_id = '$no_faktur'");
        $no_faktur = $check[0]['pembelian_faktur_id'];
    }

    $stmt = $conn->prepare("UPDATE pembelian SET pembelian_obat_id=?,pembelian_supplier_id=?,pembelian_nomor_faktur=?,pembelian_tanggal_faktur=CAST(? AS DATE),pembelian_jenis=?,pembelian_jumlah=?,pembelian_harga_beli=?,pembelian_harga_jual=?,pembelian_ppn=?,pembelian_diskon=?,pembelian_keuntungan=?,pembelian_user_id=? WHERE pembelian_id = ?");
    $stmt->bind_param("ssssssssssssi", $obat, $supplier, $no_faktur, $tanggal_faktur, $jenis_pembelian, $jumlah, $harga_beli, $harga_jual, $ppn, $diskon, $keuntungan, $id, $ed);
    handleError($stmt->execute());
    refresh();
}
if (isset($_GET['edit'])) {
    $ed = $_GET['edit'];
    $show = $conn->query("SELECT * FROM pembelian WHERE pembelian_id = '$ed'")->fetch_assoc();
    // print_r($show);
    // exit();
    handleError($show);
}
if (isset($_GET['delete'])) {
    $del = $_GET['delete'];
    $res = $conn->query("SELECT * FROM pembelian WHERE pembelian_id='$del'")->fetch_assoc();
    $obast = $res['pembelian_obat_id'];
    $obatku = $conn->query("SELECT * FROM obat WHERE obat_id='$obast'")->fetch_assoc();
    $stok = intval($obatku['obat_stok']) - intval($res['pembelian_jumlah']);
    query("UPDATE obat SET obat_stok = '$stok' WHERE obat_id='$obast'");
    handleError($conn->query("DELETE FROM pembelian WHERE pembelian_id='$del'"));
    refresh();
}
$title = 'Pembelian';
?>
<?php $active[4] = 'active' ?>

<?php include('../templates/sidebar.php') ?>



<div class="main-panel bgMain fadeIn animated">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
            <div class="navbar-wrapper">
                <span class="navbar-brand title-layout">Pembelian</span>
            </div>

            <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                <span class="sr-only">Toggle navigation</span>
                <span class="navbar-toggler-icon icon-bar"></span>
                <span class="navbar-toggler-icon icon-bar"></span>
                <span class="navbar-toggler-icon icon-bar"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <!-- your navbar here -->
                    <li class="ml-auto nav-item">
                        <div class="profil">

                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="content">
        <div class="container">
            <!-- your content here -->

            <div class="card">
                <div class="card-header card-header-primary card-header-bg">
                    <h4 class="card-title">Input Pembelian</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-2 mt-2">
                                    Pilih Supplier
                                </div>
                                <div class="col-10">
                                    <select name="supplier" class="form-control selectpicker" data-style="btn btn-link" id="exampleFormControlSelect1">
                                        <?php $s = $conn->query("SELECT * FROM supplier");
                                        $i = 1;
                                        while ($row = $s->fetch_assoc()) : ?>
                                            <option <?php if (isset($show)) if ($show['pembelian_supplier_id'] == $row['supplier_id']) echo "selected" ?> value="<?= $row['supplier_id'] ?>"><?= $row['supplier_nama'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-2 mt-2">
                                    Nomor Faktur
                                </div>
                                <div class="col-10">
                                    <input type="text" name="no_faktur" value="<?= $show['pembelian_nomor_faktur'] ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-2 mt-2">
                                    Tanggal Faktur
                                </div>
                                <div class="col-10">
                                    <input type="date" class="form-control" name="tanggal_faktur" value="<?= $show['pembelian_tanggal_faktur'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-2 mt-2">
                                    <input type="hidden" id="obat" name="obat" value="<?= $show['pembelian_obat_id'] ?>">
                                    <span class="pilih-obat">Pilih Obat</span>
                                </div>
                                <div class="col-10">
                                    <a class="btn btn-primary ml- btn-sm" data-toggle="modal" data-target="#pilihObat">Pilih Obat</a>
                                    <span id="obat-selected" class="pl-3"><?= queryString("obat", ['obat_id', 'obat_nama'], $show['pembelian_obat_id']) ?></span>
                                </div>
                            </div>
                            <!-- modal -->
                            <div class="modal fade" id="pilihObat" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Pilih Obat</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="table-responsive pt-3">
                                                <table class="table" id="table_id">
                                                    <thead class="text-primary">
                                                        <th>No</th>
                                                        <th>Kode Obat</th>
                                                        <th>Nama Obat</th>
                                                        <th>Satuan Obat</th>
                                                        <th>Option</th>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1;
                                                        $s = $conn->query("SELECT * FROM obat");
                                                        while ($row = $s->fetch_assoc()) : ?>
                                                            <tr>
                                                                <td><?= $i++ ?></td>
                                                                <td><?= $row['obat_kode'] ?></td>
                                                                <td><?= $row['obat_nama'] ?></td>
                                                                <td><?= $conn->query("SELECT * FROM satuan WHERE satuan_id='" . $row['obat_satuan_id'] . "'")->fetch_assoc()['satuan_nama'] ?>
                                                                </td>
                                                                <td>
                                                                    <button data-dismiss="modal" aria-label="Close" onclick="editObat('<?= $row['obat_id'] ?>','<?= $row['obat_nama'] ?>')" class="btn btn-primary" type="button">Pilih</button>
                                                                </td>
                                                            </tr>
                                                        <?php endwhile; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-2 mt-2">
                                    Jenis Pembayaran
                                </div>
                                <div class="col-10">
                                    <select name="jenis_pembelian" class="form-control selectpicker" data-style="btn btn-link" id="exampleFormControlSelect1">
                                        <option <?= ($show['pembelian_jenis'] == 'Cash' ? 'selected' : '') ?>>Cash</option>
                                        <option <?= ($show['pembelian_jenis'] == 'Tempo' ? 'selected' : '') ?>>Tempo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-2 mt-2">
                                    Jumlah Obat
                                </div>
                                <div class="col-10">
                                    <input type="number" id="jumlah" name="jumlah" value="<?php if (isset($show)) echo $show['pembelian_jumlah'] ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-2 mt-2">
                                    Harga Beli
                                </div>
                                <div class="col-10">
                                    <input type="number" id="harga_beli" name="harga_beli" value="<?php if (isset($show)) echo $show['pembelian_harga_beli'] ?>" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-2 mt-2">
                                    PPN
                                </div>
                                <div class="col-10">
                                    <select name="ppn" class="form-control selectpicker" data-style="btn btn-link" id="ppn">
                                        <option value="1" <?php if ($show['pembelian_ppn'] == 1) echo "selected" ?>>PPN</option>
                                        <option value="0" <?php if ($show['pembelian_ppn'] == 0) echo "selected" ?>>Tanpa PPN</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-2 mt-2">
                                    Diskon
                                </div>
                                <div class="col-10">
                                    <input type="number" id="diskon" name="diskon" class="form-control" value="<?= $show['pembelian_diskon'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-2 mt-2">
                                    Keuntungan
                                </div>
                                <div class="col-10">
                                    <input type="number" value="<?= $show['pembelian_keuntungan'] ?>" id="keuntungan" step="0.01" name="keuntungan" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-2 mt-2">
                                    Harga Jual
                                </div>
                                <div class="col-10">
                                    <input type="number" value="<?= $show['pembelian_harga_jual'] ?>" name="harga_jual" id="harga_jual" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary">Buat Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <script>
        function editObat(id, nama) {
            var input = document.querySelector("#obat")
            var ganti = document.querySelector("#obat-selected")
            ganti.innerHTML = nama
            input.value = id
        }
        var hargaBeli = document.querySelector("#harga_beli"),
            hargaJual = document.querySelector("#harga_jual"),
            ppn = document.querySelector("#ppn"),
            diskon = document.querySelector('#diskon'),
            keuntungan = document.querySelector('#keuntungan'),
            jumlah = document.querySelector('#jumlah');

        var valHargaJual = 0,
            valHargaBeli = 0,
            valPpn = 0,
            valDiskon = 0,
            valKeuntungan = 0,
            valJumlah = 0;

        hargaBeli.addEventListener('keyup', rubahHarga)
        hargaJual.addEventListener('keyup', rubahHargaReverse)
        ppn.addEventListener('change', rubahHarga)
        diskon.addEventListener('keyup', rubahHarga)
        keuntungan.addEventListener('keyup', rubahHarga)
        jumlah.addEventListener('keyup', rubahHarga)

        function validateHarga(input) {
            return (input == "") ? 0 : parseFloat(input);
        }
        // Debug
        function clog() {
            console.table({
                'PPN': valPpn,
                'Harga Beli': valHargaBeli,
                'Harga Jual': valHargaJual,
                'Keuntungan': valKeuntungan,
                'Diskon': valDiskon,
            })
        }

        function rubahHarga() {
            valHargaBeli = validateHarga(hargaBeli.value)
            valHargaJual = validateHarga(hargaJual.value)
            valDiskon = validateHarga(diskon.value)
            valKeuntungan = validateHarga(keuntungan.value)

            valPpn = (parseInt(ppn.options[ppn.selectedIndex].value) == 1) ? 10 : 0;

            valDiskon = valHargaBeli * valDiskon / 100
            valPpn = valHargaBeli * valPpn / 100
            valKeuntungan = valHargaBeli * valKeuntungan / 100
            valHargaJual = valHargaBeli - valDiskon + valPpn + valKeuntungan;

            hargaJual.value = parseInt(valHargaJual)

        }

        function rubahHargaReverse() {
            valHargaBeli = validateHarga(hargaBeli.value)
            valHargaJual = validateHarga(hargaJual.value)
            valDiskon = validateHarga(diskon.value)
            valKeuntungan = validateHarga(keuntungan.value)
            valPpn = (parseInt(ppn.options[ppn.selectedIndex].value) == 1) ? 10 : 0;

            // x = harga jual + diskon - ppn - harga beli
            // x = hasil * 100 / hargaBeli
            valDiskon = valHargaBeli * valDiskon / 100
            valPpn = valHargaBeli * valPpn / 100
            valKeuntungan = (valHargaJual + valDiskon - valPpn - valHargaBeli) * 100 / valHargaBeli;

            keuntungan.value = valKeuntungan.toFixed(2)

        }
    </script>



    <?php include('../templates/footer.php') ?>