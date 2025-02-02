<?php $active[5] = 'active' ?>
<?php include('templates/sidebar.php') ?>



<div class="main-panel">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
    <div class="container-fluid">
      <div class="navbar-wrapper">
        <span class="navbar-brand title-layout">Penjualan</span>
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
          <h4 class="card-title">Input Penjualan</h4>
        </div>
        <div class="card-body">
          <form action="POST">
            <div class="form-group pt-3">
              <div class="row">
                <div class="col-md-4">
                  <span class="pilih-obat">Pilih Obat</span>
                  <a class="btn btn-primary ml-4" data-toggle="modal" data-target="#pilihObat">Pilih Obat</a>

                  <!-- modal -->
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

                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="harga" class="bmd-label-floating">Harga Obat</label>
                    <input type="text" class="form-control" name="hargaObat">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="jumlah" class="bmd-label-floating">Jumlah</label>
                    <input type="text" class="form-control" name="jumlah">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="pull-right">
                <button type="button" class="btn btn-primary">Buat Data</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="card mt-5">
        <div class="card-header card-header-primary card-header-bg">
          <h4 class="card-title">Data Penjualan</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
              <thead class="text-primary">
                <th>No</th>
                <th>Nama Obat</th>
                <th>Satuan</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
              </thead>
              <tbody>
                <td>1</td>
                <td>Nama Obat</td>
                <td>Satuan</td>
                <td>100</td>
                <td>999.999.999</td>
                <td>999.999.999</td>
              </tbody>
            </table>
          </div>

          <form class="pt-3">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <select class="form-control selectpicker" data-style="btn btn-link" id="exampleFormControlSelect1">
                    <option>Nama Pelanggan</option>
                    <option>Nama Pelanggan 1</option>
                    <option>Nama Pelanggan 2</option>
                    <option>Nama Pelanggan 3</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="bmd-label-floating">Total</label>
                  <input type="text" class="form-control" name="">
                </div>
                <div class="form-group">
                  <label class="bmd-label-floating">Bayar</label>
                  <input type="text" class="form-control" name="">
                </div>
                <div class="form-group">
                  <label class="bmd-label-floating">Kembali</label>
                  <input type="text" class="form-control" name="">
                </div>
              </div>
            </div>
          </form>

        </div>
      </div>

    </div>
  </div>



  <?php include('templates/footer.php') ?>