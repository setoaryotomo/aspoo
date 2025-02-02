<style type="text/css">
    .font-blue {
        color: #1971C4;
    }

    .pyy-3 {
        padding-top: 19px;
        padding-bottom: 19px;
    }

</style>

<?php
require '../config.php';
middleware();
if (isset($_POST['nama'])) {
    extract($_POST);
    $userId = $_SESSION['data']['user_id'];
    query("INSERT INTO barang(nama_barang,satuan_id,created_by_user_id,) VALUES('$nama','$satuan','$userId')");
    refresh();
}
$i = 1;
$s = $conn->query("SELECT * FROM obat ORDER BY obat_nama ASC");
$satuan2 = $conn->query("SELECT * FROM satuan");
$title = "Barang";
?>
<?php $active[1] = 'active' ?>
<?php include('../templates/sidebar.php') ?>
<div class="main-panel bgMain ">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
            <div class="navbar-wrapper">
                <span class="navbar-brand title-layout">Barang</span>
            </div>

            <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index"
                aria-expanded="false" aria-label="Toggle navigation">
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

            <div class="card mt-5">
                <div class="card-header card-header-primary card-header-bg">
                    <h4 class="card-title">Data Stok Barang</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_id" class="table">
                            <thead class="text-primary">
                                <th>No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th>Harga Supplier</th>
                                <th>Harga Umum</th>
                                <th>Jumlah</th>
                            </thead>
                            <tbody>
                                <?php $totalsupplier = 0;
                                $totalumum = 0;
                                while ($row = $s->fetch_assoc()) : ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= $row['nama_barang'] ?></td>
                                    <?php
                                    $namasatuan = $row['satuan_id'];

                                    $query = "SELECT barang.*, satuan.satuan_nama
                                            FROM barang
                                            INNER JOIN satuan ON barang.satuan_id = satuan.id
                                            WHERE barang.satuan_id = '$namasatuan'";
                                    $result = $conn->query($query);
                                    $row_result = $result->fetch_assoc();
                                    echo "<td>" . $row_result['satuan_nama'] . "</td>";
                                    ?>
                                    <td><?= $row['harga_supplier'] ?></td>
                                    <td><?= $row['harga_umum'] ?></td>
                                    <td><?= $row['stock_global'] ?></td>
                                </tr>
                                <?php 
                                $totalsupplier += intval($row['harga_supplier']) * intval($row['stock_global']);
                                $totalumum += intval($row['harga_umum']) * intval($row['stock_global']);
                                endwhile; ?>
                            </tbody>
                            <tfoot>
                                <td></td>
                                <td></td>
                                <td class="text-primary center-align">Jumlah Harga Supplier</td>
                                <td>Rp. <?= number_format($totalsupplier, 2, ',', '.') ?></td>
                                <td class="text-primary center-align">Jumlah Harga Umum</td>
                                <td>Rp. <?= number_format($totalumum, 2, ',', '.') ?></td>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>





    <?php include('../templates/footer.php') ?>
