<!doctype html>
<html lang="en">

<head>
  <title><?= $title ?> - ASPOO POS</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <base href="<?= $url ?>">
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- Material Kit CSS -->
  <link href="assets/css/material-dashboard.css" rel="stylesheet" />
  <link rel="stylesheet" href="assets/animate/animate.css">
  <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
  <!-- custom css -->
  <link rel="stylesheet" type="text/css" href="style/styles.css">
  <link rel="stylesheet" href="assets/icon-css/material-icons.css">

  <style>
    /* .fadeIn {
      animation-duration: 0.5s;
      animation-delay: 0.5s;
    } */
  </style>

</head>

<body>
  <div class="wrapper ">
    <div class="sidebar" data-color="white" data-background-color="blue">
      <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
    -->
      <div class="logo">
        <a href="index.php" class="simple-text logo-normal">
          ASPOO POS
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item <?php if (isset($active[0])) echo $active[0] ?>">
            <a class="nav-link" href="index.php">
              <i class="material-icons">dashboard</i>
              <p>Dashboard</p>
            </a>
          </li>
          <?php if ($_SESSION['role'] == 'admin') : ?>

            <li class="nav-item <?php if (isset($active[1])) echo $active[1] ?>">
              <a href="obat" class="nav-link">
                <i class="material-icons">business</i>
                <p>Barang</p>
              </a>
            </li>
            </li>
            <li class="nav-item <?php if (isset($active[2])) echo $active[2] ?>">
              <a href="satuan" class="nav-link">
                <i class="material-icons">add_box</i>
                <p>Satuan</p>
              </a>
            </li>
            <li class="nav-item <?php if (isset($active[3])) echo $active[3] ?>">
              <a href="supplier" class="nav-link">
                <i class="material-icons">local_shipping</i>
                <p>Supplier</p>
              </a>
            </li>
            <li class="nav-item <?php if (isset($active[7])) echo $active[7] ?>">
              <a href="pelanggan" class="nav-link">
                <i class="material-icons">people</i>
                <p>Pelanggan</p>
              </a>
            </li>
          <?php endif; ?>
          <li class="nav-item <?php if (isset($active[4])) echo $active[4] ?>">
            <a href="pembelian" class="nav-link">
              <i class="material-icons">shopping_cart</i>
              <p>Pembelian</p>
            </a>
          </li>
          <li class="nav-item <?php if (isset($active[5])) echo $active[5] ?>">
            <a href="penjualan" class="nav-link">
              <i class="material-icons">attach_money</i>
              <p>Penjualan</p>
            </a>
          </li>

          <!-- <li class="nav-item <?php if (isset($active[6])) echo $active[6] ?>">
            <a href="penjualan2" class="nav-link">
              <i class="material-icons">store</i>
              <p>Penjualan Dokter</p>
            </a>
          </li> -->

          <li class="nav-item <?php if (isset($active[8])) echo $active[8] ?>">
            <a href="laporan" class="nav-link">
              <i class="material-icons">content_paste</i>
              <p>Laporan</p>
            </a>
          </li>
          <!-- your sidebar here -->
        </ul>
      </div>
    </div>