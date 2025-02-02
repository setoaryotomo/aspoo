<?php
require '../config.php';
middleware();

if (isset($_POST['nama'])) {
    extract($_POST);
    $id = $_SESSION['data']['user_id'];
    $query = $conn->query("INSERT INTO pos_supplier(supplier_nama,supplier_alamat,supplier_user_id) VALUES('$nama','$alamat','$id')");
    handleError($query);

    header("Refresh: 0");
}

$query = "SELECT * FROM pos_supplier ORDER BY supplier_nama ASC";
$rt = $conn->query($query);
$i = 1;
$title = "Supplier";
?>


<?php $active[3] = 'active' ?>
<?php include('../templates/sidebar.php') ?>



<div class="main-panel bgMain">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
            <div class="navbar-wrapper">
                <span class="navbar-brand title-layout">Supplier</span>
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
                    <h4 class="card-title">Input Supplier</h4>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label class="bmd-label-floating">Nama Supplier</label>
                            <input type="text" class="form-control" name="nama">
                        </div>
                        <div class="form-group">
                            <label class="bmd-label-floating">Alamat Supplier</label>
                            <textarea class="form-control" name="alamat" id="alamatsupplier" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="pull-right">
                                <button class="btn btn-primary">Buat Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-5">
                <div class="card-header card-header-primary card-header-bg">
                    <h4 class="card-title">Data Supplier</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_id" class="table">
                            <thead class="text-primary">
                                <th>No</th>
                                <th>Nama Supplier</th>
                                <th>Alamat Supplier</th>
                                <th>Option</th>
                            </thead>
                            <tbody>
                                <?php while ($row = $rt->fetch_assoc()) : ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $row['supplier_nama'] ?></td>
                                        <td><?= $row['supplier_alamat'] ?></td>
                                        <td class="td-actions">
                                            <a href="supplier/edit.php?id=<?= $row['supplier_id'] ?>" class="btn btn-primary btn-round"><i class="material-icons">edit</i></a>
                                            <a href="supplier/edit.php?method=delete&&id=<?= $row['supplier_id'] ?>" class="btn btn-danger btn-danger btn-round" onclick="return confirm('Hapus Data?')"><i class="material-icons">delete</i></a>
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