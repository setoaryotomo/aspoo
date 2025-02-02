<?php
require '../config.php';
middleware();
if (is_null($_GET['id'])) header("Location: index.php");

$id = $_GET['id'];

if (isset($_GET['method']) == 'delete') {
    $query = $conn->query("DELETE FROM supplier WHERE supplier_id='$id'");
    handleError($query);

    header("Location: index.php");
}

if (isset($_POST['nama'])) {
    extract($_POST);
    $id_user = $_SESSION['data']['user_id'];
    $query = $conn->query("UPDATE supplier SET supplier_nama='$nama', supplier_alamat='$alamat', supplier_user_id='$id_user' WHERE supplier_id='$id'");
    handleError($query);

    header("Location: index.php");
}
$res = $conn->query("SELECT * FROM supplier WHERE supplier_id='$id'")->fetch_assoc();


?>

<?php $title = " Edit Supplier"; ?>
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
                    <h4 class="card-title">Edit Supplier</h4>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label class="bmd-label-floating">Nama Supplier</label>
                            <input type="text" class="form-control" name="nama" placeholder="nama" value="<?= $res['supplier_nama'] ?>"><br>
                        </div>
                        <div class="form-group">
                            <label class="bmd-label-floating">Alamat Supplier</label>
                            <textarea class="form-control" name="alamat" id="alamatsupplier" rows="3"><?= $res['supplier_alamat'] ?></textarea>
                        </div>
                        <div class="form-group">
                            <div class="pull-right">
                                <button class="btn btn-primary">Edit Data</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include('../templates/footer.php') ?>