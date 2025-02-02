<?php

require '../config.php';
middleware();
if (isset($_POST['obat'])) {
    extract($_POST);
    $id = $_SESSION['data']['user_id'];

    $obatku = $conn->query("SELECT * FROM barang WHERE id='$obat'")->fetch_assoc();
    $stok = intval($obatku['obat_stok']) + intval($jumlah);
    $stmt = $conn->prepare("UPDATE barang SET stock_global=?,obat_harga_beli=?,obat_harga_jual=? WHERE obat_id = ?");
    $stmt->bind_param("sssi", $stok, $harga_beli, $harga_jual, $obat);
    handleError($stmt->execute());

    // Logic Nomor Faktur
    $check = getData("SELECT * FROM pos_pembelian_faktur WHERE pembelian_faktur_nomor = '$no_faktur'");
    if (!isset($check[0])) {
        $insert = $conn->query("INSERT INTO pos_pembelian_faktur(pembelian_faktur_nomor,nama_supplier,tanggal_faktur) VALUES('$no_faktur','$supplier','$tanggal_faktur')");
        $no_faktur = $conn->insert_id;
    } else {
        $no_faktur = $check[0]['pembelian_faktur_id'];
        $conn->query("UPDATE pos_pembelian_faktur SET nama_supplier = '$supplier', tanggal_faktur = '$tanggal_faktur' WHERE pembelian_faktur_id = '$no_faktur'");
    }

    $stmt = $conn->prepare("INSERT INTO pos_pembelian(pembelian_obat_id,pembelian_supplier_id,pembelian_nomor_faktur,pembelian_tanggal_faktur,pembelian_jenis,pembelian_jumlah,pembelian_harga_beli,pembelian_harga_jual,pembelian_ppn,pembelian_diskon,pembelian_keuntungan,pembelian_user_id) VALUES(?,?,?,CAST(? AS DATE),?,?,?,?,?,?,?,?) ");
    $stmt->bind_param("ssssssssssss", $obat, $supplier, $no_faktur, $tanggal_faktur, $jenis_pembayaran, $jumlah, $harga_beli, $harga_jual, $ppn, $diskon, $keuntungan, $_SESSION['data']['user_id']);
    handleError($stmt->execute());
    refresh();
}
$title = 'Pembelian';
?>
<?php $active[4] = 'active' ?>

<?php include('../templates/sidebar.php') ?>

<!-- <style>
/* Important part */
.modal-dialog{
    overflow-y: initial !important
}
.modal-body{
    height: 500px;
    overflow-y: auto;
}
</style> -->

<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>

