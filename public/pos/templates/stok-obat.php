<?php $active[1] = 'active' ?>
<?php include('templates/sidebar.php') ?>



<div class="main-panel">
	<!-- Navbar -->
	<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
		<div class="container-fluid">
			<div class="navbar-wrapper">
				<span class="navbar-brand title-layout">Stok Obat</span>
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
					<h4 class="card-title">Input Stok Obat</h4>
				</div>
				<div class="card-body">
					<form>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="bmd-label-floating">Nama Obat</label>
									<input type="text" class="form-control" name="">
								</div>
								<div class="form-group">
									<label class="bmd-label-floating">Harga Obat</label>
									<input type="text" class="form-control" name="">
								</div>
							</div>
							<div class="col-md-6 mt-2">
								<select class="form-control selectpicker" data-style="btn btn-link" id="exampleFormControlSelect1">
									<option>satuan</option>
									<option>Satuan 1</option>
									<option>Satuan 2</option>
								</select>
							</div>
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
									<a href="#edit" data-toggle="modal"  class="btn btn-primary btn-round" rel="tooltip" ><i class="material-icons">edit</i></a>
									<a href="" class="btn btn-danger btn-danger btn-round" rel="tooltip"><i class="material-icons">delete</i></a>

									<!-- modal edit -->
									<div class="modal fade" id="pilihObat" tabindex="-1" role="dialog">
										<div class="modal-dialog modal-lg" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Pilih Obat</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">

													<form>
														<div class="row">
															<div class="col-md-10">
																<div class="form-group">
																	<label class="bmd-label-floating">Nama Obat</label>
																	<input type="text" class="form-control" name="">
																</div>
															</div>
															<div class="col-md-2">
																<button class="btn btn-primary">Cari</button>
															</div>
														</div>
													</form>

													<div class="table-responsive pt-3">
														<table class="table">
															<thead class="text-primary">
																<th>No</th>
																<th>Nama Obat</th>
																<th>Satuan Obat</th>
																<th>Harga</th>
																<th>Option</th>
															</thead>
															<tbody>
																<td>1</td>
																<td>Nama Obat</td>
																<td>Satuan</td>
																<td>999.999.999</td>
																<td><a href="#" class="btn btn-primary">Pilih</a></td>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
								</td>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>
	</div>





	<?php include('templates/footer.php') ?>