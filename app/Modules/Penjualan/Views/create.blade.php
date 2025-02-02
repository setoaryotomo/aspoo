@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner">
        <div id="add-penjualan" class="card">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Tambah Penjualan</h4>
                </div>
            </div>
            <div class="card-body">
                <form ref="penjualan_form">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group" :class="validate(validation.nomor_faktur)">
                                <label class="form-control-label">Nomor Faktur</label>
                                <input v-model="penjualan.nomor_faktur" @keyup="checkNomorFaktur" class="form-control"
                                    type="text">
                                <small class="form-text text-muted">@{{ (validation.nomor_faktur.is_error ? validation.nomor_faktur.message : "") }}</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Tanggal Penjualan</label>
                                <vue-datepicker v-model="penjualan.tanggal_penjualan" :enable-time-picker="false"
                                    text-input></vue-datepicker>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Sumber Transaksi</label>
                                <vue-multiselect v-model="penjualan.sumber_transaksi" :searchable="true"
                                    :options="sumber_transaksi_list" />
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <h4 class="card-title">Data Penjualan</h4>
                        </div>
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-4">
                            <button @click="handleAddDataBarang" type="button" style="float: right;"
                                class="btn  btn-info mr-1" data-toggle="modal">
                                Tambah Data
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">

                            <div class="penjualan-data-table">
                                <div class="table-responsive">
                                    <table class="table align-items-center table-hover">
                                        <thead class="bg-grey1">
                                            <tr>
                                                <td>Kode Barang</td>
                                                <td>Diskon</td>
                                                <td>Harga Jual</td>
                                                <td>Jumlah Barang</td>
                                                <td>Total Bayar</td>
                                                <td>Aksi</td>
                                            </tr>
                                   
                                        </thead>
                                        <tbody id="body">

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" @click="back" class="btn btn-sm bg-warning mr-2 text-white">
                            Cancel
                        </button>
                        <button type="button" @click="store" class="btn btn-sm bg-primary mr-2 text-white">
                            Save Data
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <div ref="modal" class="modal fade" id="addDataBarang" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-bold">Tambah Data Penjualan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label">Kode Barang</label>
                                    <vue-multiselect v-model="penjualan.kode_barang" :searchable="true"
                                    :options="kode_barang_list" />
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Diskon</label>
                                    <input type="text" v-model="penjualan.diskon" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Harga Jual</label>
                                    <input type="text" v-model="penjualan.harga_jual" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Jumlah Barang</label>
                                    <input type="text" v-model="penjualan.jumlah_barang" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Total Bayar</label>
                                    <input type="text" v-model="penjualan.total_bayar" class="form-control">
                                </div>
                             
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Simpan Data</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        Vue.createApp({
            data() {
                return {
                    penjualan: {
                        penjualan_children: {

                        },
                        penjualan_children_temp : {
                            kode_barang : null,
                            diskon : null,
                            harga_jual : null,
                            jumlah_barang : null,
                            total_bayar : null,
                        },
                        dpp: 0,
                        ppn: 0,
                        total: 0,
                        nomor_faktur: null,
                    },
                    kode_barang_list :[],

                    validation: {
                        nomor_faktur: {
                            message: "Nomor Faktur sudah ada di database!",
                            is_error: false,
                        }
                    },
                    sumber_transaksi_list: [{
                            value: "POS",
                            label: "Point Of Sales",
                        },
                        {
                            value: "MARKETPLACE",
                            label: "Marketplace",
                        }
                    ]

                }
            },
            watch : {
                "penjualan.kode_barang" : function(){

                }
            },
            created()  {
                this.fetchKodeBarang()
            },
            methods: {
              
                async fetchKodeBarang(){
                    try {
                        const response = await httpClient.get("{!! url('data-barang/datatable') !!}", {
                            kode_barang: this.penjualan.penjualan_children_temp.kode_barang,
                            page : 15,
                        })
                        console.log(response.data)
                        this.kode_barang_list = [
                        ...this.kode_barang_list,
                        ...response.data.result.data.map(el => {
                            return {
                                value: el.kode_barang,
                                label: `${el.kode_barang} - ${el.nama_barang}`
                            }
                        })
                    ]
                        this.validation.nomor_faktur.is_error = response.data.result.is_error
                    } catch (err) {
                        showToast({
                            message: err.message,
                            type: 'error'
                        })
                    }
                },
                handleAddDataBarang() {
                    $('#addDataBarang').modal()
                },
                back() {
                    history.back()
                },
                validate(data) {
                    if (data.is_error == true) {
                        return "has-feedback has-error";
                    }
                    return "";
                },

                async checkNomorFaktur(event) {
                    const nomor = this.penjualan.nomor_faktur
                    if (nomor.length < 4) return;
                    try {
                        const response = await httpClient.post("{!! url('penjualan/check-nomor-faktur') !!}", {
                            nomor_faktur: nomor
                        })
                        console.log(response)
                        this.validation.nomor_faktur.is_error = response.data.result.is_error
                    } catch (err) {
                        showToast({
                            message: err.message,
                            type: 'error'
                        })
                    }
                },
                resetForm() {
                    this.penjualan = {}
                    this.$refs.penjualan_form.reset()
                },
                async store() {
                    try {
                        showLoading()
                        const response = await httpClient.post("{!! url('penjualan') !!}", this.penjualan)
                        hideLoading()
                        showToast({
                            message: "Data berhasil ditambahkan"
                        })
                        this.resetForm()
                    } catch (err) {
                        hideLoading()
                        showToast({
                            message: err.message,
                            type: 'error'
                        })
                    }
                }
            },
            components: {
                'vue-multiselect': VueformMultiselect,
                'vue-datepicker': VueDatePicker,
            },
        }).mount("#add-penjualan")
    </script>
@endsection
