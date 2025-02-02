@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner">
        <div id="add-data-barang" class="card">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Tambah DataBarang</h4>
                </div>
            </div>
            <div class="card-body">
                <form ref="data_barang_form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label">Foto Produk</label>
                                <input v-model="barang.foto" class="form-control" type="file" @change="handleFileChange">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Nama Barang</label>
                                <input v-model="barang.nama_barang" class="form-control" type="text">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Harga Supplier</label>
                                <input v-model="barang.harga_supplier" class="form-control" type="number">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Harga Umum</label>
                                <input v-model="barang.harga_umum" class="form-control" type="number">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Diskon</label>
                                <input v-model="barang.diskon" class="form-control" type="number">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Keterangan</label>
                                <textarea class="form-control" v-model="barang.keterangan" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Info Penting</label>
                                <textarea class="form-control" v-model="barang.info_penting" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Expired</label>
                                <input v-model="barang.expired" class="form-control" type="text">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Stok</label>
                                <input v-model="barang.stock_global" class="form-control" type="number">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Berat (dalam gram)</label>
                                <input v-model="barang.berat" class="form-control" type="text">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Satuan</label>
                                <vue-multiselect v-model="barang.satuan_id" :searchable="true" :options="satuan_list" />
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Panjang (cm)</label>
                                <input v-model="barang.panjang" class="form-control" type="number">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Lebar (cm)</label>
                                <input v-model="barang.lebar" class="form-control" type="number">
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Tinggi (cm)</label>
                                <input v-model="barang.tinggi" class="form-control" type="number">
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
    <script>
        Vue.createApp({
            data() {
                return {
                    barang: {
                        satuan_id: null,
                        berat: null,
                    },
                    satuan_list: [],
                    path: null,
                    name: null,


                }
            },

            created() {
                this.fetchSatuanList()
            },
            watch: {
                "barang.satuan_id": {
                    handler: function(value) {
                        let satuan_data = this.satuan_list.find(satuan_item => satuan_item.value == value)
                        this.path = `${satuan_data.label.toLowerCase().split(" ").join("-")}`
                        if (this.name != null && this.name != "") {
                            this.path += `/${this.name.toLowerCase().split(" ").join("-")}`
                        }
                        this.barang.satuan_id = value
                        console.log(this.barang)
                    },
                    deep: true,
                },
            

            },
            methods: {
                handleFileChange(event) {
                    this.barang.foto = event.target.files[0];
                },
                async fetchSatuanList() {
                    const response = await httpClient.get("{!! url('satuan/all') !!}")
                    this.satuan_list = [
                        ...this.satuan_list,
                        ...response.data.result.map(el => {
                            return {
                                value: el.id,
                                label: el.satuan_nama
                            }
                        })
                    ]
                },
                back() {
                    history.back()
                },
                resetForm() {
                    this.barang = {}
                    this.$refs.data_barang_form.reset()
                },
                async store() {
                    const barangFormData = new FormData()
                    Object.keys(this.barang).forEach(key => {
                        barangFormData.append(key, this.barang[key])
                    });

                    try {
                        showLoading()
                        const response = await httpClient.post("{!! url('data-barang') !!}", barangFormData)
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
                'vue-multiselect': VueformMultiselect
            },
        }).mount("#add-data-barang")
    </script>
@endsection
