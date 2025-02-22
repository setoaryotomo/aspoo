<?php require '../config.php';
$title = 'Laporan';
?>
<?php $active[8] = 'active' ?>
<?php include('../templates/sidebar.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    <!-- Load jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Load DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
</head>
<body>

<div class="main-panel bgMain fadeIn animated">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
            <div class="navbar-wrapper">
                <span class="navbar-brand title-layout">Laporan</span>
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

            <!-- card laporan uang -->
            <div class="laporan-uang mb-2">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-4 mb-3">
                        <div class="custom-card uang-masuk">
                            <h2>Uang Penjualan</h2>
                            <p class="total-uang-masuk" id="uang_masuk">Rp. 0</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="custom-card uang-keluar" style="display: none;">
                            <h2>Uang Pembelian</h2>
                            <p class="total-uang-masuk" id="uang_keluar">Rp. 0</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="custom-card uang-piutang" style="display: none;">
                            <h2>Uang Piutang</h2>
                            <p class="total-uang-masuk" id="uang_piutang">Rp. 0</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="time">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                Tampilkan laporan Berdasarkan
                            </span>
                        </div>
                        <input type="date" class="tanggal" id="tanggal" value='<?php echo date('Y-m-d'); ?>'>
                    </div>
                </div>
            </div>

            <!-- <div class="card mt-5">
                <div class="card-header card-header-primary card-header-bg">
                    <h4 class="card-title">Laporan Pembelian</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="pembelian_table" class="table">
                            <thead class="text-primary">
                                <th>No</th>
                                <th>Nama Supplier</th>
                                <th>Nomor Faktur</th>
                                <th>Jumlah</th>
                                <th>Option</th>
                            </thead>
                            <tbody id="laporan_pembelian">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> -->

            <div class="card mt-5">
                <div class="card-header card-header-primary card-header-bg">
                    <h4 class="card-title">Laporan Penjualan</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="penjualan_table">
                            <thead class="text-primary">
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Harga Jual</th>
                                <th>Jumlah</th>
                                <th>Total Harga</th>
                                <!-- <th>Option</th> -->
                            </thead>
                            <tbody id="laporan_penjualan">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>




    <?php include('../templates/footer.php') ?>
    <script>
        function formatNumber(num) {
            if (num != null) {
                return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
            } else {
                return 0
            }
        }

        $(document).ready(() => {
            run();

            $('#tanggal').change(() => {
                clean();
                run();
            });
        });

        function run() {
            var url = "./laporan/api.php";
            clean();
            $.post(url, {
                request: 'ambilData',
                hari: $("#tanggal").val()
            }, (data, status, xhr) => {
                console.log(data); // Check the data in console
                if (data.uang_masuk.uang_masuk != null) {
                    var i = 1;
                    $('#uang_masuk').html("Rp. " + formatNumber(data.uang_masuk.uang_masuk));
                    data.penjualan.forEach(penjualan => {
                        if (typeof penjualan.pelanggan_nama === 'undefined' || penjualan.pelanggan_nama === null)
                            penjualan['pelanggan_nama'] = "Pelanggan";
                        $('#laporan_penjualan').append(`
                            <tr>
                                <td>${i++}</td>
                                <td>${penjualan.nama_barang}</td>
                                <td>Rp. ${formatNumber(penjualan.harga_umum)}</td>
                                <td>${formatNumber(penjualan.penjualan_child_jumlah)}</td>
                                <td>Rp. ${formatNumber(penjualan.harga_umum * penjualan.penjualan_child_jumlah)}</td>
                            </tr>
                        `);
                    });
                }

                if (data.uang_keluar.uang_keluar != null || data.uang_piutang.uang_keluar != null) {
                    $('#uang_keluar').html("Rp. " + formatNumber(data.uang_keluar.uang_keluar));
                    $('#uang_piutang').html("Rp. " + formatNumber(data.uang_piutang.uang_keluar));
                    var i = 1;
                    data.pembelian.forEach(pembelian => {
                        $('#laporan_pembelian').append(`
                            <tr>
                                <td>${i++}</td>
                                <td>${pembelian.supplier_nama}</td>
                                <td>${pembelian.pembelian_faktur_nomor}</td>
                                <td>${pembelian.jumlahData}</td>
                                <td class="td-actions">
                                    <a href="./pembelian/lihat.php?id=${pembelian.pembelian_faktur_id}" class="btn btn-success btn-round" rel="tooltip">
                                        <i class="material-icons"> info </i>
                                    </a>
                                </td>
                            </tr>
                        `);
                    });
                    $('#penjualan_table').DataTable({
                        "ordering": false
                    });
                    $('#pembelian_table').DataTable({
                        "ordering": false
                    });
                }
            }).fail((jqXHR, textStatus, errorThrown) => {
                console.error("Error: ", textStatus, errorThrown); // Log any errors
            });
        }

        function clean() {
            $('#uang_masuk').html("Rp. " + formatNumber("0"));
            $('#uang_keluar').html("Rp. " + formatNumber("0"));
            $('#laporan_penjualan').html(" ");
            $('#laporan_pembelian').html(" ");
        }
    </script>
</body>
</html>