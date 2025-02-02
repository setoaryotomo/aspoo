<?php require '../config.php';
$title = 'Penjualan';
?>
<?php $active[5] = 'active' ?>
<?php include('../templates/sidebar.php') ?>
<div class="main-panel bgMain ">
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
                        <div class="alert alert-info ">
                            <h4 class="" style=" position: relative;" id="days"></h4>
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

            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger pt-4" role="alert">
                        <div class="row">
                            <div class="col-md-3">
                                <h2>Total Harga :</h2>
                            </div>
                            <div class="col-md-9">
                                <h2 class="mb-0" id="totalAtas">Rp. 0</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-3">
                    <div class="alert alert-primary " role="alert">
                        <h4>Jumlah</h4>
                        <p class="mb-0" id="jumlahAtas">0</p>
                    </div>
                </div> -->
                <!-- <div class="col-md-4">
                    <div class="alert alert-info " role="alert">
                        <h2 class="mb-0 text-center"><span style=" position: relative;" id="days"></span></h2>
                    </div>
                </div> -->
            </div>

            <div class="card mt-5">
                <div class="card-header card-header-primary card-header-bg">
                    <h4 class="card-title">Data Penjualan</h4>
                </div>
                <div class="card-body">

                    <form id="kirim" action="./penjualan/api.php" method="POST">
                        <input type="hidden" name="allData" id="allData">
                        <div class="form-group pt-3">
                            <div class="row">
                                <div class="col-md-2">
                                    <input type="hidden" name="obat" id="obat">
                                    <a class="btn btn-primary ml-4" data-toggle="modal" data-target="#pilihObat">Pilih Barang</a>

                                    <!-- modal -->
                                    <div class="modal fade" id="pilihObat" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Pilih Barang</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="table-responsive pt-3">
                                                        <table id="table_id" class="table">
                                                            <thead class="text-primary">
                                                                <th>No</th>
                                                                <th>Kode Barang</th>
                                                                <th>Nama Barang</th>
                                                                <th>Satuan Barang</th>
                                                                <th>Harga</th>
                                                                <th>Stok</th>
                                                                <th>Option</th>
                                                            </thead>
                                                            <tbody>
                                                                <?php $i = 1;
                                                                $s = $conn->query("SELECT * FROM barang");
                                                                while ($row = $s->fetch_assoc()) : ?>
                                                                    <tr>
                                                                        <td><?= $i++ ?></td>
                                                                        <td><?= $row['id'] ?></td>
                                                                        <td><?= $row['nama_barang'] ?></td>
                                                                        <td><?= $conn->query("SELECT * FROM barang WHERE satuan_id ='" . $row['satuan_id'] . "'")->fetch_assoc()['satuan_id'] ?>
                                                                        </td>
                                                                        <td><?= $row['harga_umum'] ?></td>
                                                                        <td><?= $row['stock_global'] ?></td>
                                                                        <td>
                                                                            <button data-dismiss="modal" <?= (intval($row['stock_global']) <= 0 ? "disabled" : "") ?> aria-label="Close" onclick="editObatPenjualan('<?= $row['id'] ?>')" class="btn btn-primary" type="button">Pilih</button>
                                                                        </td>
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
                                <div class="col-md-5">
                                    <div class="form-group text-center mt-3">
                                        <span class="pilih-obat" id="obat-selected">Nama Barang</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3 mt-3">
                                                <label for="jumlah" class="bmd-label-floating">Jumlah</label>
                                            </div>
                                            <div class="col-md-9 mt-2">
                                                <input type="number" class="form-control" name="jumlah" id="jumlah" value="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-primary" id="buat_data">Simpan</button>
                                        </div>
                                    </div>

                                    <input type="hidden" name="request" value="kirimData">
                                </div>
                             
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table mt-3">
                            <thead class="text-primary">
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </thead>
                            <tbody id="bodyTable">

                            </tbody>
                        </table>
                    </div>

                    <form class="pt-3">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-control selectpicker" data-style="btn btn-link" name="pelanggan" id="pelanggan">
                                        <option selected value="0">Pelanggan Biasa</option>
                                        <?php $sl = $conn->query("SELECT * FROM pos_pelanggan");
                                        while ($row = $sl->fetch_assoc()) : ?>
                                            <option value="<?= $row['pelanggan_id'] ?>"><?= $row['pelanggan_nama'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Total</label>
                                    <input type="text" class="form-control" name="total" id="total" value="0">
                                </div>
                                <div class="form-group">
                                    <label class="bmd-label-floating">Bayar</label>
                                    <input type="text" class="form-control" name="bayar" id="bayar" value="0">
                                </div>
                                <div class="form-group">
                                    <label class="bmd-label-floating">Kembali</label>
                                    <input type="text" class="form-control" name="kembali" disabled id="kembali" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="form-group pull-right">
                            <button class="btn btn-primary" id="simpan_data" type="button">Simpan Data</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
    <?php include('../templates/footer.php') ?>
    <script>
        var url = "./penjualan/api.php",
            dataPenjualan,
            arrData = [],
            deletedData = [],
            i = 0,
            dataObat,
            dataConvertSatuan = [],
            mSwitch = false,
            isClicked = false


        function editObatPenjualan(arr) {
            $.post(
                url, {
                    id: arr,
                    request: "dataObat",
                },
                (data, status, xhr) => {
                    dataObat = data;
                    $("#obat-selected").html(
                        data.obat_kode +
                        " | " +
                        data.obat_nama +
                        " | Rp. " +
                        data.obat_harga_jual
                    );
                }
            );
            isClicked = true
        }

        function hapusTr(it) {
            if (parseInt(it) != 0) it--;
            if (typeof arrData[it].penjualan_child_id != "undefined")
                deletedData.push(arrData[it]);
            delete arrData[it];
            $("#bodyTable").empty();
            i = 0
            iterateUlang()
            arrData = $.grep(arrData, (n) => {
                return n == 0 || n;
            });
            countTotal();
        }

        function countTotal() {
            var total = 0;
            var jumlah = 0;
            for (x in arrData) {
                total += parseInt(arrData[x].subtotal);
                jumlah += parseInt(arrData[x].jumlah_data)
            }
            $("#total").val(total);
            $('#jumlahAtas').html(jumlah);
            rubahTotalAtas()
            kembali();
        }

        function kembali() {
            $("#kembali").val(parseInt($("#bayar").val()) - parseInt($("#total").val()));
        }

        function iterateUlang() {
            arrData.forEach(dataIterate => {
                if (dataIterate.convertSatuan) {
                    $("#bodyTable").append(`
                        <tr id="tr_${i++}">
                            <td>${i}</td>
                            <td>${dataIterate.obat_nama}</td>
                            <td>${dataIterate.dc_satuan_nama} | (${dataIterate.satuan_nama})</td>
                            <td>${dataIterate.dc_jumlah} | (${dataIterate.dc_jumlah_asli})</td>
                            <td>${dataIterate.obat_harga_jual}</td>
                            <td>${dataIterate.subtotal}</td>
                            <td><button type="button" class="btn btn-danger" onclick="hapusTr('${i}')">Hapus</button></td>
                        </tr>
                    `);
                } else {
                    $("#bodyTable").append(`
                        <tr id="tr_${i++}">
                            <td>${i}</td>
                            <td>${dataIterate.obat_nama}</td>
                            <td>${dataIterate.satuan_nama}</td>
                            <td>${dataIterate.jumlah_data}</td>
                            <td>${dataIterate.obat_harga_jual}</td>
                            <td>${dataIterate.subtotal}</td>
                            <td><button type="button" class="btn btn-danger" onclick="hapusTr('${i}')">Hapus</button></td>
                        </tr>
                    `);
                }
            })
        }

        function rubahTotalAtas() {
            $('#totalAtas').html("Rp. " + $('#total').val())
            $('#totalAtas').change()
        }

        $(document).ready(() => {
            $("#buat_data").click(() => {
                if (parseInt(dataObat.obat_stok) < parseInt($('#jumlah').val())) {
                    alert("Jumlah tidak boleh melebihi dari stok obat! \n" + "Stok Barang : " + dataObat.obat_stok)
                    return;
                }
                dataObat["jumlah_data"] = parseInt($("#jumlah").val());
                dataObat["subtotal"] = parseInt(dataObat.jumlah_data) * parseInt(dataObat.obat_harga_jual);
                // tambah ke table
                if (mSwitch) {
                    mSwitch = false;
                    isClicked = false;
                    dataObat['dc_jumlah_asli'] = dataObat.jumlah_data
                    // Hidupin semisal mengikuti Convert
                    // dataObat.jumlah_data = dataObat.dc_jumlah_asli
                    dataObat['convertSatuan'] = true
                    $("#bodyTable").append(`
                <tr id="tr_${i++}">
                    <td>${i}</td>
                    <td>${dataObat.obat_nama}</td>
                    <td>${dataObat.dc_satuan_nama} | (${dataObat.satuan_nama})</td>
                    <td>${dataObat.dc_jumlah} | (${dataObat.dc_jumlah_asli})</td>
                    <td>${dataObat.obat_harga_jual}</td>
                    <td>${dataObat.subtotal}</td>
                    <td><button type="button" class="btn btn-danger" onclick="hapusTr('${i}')">Hapus</button></td>
                </tr>
                `);
                } else {
                    $("#bodyTable").append(`
                <tr id="tr_${i++}">
                    <td>${i}</td>
                    <td>${dataObat.obat_nama}</td>
                    <td>${dataObat.satuan_nama}</td>
                    <td>${dataObat.jumlah_data}</td>
                    <td>${dataObat.obat_harga_jual}</td>
                    <td>${dataObat.subtotal}</td>
                    <td><button type="button" class="btn btn-danger" onclick="hapusTr('${i}')">Hapus</button></td>
                </tr>
                `);
                    dataObat['convertSatuan'] = false;
                }
                arrData.push(dataObat);
                $("#obat-selected").html("Pilih Barang");
                $("#jumlah").val("");
                $("#m_total_obat").val("0")
                $("#m_jumlah_convert").val("0")
                countTotal();
            });

            $('#m_total_obat').keyup(() => {
                console.log(parseInt($('#jumlah').val()), parseInt($('#m_total_obat').val()))
                $('#m_jumlah_convert').val(parseInt($('#jumlah').val()) / parseInt($('#m_total_obat').val()))

            });

            $('#m_convert_satuan').click(() => {
                if (!isClicked) {
                    alert("Silahkan pilih obat terlebih dahulu")
                    $('#convert').modal('hide');
                    return;
                }
                if (parseInt($('#jumlah').val()) <= 0) {
                    alert("Silahkan diisi dulu jumlahnya")
                    $('#convert').modal('hide')
                    return;
                }
                $('#convert').modal('show');
                mSwitch = true;
                $('#penjelasan').html(`
                    Jumlah Awal : ${$("#jumlah").val()} <br>
                    Satuan Awal : ${dataObat.satuan_nama}
                `)
                // $('#jumlah_awal').html(" Jumlah : " + $('#jumlah').val())
                // $('#m_satuan_awal').html("Satuan : " + dataObat.satuan_nama)
                $.post(url, {
                    id: dataObat.obat_satuan_id,
                    request: "getSatuan"
                }, (data) => {
                    $("#m_satuan_dirubah").empty()
                    data.forEach((yw) => {
                        $('#m_satuan_dirubah').append(`<option value="${yw.satuan_id}">${yw.satuan_nama}</option>`).selectpicker("refresh")
                    })

                })


            })
            $('#m_simpan').click(() => {
                dataObat['dc_satuan_id'] = $('#m_satuan_dirubah').find(":selected").val()
                dataObat['dc_satuan_nama'] = $('#m_satuan_dirubah').find(":selected").text()
                dataObat['dc_jumlah'] = parseInt($('#m_jumlah_convert').val())
            })

            $("#bayar").keyup(() => {
                kembali();
            });
            var retr;
            $("#simpan_data").click(() => {
                if (parseInt($("#kembali").val()) < 0) {
                    alert("Kembalian tidak boleh minus")
                    return;
                }
                dataPenjualan = {
                    id_pelanggan: $("#pelanggan option:selected").val(),
                    total: $("#total").val(),
                    bayar: $("#bayar").val(),
                    kembali: $("#kembali").val(),
                };
                retr = {
                    request: "kirimData",
                    penjualan: dataPenjualan,
                    obat: arrData,
                };
                console.log(retr)

                console.log(JSON.stringify(retr))
                $("#allData").val(JSON.stringify(retr));
                $("#kirim").submit();
            });
        });
    </script>