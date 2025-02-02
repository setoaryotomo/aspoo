<?php
require 'config.php';
middleware();
$obat = getData("SELECT COUNT(obat_id) AS obat FROM obat")[0]["obat"];
$penjualan = getData("SELECT COUNT(penjualan_id) AS p_id FROM penjualan")[0]["p_id"];
$pembelian = getData("SELECT COUNT(pembelian_id) AS obat FROM pembelian")[0]["obat"];
?>


<?php $active[0] = 'active';
$title = "Dashboard " ?>
<?php include('templates/sidebar.php') ?>

<style>
    .nama {
        font-size: 20px;
        font-weight: 400;
    }

    .banner-2 {
        margin-top: 0 !important;
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

            <div class="banner-2 mb-5">
                <div class="row h-100">
                    <div class="col-md-12 text pt-4 pb-5 px-5 text-center align-self-center">
                        <h1>Apotek Banyu Aji</h1>
                        <h3>Sahabat Keluarga Sehat</h3>
                    </div>
                </div>
            </div>
            <div class="banner mt-5">
                <div class="row">
                    <div class="col-md-4 d-md-none d-none d-sm-block d-lg-block">
                        <img src="IMG/apotek.png" class="gambar">
                    </div>
                    <div class="col-md-8 pt-2 pl-md-3 isi-banner">
                        <h2 class="title-banner">Selamat Datang <?= ucfirst($_SESSION['data']['user_username']) ?>
                        </h2>
                        <div class="text-banner">
                            <p><i class="material-icons fa-2x">today</i> &nbsp<span id="days"></span></span></p>
                        </div>
                        <div class="button-banner">
                            <a href="laporan" class="btn btn-round btn-outline-primary cek-obat">Lihat Laporan <i class="material-icons fa-2x">arrow_forward</i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="chart" class="mt-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="chart-data">
                            <h3>Statistik Obat</h3>
                            <canvas height="180" id="myChart">
                            </canvas>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="chart-data">
                            <h3>Statistik Penjualan</h3>
                            <canvas height="180" id="myChart2">
                            </canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="assets/chart/chart.js"></script>

    <script>
        var grafik = document.getElementById("myChart").getContext('2d')
        var myChart = new Chart(grafik, {
            type: 'bar',
            data: {
                labels: ['week1', 'week2', 'week3', 'week4'],
                datasets: [{
                    label: 'data Obat',
                    data: [10, 7, 33, 5],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1,
                    hoverBackgroundColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ]
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        maintainAspectRatio: false,
                        stacked: true,
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }

        })
        var grafik2 = document.getElementById("myChart2").getContext('2d')
        var myChart2 = new Chart(grafik2, {
            type: 'bar',
            data: {
                labels: ['week1', 'week2', 'week3', 'week4'],
                datasets: [{
                    label: 'data penjualan',
                    data: [10, 7, 33, 5],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1,
                    hoverBackgroundColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ]
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        maintainAspectRatio: false,
                        stacked: true,
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }

        })
    </script>

    <?php include('templates/footer.php') ?>