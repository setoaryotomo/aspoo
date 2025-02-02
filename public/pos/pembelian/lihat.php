<?php

require '../config.php';
middleware();
$title = 'Pembelian';
?>

<?php
if (isset($_POST['id_pembelian'])) {
    $id = $_POST['id_pembelian'];
    query("UPDATE pembelian SET pembelian_lunas = 'Lunas' WHERE pembelian_id='$id' ");
}

?>
<?php $active[4] = 'active' ?>

<?php include('../templates/sidebar.php') ?>
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
            <div class="card mt-5">
                <div class="card-header card-header-primary card-header-bg">
                    <h4 class="card-title">Data Pembelian</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="data_table" class="table">
                            <thead class="text-primary text-center">
                                <th>No</th>
                                <th>Nama Supplier</th>
                                <th>Jenis</th>
                                <th>Nama Obat</th>
                                <th>Jumlah</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Status</th>
                                <!-- <th>Option</th> -->
                            </thead>
                            <tbody>
                                <?php $query = $conn->query("SELECT * FROM pos_pembelian INNER JOIN pos_pembelian_faktur ON pos_pembelian.pembelian_nomor_faktur = pos_pembelian_faktur.pembelian_faktur_id  WHERE pos_pembelian.pembelian_nomor_faktur = '$_GET[id]' ORDER BY pembelian_dibuat DESC");
                                $i = 1;
                                while ($row = $query->fetch_assoc()) :

                                ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <?php if ($i == 2) : ?>
                                            <td><?= queryString("pos_supplier", ['supplier_id', 'supplier_nama'], $row['pembelian_supplier_id']) ?></td>
                                            <td><?= $row['pembelian_jenis'] ?></td>
                                        <?php else : ?>
                                            <td></td>
                                            <td></td>
                                        <?php endif; ?>
                                        <td><?= queryString("barang", ['id', 'nama_barang'], $row['pembelian_obat_id']) ?></td>
                                        <td><?= $row['pembelian_jumlah'] ?></td>
                                        <td>Rp. <?= $row['pembelian_harga_beli'] ?></td>

                                        <td><?= "Rp." . $row['pembelian_harga_jual'] ?></td>
                                        <td class="text-center">
                                            <?php if ($row['pembelian_lunas'] == "Lunas") : ?>
                                                <button class="btn btn-primary" disabled>Sudah Lunas</button>
                                            <?php else : ?>
                                                <form action="" method="POST">
                                                    <input type="hidden" name="id_pembelian" value="<?= $row['pembelian_id'] ?>">
                                                    <button class="btn btn-danger" type="submit">Belum Lunas</button>
                                                </form>

                                            <?php endif; ?>
                                        </td>
                                        <!-- <td class=" td-actions">
                                            <a href="./pembelian/edit.php?edit=<?= $row['pembelian_id'] ?>" class="btn btn-primary btn-round" rel="tooltip"><i class="material-icons">edit</i></a>
                                            <a href="./pembelian/edit.php?delete=<?= $row['pembelian_id'] ?>" class="btn btn-danger btn-danger btn-round" rel="tooltip" onclick="return confirm('Hapus Data?')"><i class="material-icons">delete</i></a>
                                        </td> -->
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
<?php include('../templates/footer.php') ?>
<script>


</script>