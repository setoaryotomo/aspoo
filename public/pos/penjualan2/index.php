<?php require '../config.php';
$title = 'Penjualan';
?>
<?php $active[6] = 'active' ?>
<?php include('../templates/sidebar.php') ?>
<div class="main-panel bgMain ">
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

                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="content">
        <div class="container">
            <!-- your content here -->

            <div class="row">
                <div class="col-md-6">
                    <div class="alert alert-danger px-4" role="alert">
                        <div class="row">
                            <div class="col-md-4">
                                <h3>Total uang : </h3>
                            </div>
                            <div class="col-md-8">
                                <h3>Rp. 999.999.999</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="alert alert-danger px-4" role="alert">
                        <div class="row">
                            <div class="col-md-4">
                                <h3>Total uang : </h3>
                            </div>
                            <div class="col-md-8">
                                <h3>Rp. 999.999.999</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="alert alert-info px-4 kalender " role="alert">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="gambar-kalender"><img src="IMG/kalender.png" alt=""></div>
                                <p><span style="position: relative;" id="days"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-5">
                <div class="card-header card-header-primary card-header-bg">
                    <h4 class="card-title">Data Penjualan</h4>
                </div>
                <div class="card-body">

                    <form id="kirim" action="./penjualan/api.php" method="POST">
                        <input type="hidden" name="allData" id="allData">
                        <div class="form-group pt-3">
                            <div class="row">
                                <div class="col-md-2">
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
                                <div class="col-md-5">
                                    <div class="form-group text-center mt-3">
                                        <span class="pilih-obat" id="obat-selected">Nama Obat</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3 mt-3">
                                                <label for="jumlah" class="bmd-label-floating">Jumlah</label>
                                            </div>
                                            <div class="col-md-9 mt-2">
                                                <input type="text" class="form-control" name="jumlah" id="jumlah">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="">
                                            <button type="button" class="btn btn-primary" id="buat_data">Simpan</button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="request" value="kirimData">
                                </div>
                            </div>

                            <div class="modal-convert">
                                <div class="pull-right">
                                    <a class="btn btn-primary ml-4" data-toggle="modal" data-target="#convert">Convert satuan</a>
                                    <div class="modal fade" id="convert" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5>Convert satuan obat</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-convert">
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Input total obat</label>
                                                            <input type="text" class="form-control" name="nama">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="bmd-label-floating">Input total satuan</label>
                                                            <input type="text" class="form-control" name="nama">
                                                        </div>
                                                        <div class="form-group">
                                                            <button class="btn btn-primary">convert satuan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table mt-3">
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

                            </tbody>
                        </table>
                    </div>

                    <form class="pt-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-control selectpicker" data-style="btn btn-link" name="pelanggan" id="pelanggan">
                                        <option disabled selected>-- PILIH PELANGGAN --</option>
                                        <?php $sl = $conn->query("SELECT * FROM pelanggan");
                                        while ($row = $sl->fetch_assoc()) : ?>
                                            <option value="<?= $row['pelanggan_id'] ?>"><?= $row['pelanggan_nama'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Total</label>
                                    <input type="text" class="form-control" name="total" id="total" value="0">
                                </div>
                                <div class="form-group">
                                    <label class="bmd-label-floating">Bayar</label>
                                    <input type="text" class="form-control" name="bayar" id="bayar" value="0">
                                </div>
                                <div class="form-group">
                                    <label class="bmd-label-floating">Kembali</label>
                                    <input type="text" class="form-control" name="kembali" disabled id="kembali" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="form-group pull-right">
                            <button class="btn btn-primary" id="simpan_data" type="button">Simpan Data</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
    <?php include('../templates/footer.php') ?>
    <script src="assets/js/main.js" type="text/javascript"></script>