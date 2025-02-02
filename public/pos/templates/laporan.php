<?php $active[7] = 'active' ?>
<?php include('templates/sidebar.php') ?>



<div class="main-panel">
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
					<div class="col-md-6 mb-3">
						<div class="custom-card uang-masuk">
							<h2>Uang Masuk</h2>
							<p class="total-uang-masuk">Rp. <span class="uang">123.456.789</span></p>
						</div>
					</div>
					<div class="col-md-6 mb-3">
						<div class="custom-card uang-keluar">
							<h2>Uang Keluar</h2>
							<p class="total-uang-masuk">Rp. <span class="uang">123.456.789</span></p>
						</div>
					</div>
				</div>
			</div>

			<div class="card mt-5">
				<div class="card-header card-header-primary card-header-bg">
					<h4 class="card-title">Laporan Uang Apotek</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table">
							<thead class="text-primary">
								<th>No</th>
								<th>ID Transaksi</th>
								<th>Jenis Transaksi</th>
								<th>Jumlah Uang</th>

							</thead>
							<tbody>
								<td>1</td>
								<td>12345</td>
								<td>Jenis Transaksi</td>
								<td>999.999.999</td>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="card mt-5">
				<div class="card-header card-header-primary card-header-bg">
					<h4 class="card-title">Laporan Penjualan</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table">
							<thead class="text-primary">
								<th>No</th>
								<th>ID Transaksi</th>
								<th>Jumlah Harga</th>
								<th>Dibayar</th>
								<th>Kembalian</th>
								<th>Option</th>
							</thead>
							<tbody>
								<td>1</td>
								<td>12345</td>
								<td>999.999.999</td>
								<td>999.999.999</td>
								<td>999.999.999</td>
								<td class="td-actions">
									<a href="" class="btn btn-success btn-round"><i class="material-icons" title="detail">info</i></a>
									<a href="" class="btn btn-primary btn-round" rel="tooltip"><i class="material-icons" title="edit data">edit</i></a>
									<a href="" class="btn btn-danger btn-danger btn-round" rel="tooltip"><i class="material-icons" title="hapus data">delete</i></a>
								</td>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>
	</div>




	<?php include('templates/footer.php') ?>