<div class="main-panel bgMain">
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
            <?php if (!isset($_GET['dataPembelian'])) : ?>
                <a href="pembelian/?dataPembelian=1" class="btn btn-primary">Lihat Data</a>

                <div class="card">
                    <div class="card-header card-header-primary card-header-bg">
                        <h4 class="card-title">Input Pembelian</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="" id="myform">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2 mt-2">
                                        Pilih Supplier
                                    </div>
                                    <div class="col-md-10">
                                        <select name="supplier" class="form-control selectpicker" data-style="btn btn-link" id="exampleFormControlSelect1" required>
                                            <?php $s = $conn->query("SELECT * FROM pos_supplier");
                                            $i = 1;
                                            while ($row = $s->fetch_assoc()) : ?>
                                                <option value="<?= $row['supplier_id'] ?>"><?= $row['supplier_nama'] ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-2 mt-2">
                                        Nomor Faktur
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" name="no_faktur" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-2 mt-2">
                                        Tanggal Faktur
                                    </div>
                                    <div class="col-md-10">
                                        <input type="date" class="form-control" name="tanggal_faktur" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2 mt-2">
                                        Jenis Pembayaran
                                    </div>
                                    <div class="col-md-10">
                                        <select name="jenis_pembayaran" class="form-control selectpicker" data-style="btn btn-link" id="exampleFormControlSelect1">
                                            <option>Cash</option>
                                            <option>Tempo 14 Hari</option>
                                            <option>Tempo 30 Hari</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2 mt-2">
                                        <input type="hidden" id="obat" name="obat">
                                        <span class="pilih-obat">Pilih Barang</span>
                                    </div>
                                    <div class="col-md-10">
                                        <a class="btn btn-primary ml- btn-sm" data-toggle="modal" data-target="#pilihObat">Pilih Barang</a>
                                        <span id="obat-selected" class="pl-3"></span>
                                    </div>
                                </div>
                                <!-- modal -->
                                <div class="modal fade" id="pilihObat" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Pilih Barang</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="table-responsive">
                                                    <table class="table" id="table_id">
                                                        <thead class="text-primary">
                                                            <th>No</th>
                                                            <th>Kode Barang</th>
                                                            <th>Nama Barang</th>
                                                            <th>Satuan Barang</th>
                                                            <th>Option</th>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 1;
                                                            $s = $conn->query("SELECT obat_kode,obat_nama,obat_satuan_id,obat_id FROM barang");
                                                            while ($row = $s->fetch_assoc()) : ?>
                                                                <tr>
                                                                    <td><?= $i++ ?></td>
                                                                    <td><?= $row['obat_kode'] ?></td>
                                                                    <td><?= $row['obat_nama'] ?></td>
                                                                    <td><?= $conn->query("SELECT * FROM barang WHERE satuan_id ='" . $row['satuan_id'] . "'")->fetch_assoc()['satuan_id'] ?>
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
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-2 mt-2">
                                        Jumlah Barang
                                    </div>
                                    <div class="col-md-10">
                                        <input type="number" value="0" id="jumlah" name="jumlah" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2 mt-2">
                                        Harga Beli
                                    </div>
                                    <div class="col-md-10">
                                        <input type="number" value="0" name="harga_beli" id="harga_beli" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2 mt-2">
                                        PPN
                                    </div>
                                    <div class="col-md-10">
                                        <select name="ppn" id="ppn" class="form-control selectpicker" data-style="btn btn-link" id="exampleFormControlSelect1">
                                            <option value="0">Tanpa PPN</option>
                                            <option value="1">PPN</option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2 mt-2">
                                        Diskon
                                    </div>
                                    <div class="col-md-10">
                                        <input type="number" value="0" id="diskon" name="diskon" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2 mt-2">
                                        Keuntungan
                                    </div>
                                    <div class="col-md-10">
                                        <input type="number" value="0" id="keuntungan" step="0.01" name="keuntungan" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2 mt-2">
                                        Harga Jual
                                    </div>
                                    <div class="col-md-10">
                                        <input type="number" value="0" name="harga_jual" id="harga_jual" class="form-control" required>
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

                <div class="alert alert-danger" role="alert" id="alerts" style="display: none;">
                    <ul>

                    </ul>
                </div>

            <?php elseif (isset($_GET['dataPembelian'])) : ?>
                <div class="card mt-5">
                    <div class="card-header card-header-primary card-header-bg">
                        <h4 class="card-title">Data Pembelian</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data_table" class="table">
                                <thead class="text-primary">
                                    <th>No</th>
                                    <th>Nama Supplier</th>
                                    <th>Nomor Faktur</th>
                                    <th>Tanggal Faktur</th>
                                    <th>Jumlah</th>
                                    <th>Option</th>
                                </thead>
                                <tbody>
                                    <?php $query = $conn->query("SELECT * FROM pos_pembelian_faktur ORDER BY dibuat DESC");
                                    $i = 1;
                                    while ($row = $query->fetch_assoc()) :
                                        $jumlahDat = getData("SELECT pembelian_jumlah,pembelian_harga_beli FROM pos_pembelian WHERE pembelian_nomor_faktur = '" . $row['pembelian_faktur_id'] . "'");
                                        $jumlahData = 0;
                                        foreach ($jumlahDat as $j) {
                                            $jumlahData += intval($j['pembelian_jumlah']) * intval($j['pembelian_harga_beli']);
                                        }

                                    ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= queryString("pos_supplier", ['supplier_id', 'supplier_nama'], $row['nama_supplier']) ?></td>
                                            <td><?= $row['pembelian_faktur_nomor'] ?></td>
                                            <td><?= tgl_indo($row['tanggal_faktur']) ?></td>
                                            <td><?= $jumlahData ?></td>
                                            <td class="td-actions">
                                                <a href="pembelian/lihat.php?id=<?= $row['pembelian_faktur_id'] ?>" class="btn btn-success btn-round"><i class="material-icons" title="detail">info</i></a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            <?php endif; ?>


        </div>
    </div>
    <?php include('../templates/footer.php') ?>

    <script>
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

        var valHargaBeliAsli = 0,
            valHargaJualAsli = 0,
            valPpnAsli = 0,
            valDiskonAsli = 0,
            valKeuntunganAsli = 0,
            valJumlahAsli = 0

        hargaBeli.addEventListener('keyup', rubahHarga)
        hargaJual.addEventListener('keyup', rubahHargaReverse)
        ppn.addEventListener('change', rubahHarga)
        diskon.addEventListener('keyup', rubahHarga)
        keuntungan.addEventListener('keyup', rubahHarga)
        jumlah.addEventListener('keyup', rubahHarga)



        function editObat(id, nama) {
            var input = document.querySelector("#obat")
            var ganti = document.querySelector("#obat-selected")
            ganti.innerHTML = nama
            input.value = id
            $.post('<?= $url ?>pembelian/api.php', {
                idObat: id,
                request: 'ambilObat'
            }, (data) => {
                if (data[0]) {
                    var ob = data[1]
                    var pl = data[2]

                    valHargaBeliAsli = parseInt(pl.pembelian_harga_beli)
                    valHargaJualAsli = parseInt(pl.pembelian_harga_jual)
                    valDiskonAsli = parseInt(pl.pembelian_diskon)
                    valKeuntunganAsli = parseInt(pl.pembelian_keuntungan)
                    valJumlahAsli = parseInt(ob.obat_stok)

                    valHargaBeli = parseInt(pl.pembelian_harga_beli)
                    valHargaJual = parseInt(pl.pembelian_harga_jual)
                    valDiskon = parseInt(pl.pembelian_diskon)
                    valKeuntungan = parseInt(pl.pembelian_keuntungan)
                    valJumlah = parseInt(ob.obat_stok)

                    if (pl.pembelian_ppn == 1) {
                        $('#ppn').val(1).change();
                        valPpnAsli = 10
                        valPpn = 10
                    } else {
                        $('#ppn').val(0).change();
                        valPpnAsli = 0
                        valPpn = 0
                    }

                    $('#harga_beli').val(valHargaBeli)
                    $('#harga_jual').val(valHargaJual)
                    $('#diskon').val(valDiskon)
                    $('#keuntungan').val(valKeuntungan)
                    $('#jumlah').val(valJumlah)
                } else {
                    $('#harga_beli').val('0')
                    $('#harga_jual').val('0')
                    $('#diskon').val('0')
                    $('#keuntungan').val('0')
                    $('#jumlah').val('0')
                    $('#ppn').val(0).change();

                }


            })
        }

        function autoMinus(before, after) {
            if (before == after) {
                return 0
            } else {
                return before - after;
            }
        }

        function appendmine(before, after, word) {
            if (before < 0) {
                $('#alerts').show()
                $('#alerts').children().append(`<li> ${word} tidak boleh kurang dari ${word} awal '${after}'`)
                return false;
            } else {
                return true;
            }

        }
        $('#myform').submit(function(event) {
            event.preventDefault();
            $('#alerts').children().empty()

            // valHargaJual = autoMinus(valHargaJual, valHargaJualAsli);
            // valHargaBeli = autoMinus(valHargaBeli, valHargaBeliAsli);
            // valKeuntungan = autoMinus(valKeuntungan, valKeuntunganAsli);
            // valDiskon = autoMinus(valDiskon, valDiskonAsli);
            valJumlah = autoMinus(valJumlah, valJumlahAsli);

            // var c1 = appendmine(valHargaJual, valHargaJualAsli, "Harga Jual")
            // var c2 = appendmine(valHargaBeli, valHargaBeliAsli, "Harga Beli")
            // var c3 = appendmine(valKeuntungan, valKeuntunganAsli, "Keuntungan")
            // var c4 = appendmine(valDiskon, valDiskonAsli, "Diskon")
            var c5 = appendmine(valJumlah, valJumlahAsli, "Jumlah")
            if (c5) {
                $('#jumlah').val(valJumlah);
                $('#alerts').hide();
                $(this).unbind('submit').submit();
            }
        })

        function validateHarga(input) {
            return (input == "") ? 0 : parseFloat(input);
        }

        function rubahHarga() {
            valHargaBeli = validateHarga(hargaBeli.value)
            valHargaJual = validateHarga(hargaJual.value)
            valDiskon = validateHarga(diskon.value)
            valKeuntungan = validateHarga(keuntungan.value)
            valJumlah = validateHarga(jumlah.value)

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
            valJumlah = validateHarga(jumlah.value)
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