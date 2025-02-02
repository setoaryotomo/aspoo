<?php require '../config.php';
$title = 'Penjualan';
if (!isset($_GET['id'])) return header("Location: index.php");
$id = $_GET['id'];
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
            <div class="card ">
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
                            </thead>
                            <tbody id="bodyTable">
                                <?php $i = 1;
                                foreach ($dataPenjualan as $row) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $row['obat_nama'] ?></td>
                                        <td><?= $row['satuan_nama'] ?></td>
                                        <td><?= $row['penjualan_child_jumlah'] ?></td>
                                        <td><?= $row['obat_harga_jual'] ?></td>
                                        <td><?= $row['penjualan_child_subtotal'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
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
                    </form>

                </div>
            </div>

        </div>
    </div>

    <?php include('../templates/footer.php') ?>