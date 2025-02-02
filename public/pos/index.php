<?php
require 'config.php';
middleware();
$obat = getData("SELECT COUNT(id) AS barang FROM barang")[0]["barang"];
$penjualan = getData("SELECT COUNT(penjualan_id) AS p_id FROM pos_penjualan")[0]["p_id"];
$pembelian = getData("SELECT COUNT(pembelian_id) AS obat FROM pos_pembelian")[0]["obat"];
?>


<?php $active[0] = 'active';
$title = "Dashboard " ?>
<?php include('templates/sidebar.php') ?>

<style>
    .nama {
        font-size: 20px;
        font-weight: 400;
    }

    .posisi {
        padding-top: 6px;
        font-size: 15px;
        color: #bababa;
    }
</style>

<div class="main-panel bgDashboard fadeIn animated">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
            <div class="navbar-wrapper">
                <span class="navbar-brand title-layout">Dashboard</span>
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
                    <li class="nav-item dropdown mr-4 mt-2 dropdown-profil">
                        <a href="#" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons fa-2x icon-profile">person</i>
                            <p class="d-lg-none d-md-block">
                                Account
                            </p>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                            <div class="px-2 pt-2">
                                <div class="nama"><?= $_SESSION['data']['user_username'] ?></div>
                                <div class="posisi"><?= $_SESSION['role'] ?></div>
                                <hr>
                            </div>
                            <a class="dropdown-item" href="logout.php"><i class="material-icons pr-3">power_settings_new</i> Log out</a>
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

            <div class="banner">
                    <div class="row h-100">
                    <div class="col-md-12 text pt-4 pb-5 px-5 text-center align-self-center isi-banner">
                        <h2 class="title-banner">Selamat Datang <?= ucfirst($_SESSION['data']['user_name']) ?></h2>
                        <div class="text-banner">
                            <p><i class="material-icons fa-2x">today</i> &nbsp<span id="days"></span></span></p>
                        </div>
                        <div class="button-banner">
                            <a href="laporan" class="btn btn-round btn-outline-primary cek-obat">Lihat Laporan <i class="material-icons fa-2x">arrow_forward</i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="quick-card mt-5">
                <div class="row">
                    <div class="col-md-4">
                        <div class="row card-report m-2 p-3">
                            <div class="col-6">
                                <img src="IMG/obat.png" class="img-fluid pt-3">
                            </div>
                            <div class="col-6">
                                <span class="title-report">Obat</span>
                                <h1 class="total"><//?= $obat ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row card-report m-2 p-3">
                            <div class="col-6">
                                <img src="IMG/sell.png" class="img-fluid pt-3">
                            </div>
                            <div class="col-6">
                                <span class="title-report">Penjualan</span>
                                <h1 class="total"><//?= $penjualan ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row card-report m-2 p-3">
                            <div class="col-6">
                                <img src="IMG/money.png" class="img-fluid pt-3">
                            </div>
                            <div class="col-6">
                                <span class="title-report">Pembelian</span>
                                <h1 class="total"><//?= $pembelian ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="banner-2">
                <div class="row h-100">
                    <div class="col-md-12 text pt-4 pb-5 px-5 text-center align-self-center">
                        <h1>ASPOO POS</h1>
                        <h3>Point Of Sales</h3>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php include('templates/footer.php') ?>