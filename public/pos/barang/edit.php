<?php
require '../config.php';
middleware();
if (is_null($_GET['id'])) header("Location: index.php");

$id = $_GET['id'];

if (isset($_GET['method']) == 'delete') {
    $query = $conn->query("DELETE FROM obat WHERE obat_id='$id'");
    handleError($query);

    header("Location: index.php");
}
if (isset($_POST['nama'])) {
    extract($_POST);
    $userId = $_SESSION['data']['user_id'];
    query("UPDATE obat SET obat_kode='$kode',obat_nama='$nama',obat_satuan_id='$satuan',obat_stok='$stok',obat_harga_jual='$harga_jual',obat_harga_beli='$harga_beli',obat_user_id='$userId' WHERE obat_id='$id'");
    header("Location: index.php");
}
$i = 1;
$data = $conn->query("SELECT * FROM obat WHERE obat_id='$id'")->fetch_assoc();
$satuan2 = $conn->query("SELECT * FROM satuan");
$title = "Edit Obat";
?>


<?php $active[1] = 'active' ?>
<?php include('../templates/sidebar.php') ?>
<div class="main-panel bgMain fadeIn animated">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
            <div class="navbar-wrapper">
                <span class="navbar-brand title-layout">Barang</span>
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
            <div class="card">
                <div class="card-header card-header-primary card-header-bg">
                    <h4 class="card-title">Input Stok Barang</h4>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Nama Barang</label>
                                    <input type="text" class="form-control" name="nama" value="<?= $data['obat_nama'] ?>">
                                </div>
                                <div class="form-group">
                                    <label class="bmd-label-floating">Kode Barang</label>
                                    <input type="text" class="form-control" name="kode" value="<?= $data['obat_kode'] ?>">
                                </div>
                                <div class="form-group">
                                    <label class="bmd-label-floating">Harga Jual Barang</label>
                                    <input type="text" class="form-control" name="harga_jual" value="<?= $data['obat_harga_jual'] ?>">
                                </div>
                                <div class="form-group">
                                    <label class="bmd-label-floating">Harga Beli Barang</label>
                                    <input type="text" class="form-control" name="harga_beli" value="<?= $data['obat_harga_beli'] ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <select class="form-control selectpicker" data-style="btn btn-link" id="exampleFormControlSelect1" name="satuan">
                                        <?php while ($row = $satuan2->fetch_assoc()) : ?>
                                            <option <?= ($data['obat_satuan_id'] == $row['satuan_id']) ? 'selected' : '' ?> value="<?= $row['satuan_id'] ?>"><?= $row['satuan_nama'] ?></option>
                                        <?php endwhile; ?>
                                    </select>

                                </div>
                                <div class="form-group">
                                    <label class="bmd-label-floating">Stok Barang</label>
                                    <input type="text" class="form-control" name="stok" value="<?= $data['obat_stok'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="pull-right">
                                <button class="btn btn-primary">Buat Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>





<?php include('../templates/footer.php') ?>