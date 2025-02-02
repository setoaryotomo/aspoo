<?php require '../config.php';
$title = 'Penjualan';
if (!isset($_GET['edit'])) return header("Location: index.php");
$id = $_GET['edit'];
$dataPenjualanParent = getData("SELECT * FROM penjualan a INNER JOIN pelanggan b ON a.`penjualan_pelanggan_id`=b.`pelanggan_id` WHERE penjualan_id='$id'")[0];
$idPenjualan = $dataPenjualanParent['penjualan_id'];
$dataPenjualan = getData("SELECT * FROM penjualan_child a INNER JOIN obat b ON a.`penjualan_child_obat_id`=b.`obat_id` INNER JOIN satuan c  ON b.`obat_satuan_id`=c.`satuan_id` WHERE penjualan_parent_id='$idPenjualan' ");
?>
<?php $active[5] = 'active' ?>
<?php include('../templates/sidebar.php') ?>
<div class="main-panel bgMain fadeIn animated">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
            <div class="navbar-wrapper">
                <span class="navbar-brand title-layout">Penjualan</span>
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
                    <h4 class="card-title">Input Penjualan</h4>
                </div>
                <div class="card-body">
                    <form id="kirim" action="./penjualan/api.php" method="POST">
                        <input type="hidden" name="request" value="editData">
                        <input type="hidden" name="allData" id="allData">
                        <div class="form-group pt-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <input type="hidden" name="obat" id="obat">
                                    <a class="btn btn-primary ml-4" data-toggle="modal" data-target="#pilihObat">Pilih Obat</a>

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
                                                        <table id="table_id" class="table">
                                                            <thead class="text-primary">
                                                                <th>No</th>
                                                                <th>Kode Obat</th>
                                                                <th>Nama Obat</th>
                                                                <th>Satuan Obat</th>
                                                                <th>Harga</th>
                                                                <th>Stok</th>
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
                                                                        <td><?= $row['obat_harga_jual'] ?></td>
                                                                        <td><?= $row['obat_stok'] ?></td>
                                                                        <td>
                                                                            <button data-dismiss="modal" aria-label="Close" onclick="editObatPenjualan('<?= $row['obat_id'] ?>')" class="btn btn-primary" type="button">Pilih</button>
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
                                <div class="col-md-4">
                                    <span class="pilih-obat" id="obat-selected">Nama Obat</span>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="jumlah" class="bmd-label-floating">Jumlah</label>
                                        <input type="text" class="form-control" name="jumlah" id="jumlah">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="pull-right">
                                <button type="button" class="btn btn-primary" id="buat_data">Buat Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mt-5">
                <div class="card-header card-header-primary card-header-bg">
                    <h4 class="card-title">Data Penjualan</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-primary">
                                <th>No</th>
                                <th>Nama Obat</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </thead>
                            <tbody id="bodyTable">
                                <?php $i = 0;
                                foreach ($dataPenjualan as $row) : ?>
                                    <tr id="tr_<?= $i++ ?>">
                                        <td><?= $i ?></td>
                                        <td><?= $row['obat_nama'] ?></td>
                                        <td><?= $row['satuan_nama'] ?></td>
                                        <td><?= $row['penjualan_child_jumlah'] ?></td>
                                        <td><?= $row['obat_harga_jual'] ?></td>
                                        <td><?= $row['penjualan_child_subtotal'] ?></td>
                                        <td><button type="button" class="btn btn-danger" onclick="hapusTr('<?= $i ?>')">Hapus</button></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <form method="POST" class="pt-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-control selectpicker" data-style="btn btn-link" name="pelanggan" id="pelanggan">
                                        <option disabled selected>-- PILIH PELANGGAN --</option>
                                        <?php $sl = $conn->query("SELECT * FROM pelanggan");
                                        while ($row = $sl->fetch_assoc()) : ?>
                                            <option <?php if ($dataPenjualanParent['pelanggan_id'] == $row['pelanggan_id']) echo "selected" ?> value="<?= $row['pelanggan_id'] ?>"><?= $row['pelanggan_nama'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Total</label>
                                    <input type="text" class="form-control" name="total" id="total" value="<?= $dataPenjualanParent['penjualan_total_harga'] ?>">
                                </div>
                                <div class="form-group">
                                    <label class="bmd-label-floating">Bayar</label>
                                    <input type="text" class="form-control" name="bayar" id="bayar" value="<?= $dataPenjualanParent['penjualan_bayar'] ?>">
                                </div>
                                <div class="form-group">
                                    <label class="bmd-label-floating">Kembali</label>
                                    <input type="text" class="form-control" name="kembali" disabled id="kembali" value="<?= $dataPenjualanParent['penjualan_kembali'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group pull-right">
                            <button class="btn btn-primary" id="edit_data" type="button">Edit Data</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

    <?php include('../templates/footer.php') ?>
    <script src="assets/js/main.js" type="text/javascript"></script>
    <script>
        $(document).ready(() => {
            var urlS = new URL(window.location.href);
            var idGet = urlS.searchParams.get("edit");
            $.post(url, {
                id: idGet,
                request: "getDataEdit"
            }, (data, status, xhr) => {
                for (var x in data) {

                    data[x].jumlah_data = data[x].penjualan_child_jumlah
                    data[x].subtotal = data[x].penjualan_child_subtotal
                    arrData.push(data[x])
                    i++
                }
            })
            $('#edit_data').click(() => {

                dataPenjualan = {
                    "id_pelanggan": $("#pelanggan option:selected").val(),
                    "total": $('#total').val(),
                    "bayar": $('#bayar').val(),
                    "kembali": $('#kembali').val(),
                }
                var retr = {
                    "id_penjualan": idGet,
                    request: "editData",
                    penjualan: dataPenjualan,
                    obat: arrData,
                    dataHapus: deletedData

                }
                $('#allData').val(JSON.stringify(retr))
                $('#kirim').submit()
            })
        })
    </script>