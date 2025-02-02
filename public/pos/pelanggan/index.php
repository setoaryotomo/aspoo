<?php
require '../config.php';
middleware();
$query = $conn->query("SELECT * FROM pos_pelanggan ORDER BY pelanggan_nama ASC");
if (isset($_POST['nama'])) {
    extract($_POST);
    $id = $_SESSION['data']['user_id'];
    if (isset($_GET['edit'])) {
        $ed = $_GET['edit'];
        handleError($conn->query("UPDATE pos_pelanggan SET pelanggan_nama='$nama', pelanggan_no_telepon='$no_telepon', pelanggan_alamat='$alamat' , pelanggan_user_id='$id' WHERE pelanggan_id = '$ed'"));
        refresh();
    } else {
        handleError($conn->query("INSERT INTO pos_pelanggan(pelanggan_nama,pelanggan_user_id,pelanggan_no_telepon,pelanggan_alamat) VALUES('$nama','$id','$no_telepon','$alamat')"));
        refresh();
    }
}
if (isset($_GET['edit'])) {
    $ed = $_GET['edit'];
    $show = $conn->query("SELECT * FROM pos_pelanggan WHERE pelanggan_id = '$ed'")->fetch_assoc();
    handleError($show);
}
if (isset($_GET['delete'])) {
    $del = $_GET['delete'];
    handleError($conn->query("DELETE FROM pos_pelanggan WHERE pelanggan_id='$del'"));
    refresh();
}
$title = (isset($_GET['edit'])) ? "Edit" : "Data";
$title .= " Pelanggan";
?>
<?php $active[7] = 'active' ?>
<?php include('../templates/sidebar.php') ?>
<div class="main-panel bgMain fadeIn animated">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
            <div class="navbar-wrapper">
                <span class="navbar-brand title-layout">Stok Obat</span>
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
                    <h4 class="card-title">Input Pelanggan</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label class="bmd-label-floating">Nama Pelanggan</label>
                            <input type="text" class="form-control" name="nama" value="<?php if (isset($_GET['edit'])) echo $show['pelanggan_nama']; ?>">
                        </div>
                        <div class="form-group">
                            <label class="bmd-label-floating">No tlp Pelanggan</label>
                            <input type="number" class="form-control" name="no_telepon" value="<?= (isset($_GET['edit'])) ? $show['pelanggan_no_telepon'] : "" ?>">

                        </div>
                        <div class="form-group">
                            <label class="bmd-label-floating">Alamat Pelanggan</label>
                            <textarea class="form-control" cols="3" name="alamat"><?= (isset($_GET['edit'])) ? $show['pelanggan_alamat'] : "" ?></textarea>
                        </div>

                        <div class="form-group">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary">Buat Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-5">
                <div class="card-header card-header-primary card-header-bg">
                    <h4 class="card-title">Data Pelanggan</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_id" class="table">
                            <thead class="text-primary">
                                <th>No</th>
                                <th>Nama Pelanggan</th>
                                <th>No Telepon</th>
                                <th>Alamat Pelanggan</th>
                                <th>Option</th>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                while ($row = $query->fetch_assoc()) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $row['pelanggan_nama'] ?></td>
                                        <td><?= $row['pelanggan_no_telepon'] ?></td>
                                        <td><?= $row['pelanggan_alamat'] ?></td>
                                        <td class="td-actions">
                                            <a href="<?= $this_url ?>?edit=<?= $row['pelanggan_id'] ?>" class="btn btn-primary btn-round" rel="tooltip"><i class="material-icons">edit</i></a>
                                            <a href="<?= $this_url ?>?delete=<?= $row['pelanggan_id'] ?>" class="btn btn-danger btn-danger btn-round" rel="tooltip" onclick="return confirm('Hapus Data?')"><i class="material-icons">delete</i></a>
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
    <?php include('../templates/footer.php') ?>