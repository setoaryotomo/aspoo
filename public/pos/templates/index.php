<?php $active[0] = 'active' ?>
<?php include('templates/sidebar.php') ?>



<div class="main-panel">
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
					<div class="search">
						<form>
							<div class="form-group">
								<input type="text" class="form-search" placeholder="Cari Sesuatu. . ." name="">
								<span class="material-icons fa-2x search-icon">search</span>
							</div>
						</form>
					</div>
					<!-- your navbar here -->
					<li class="nav-item dropdown mr-4 mt-2 dropdown-profil">
						<a href="#" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="material-icons fa-2x icon-profile">person</i>
							<p class="d-lg-none d-md-block">
								Account
							</p>
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
							<a class="dropdown-item" href="#">Log-out</a>
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
				<div class="row">
					<div class="col-md-4 d-md-none d-none d-sm-block d-lg-block">
						<img src="IMG/apotek.png" class="gambar">
					</div>
					<div class="col-md-8 pt-2 pl-md-3 isi-banner">
						<h2 class="title-banner">Selamat Datang Admin</h2>
						<div class="text-banner">
							<p><i class="material-icons fa-2x">today</i> &nbsp<span id="days"></span></p>
						</div>
						<div class="button-banner">
							<a href="stok-obat.php" class="btn btn-round btn-outline-primary cek-obat">Lihat stok obat <i class="material-icons fa-2x">arrow_forward</i></a>
						</div>
					</div>
				</div>
			</div>

			<div class="quick-card mt-5">
				<div class="row">
					<div class="col-md-4">
						<div class="row card-report m-2 p-3">
							<div class="col-6">
								<img src="IMG/obat.png" class="img-fluid pt-3">
							</div>
							<div class="col-6">
								<span class="title-report">Obat</span>
								<h1 class="total">99</h1>
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
								<h1 class="total">99</h1>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="row card-report m-2 p-3">
							<div class="col-6">
								<img src="IMG/money.png" class="img-fluid pt-3">
							</div>
							<div class="col-6">
								<span class="title-report">Keuntungan</span>
								<h1 class="total">99</h1>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="card mt-5">
				<div class="card-header card-header-primary card-header-bg">
					<h4 class="card-title">Data Stok Obat</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table">
							<thead class="text-primary">
								<th>No</th>
								<th>Nama Obat</th>
								<th>Satuan</th>
								<th>Harga Jual</th>
								<th>Harga Beli</th>
								<th>Jumlah</th>
								<th>Option</th>
							</thead>
							<tbody>
								<td>1</td>
								<td>Nama Obat</td>
								<td>Satuan</td>
								<td>999.999.999</td>
								<td>999.999.999</td>
								<td>100</td>
								<td class="td-actions">
									<a href="" class="btn btn-primary btn-round" rel="tooltip" ><i class="material-icons">edit</i></a>
									<a href="" class="btn btn-danger btn-danger btn-round" rel="tooltip"><i class="material-icons">delete</i></a>
								</td>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>
	</div>


<script type="text/javascript">
	const day = new Date();
	var weekdays = new Array(7);
	weekdays[0] = 'Minggu';
	weekdays[1] = 'Senin';
	weekdays[2] = 'Selasa';
	weekdays[3] = 'Rabu';
	weekdays[4] = 'Kamis';
	weekdays[5] = 'Jumat';
	weekdays[6] = 'Sabtu';

	var show = weekdays[day.getDay()];
	document.getElementById('days').innerHTML = show;
</script>


	<?php include('templates/footer.php') ?>