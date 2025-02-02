@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner" id="add-supplier">
        <div class="modal fade" tabindex="-1" role="dialog" id="modalSupplier" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" style="min-width: 90%">
                <div class="modal-content">
                    <default-datatable title="Data Supplier " url="{!! url('komposisi/supplier') !!}" :headers="headers"
                        :can-add="false" :can-edit="false" :can-delete="false">
                        <template #left-action="{ content }">
                            <button class="btn btn-xs btn-info mr-1" data-dismiss="modal"
                                @click="saveSupplier(content.id)">Pilih Supplier</button>
                        </template>
                    </default-datatable>
                </div>
            </div>
        </div>

        <div class="card">

            <div class="card-header">
                <div class="card-head-row justify-content-between">
                    <h4 class="card-title">Tambah Supplier</h4>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalSupplier">Cari Supplier</button>
                </div>
            </div>
            <div class="card-body">
                <form ref="supplier_form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Nama Supplier</label>
                                <input type="text" v-model="supplier.nama" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label">Alamat</label>
                                <input type="text" v-model="supplier.alamat" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label">Provinsi</label>
                                <vue-multiselect v-model="supplier.id_provinsi" :searchable="true"
                                    :options="provinsi_list" />
                            </div>
                        </div>
                        <div class="col-md-12" v-if="this.provinsi_list.length > 0">
                            <div class="form-group">
                                <label class="form-control-label">Kota</label>
                                <vue-multiselect v-model="supplier.id_kota" :searchable="true" :options="kota_list" />
                            </div>
                        </div>
                        <div class="col-md-12" v-if="this.kecamatan_list.length > 0">
                            <div class="form-group">
                                <label class="form-control-label">Kecamatan</label>
                                <vue-multiselect v-model="supplier.id_kecamatan" :searchable="true"
                                    :options="kecamatan_list" />
                            </div>
                        </div>
                        <div class="col-md-12" v-if="this.kelurahan_list.length > 0">
                            <div class="form-group">
                                <label class="form-control-label">Kelurahan</label>
                                <vue-multiselect v-model="supplier.id_kelurahan" :searchable="true"
                                    :options="kelurahan_list" />
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
                    supplier: {
                        id_provinsi: null,
                        id_kota: null,
                        id_kecamatan: null,
                        id_kelurahan: null,
                    },
                    provinsi_list: [],
                    kota_list: [],
                    kecamatan_list: [],
                    kelurahan_list: [],
                    headers: [{
                            text: 'Nama',
                            value: 'nama',
                        },
                        {
                            text: 'Alamat',
                            value: 'alamat',
                        },
                        {
                            text: 'Provinsi',
                            value: 'provinsi.name',
                        },
                        {
                            text: 'Kota',
                            value: 'kota.name',
                        },
                        {
                            text: 'Kecamatan',
                            value: 'kecamatan.name',
                        },
                        {
                            text: 'Kelurahan',
                            value: 'kelurahan.name',
                        },
                    ],
                }
            },
            created() {
                this.fetchProvinsiList()
            },
            watch: {
                "supplier.id_provinsi": {
                    handler: function(value) {
                        this.fetchKotaList()
                    },
                    deep: true,
                },
                "supplier.id_kota": {
                    handler: function(value) {
                        this.fetchKecamatanList()
                    },
                    deep: true,
                },
                "supplier.id_kecamatan": {
                    handler: function(value) {
                        this.fetchKelurahanList()
                    },
                    deep: true,
                },
            },
            methods: {
                back() {
                    history.back()
                },
                async fetchProvinsiList() {
                    const response = await httpClient.get("{!! url('komposisi/alamat/provinsi') !!}")
                    this.provinsi_list = [
                        ...response.data.result.map(el => {
                            return {
                                value: el.id,
                                label: el.name
                            }
                        })
                    ]
                },
                async fetchKotaList() {
                    const response = await httpClient.get("{!! url('komposisi/alamat/kota') . '/' !!}" + this.supplier.id_provinsi)
                    this.kota_list = [
                        ...response.data.result.map(el => {
                            return {
                                value: el.id,
                                label: el.name
                            }
                        })
                    ]
                },
                async fetchKecamatanList() {
                    const response = await httpClient.get("{!! url('komposisi/alamat/kecamatan') . '/' !!}" + this.supplier.id_kota)
                    this.kecamatan_list = [
                        ...response.data.result.map(el => {
                            return {
                                value: el.id,
                                label: el.name
                            }
                        })
                    ]
                },
                async fetchKelurahanList() {
                    const response = await httpClient.get("{!! url('komposisi/alamat/kelurahan') . '/' !!}" + this.supplier
                        .id_kecamatan)
                    this.kelurahan_list = [
                        ...response.data.result.map(el => {
                            return {
                                value: el.id,
                                label: el.name
                            }
                        })
                    ]
                },
                async saveSupplier(id) {
                    var data = {
                        id_supplier : id,
                        is_from_id : true,
                    }
                    try {
                        showLoading()
                        const response = await httpClient.post("{!! url()->current() !!}", data)
                        hideLoading()
                        showToast({
                            message: "Data berhasil ditambahkan"
                        })
                        this.back()
                    } catch (err) {
                        hideLoading()
                        showToast({
                            message: err.message,
                            type: 'error'
                        })
                    }
                },

                async store() {
                    try {
                        showLoading()
                        const response = await httpClient.post("{!! url()->current() !!}", this.supplier)
                        hideLoading()
                        showToast({
                            message: "Data berhasil ditambahkan"
                        })
                        this.back()
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
                ...commonComponentMap(
                    [
                        'DefaultDatatable',
                    ]
                )
            },
        }).mount("#add-supplier")
    </script>
@endsection
