@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner">
        <div id="add-input-scm" class="card">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Edit Barang Milik {!! $umkm->nama !!}</h4>
                </div>
            </div>
            <div class="card-body">
                <form ref="barang_scm_form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Nama Barang</label>
                                <input v-model="barang_scm.nama" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Tipe Barang</label>
                                <vue-multiselect v-model="barang_scm.tipe_barang" :searchable="true"
                                    :options="tipe_barang_list" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Jenis Barang</label>
                                <vue-multiselect v-model="barang_scm.jenis_barang" :searchable="true"
                                    :options="jenis_barang_list" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Perizinan Industri Rumah Tangga</label>
                                <vue-multiselect v-model="barang_scm.pirt" :searchable="true" :options="pirt_list" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Sertifikasi Halal</label>
                                <vue-multiselect v-model="barang_scm.sertifikasi_halal" :searchable="true"
                                    :options="sertifikasi_halal_list" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Kategori Daya Tahan Barang</label>
                                <vue-multiselect v-model="barang_scm.kategori_daya_tahan_barang" :searchable="true"
                                    :options="kategori_daya_tahan_barang_list" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label v-if="switcher.barang_produksi" class="form-control-label">Periode Produksi
                                    Barang</label>
                                <label v-if="!switcher.barang_produksi" class="form-control-label">Periode Pembelian
                                    Barang</label>
                                <vue-multiselect v-model="barang_scm.periode_barang" :searchable="true"
                                    :options="periode_barang_list" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Ukuran Kemasan Penjualan</label>
                                <vue-multiselect v-model="barang_scm.ukuran_kemasan" :searchable="true"
                                    :options="ukuran_kemasan_list" :multiple="true" mode="tags" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label v-if="switcher.barang_produksi" class="form-control-label">Rata Rata Volume
                                    Produksi</label>
                                <label v-if="!switcher.barang_produksi" class="form-control-label">Rata Rata Volume
                                    Pembelian</label>
                                <div class="row">
                                    <div class="col-md-9">
                                        <input v-model="barang_scm.jumlah_volume_produksi" class="form-control"
                                            type="text">
                                    </div>
                                    <div class="col-md-3">
                                        <vue-multiselect v-model="barang_scm.jenis_volume_produksi" :searchable="true"
                                            :options="jenis_volume_produksi_list" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label v-if="switcher.barang_produksi" class="form-control-label">Rata Rata Penjualan Per
                                    Periode Produksi</label>
                                <label v-if="!switcher.barang_produksi" class="form-control-label">Rata Rata Penjualan Per
                                    Periode Pembelian</label>
                                <div class="row">
                                    <div class="col-md-9">
                                        <input v-model="barang_scm.jumlah_rata2_penjualan" class="form-control"
                                            type="text">
                                    </div>
                                    <div class="col-md-3">
                                        <vue-multiselect v-model="barang_scm.jenis_rata2_penjualan" :searchable="true"
                                            :options="jenis_rata2_penjualan_list" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Jenis Kemasan</label>
                                <vue-multiselect v-model="barang_scm.jenis_kemasan" :searchable="true"
                                    :options="jenis_kemasan_list" />
                            </div>
                            <div class="form-group">
                                <input v-if="switcher.jenis_kemasan" v-model="barang_scm.jenis_kemasan_lainnya"
                                    class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Perlakuan Barang Yang Tidak Laku</label>
                                <vue-multiselect v-model="barang_scm.perlakuan_barang_tidak_laku" :searchable="true"
                                    :options="perlakuan_barang_tidak_laku_list" />
                            </div>
                            <div class="form-group" v-if="switcher.perlakuan_barang_tidak_laku">
                                <input v-model="barang_scm.perlakuan_barang_tidak_laku_lainnya" class="form-control"
                                    type="text">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Barang Dijual Di</label>
                                <vue-multiselect v-model="barang_scm.tempat_barang_dijual" :searchable="true"
                                    :options="tempat_barang_dijual_list" :multiple="true" mode="tags" />

                            </div>
                            <div class="form-group">
                                <vue-multiselect v-if="switcher.tempat_barang_dijual"
                                    v-model="barang_scm.detail_tempat_barang_dijual" :multiple="true"
                                    :options="detail_tempat_barang_dijual_list" mode="tags" />

                            </div>
                        </div>

                        {{-- End Form --}}
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
                    barang_scm: {
                        detail_tempat_barang_dijual: [],
                        tipe_barang: "PRODUKSI",
                        sertifikasi_halal : "1",
                        tempat_barang_dijual : null,
                    },
                    switcher: {
                        tempat_barang_dijual: false,
                        barang_produksi: false,
                        perlakuan_barang_tidak_laku: false,
                    },
                    tipe_barang_list: [{
                            value: "PRODUKSI",
                            label: "Produksi"
                        },
                        {
                            value: "LABELING",
                            label: "Labeling"
                        },

                    ],
                    jenis_barang_list: [{
                            value: "BASAH",
                            label: "Basah"
                        },
                        {
                            value: "KERING",
                            label: "Kering"
                        },
                    ],
                    pirt_list: [{
                            value: "1",
                            label: "Sudah"
                        },
                        {
                            value: "0",
                            label: "Belum"
                        },
                    ],
                    sertifikasi_halal_list: [{
                            value: "1",
                            label: "Sudah"
                        },
                        {
                            value: "0",
                            label: "Belum"
                        },
                    ],
                    kategori_daya_tahan_barang_list: [{
                            value: "< 2 hari",
                            label: "< 2 hari"
                        },
                        {
                            value: "< 1 Minggu",
                            label: "< 1 Minggu"
                        },
                        {
                            value: "2 Minggu > 4 Minggu",
                            label: "2 Minggu > 4 Minggu"
                        },
                        {
                            value: "1 - 3 Bulan",
                            label: "1 - 3 Bulan"
                        },
                        {
                            value: "> 3 Bulan",
                            label: "> 3 Bulan"
                        },
                    ],
                    periode_barang_list: [{
                            value: "Harian",
                            label: "Harian"
                        },
                        {
                            value: "Mingguan",
                            label: "Mingguan"
                        },
                        {
                            value: "Bulanan",
                            label: "Bulanan"
                        },
                        {
                            value: "Insidential",
                            label: "Insidential"
                        },
                    ],
                    jenis_volume_produksi_list: [{
                            value: "Gram",
                            label: "Gram"
                        },
                        {
                            value: "KG",
                            label: "Kilogram"
                        },
                        {
                            value: "Kuintal",
                            label: "Kuintal"
                        },
                        {
                            value: "Ton",
                            label: "Ton"
                        },
                    ],
                    jenis_rata2_penjualan_list: [{
                            value: "Gram",
                            label: "Gram"
                        },
                        {
                            value: "KG",
                            label: "Kilogram"
                        },
                        {
                            value: "Kuintal",
                            label: "Kuintal"
                        },
                        {
                            value: "Ton",
                            label: "Ton"
                        },
                    ],
                    perlakuan_barang_tidak_laku_list: [{
                            value: "Diolah Kembali",
                            label: "Diolah Kembali"
                        },
                        {
                            value: "Dijual dengan Diskon",
                            label: "Dijual dengan Diskon"
                        },
                        {
                            value: "Dibuang",
                            label: "Dibuang"
                        },
                        {
                            value: "Dimusnahkan",
                            label: "Dimusnahkan"
                        },
                        {
                            value: "LAINNYA",
                            label: "Lainnya"
                        },
                    ],
                    jenis_kemasan_list: [{
                            value: "Kardus",
                            label: "Kardus"
                        },
                        {
                            value: "Plastik",
                            label: "Plastik"
                        },
                        {
                            value: "Vakum",
                            label: "Vakum"
                        },
                        {
                            value: "Besek",
                            label: "Besek"
                        },
                        {
                            value: "LAINNYA",
                            label: "Lainnya"
                        },
                    ],
                    ukuran_kemasan_list: [{
                            value: "Curah",
                            label: "Curah"
                        },
                        {
                            value: "Satuan",
                            label: "Satuan"
                        },
                    ],
                    tempat_barang_dijual_list: [{
                            value: "Outlet Sendiri",
                            label: "Outlet Sendiri"
                        },
                        {
                            value: "Outlet Lain / Parallel",
                            label: "Outlet Lain / Parallel"
                        },
                        {
                            value: "Online",
                            label: "Online / Marketplace"
                        },
                    ],
                    detail_tempat_barang_dijual_list: [{
                            value: "Shopee",
                            label: "Shopee"
                        },
                        {
                            value: "Tokopedia",
                            label: "Tokopedia"
                        },
                        {
                            value: "Lazada",
                            label: "Lazada"
                        },
                        {
                            value: "Blibli",
                            label: "Blibli"
                        },
                        {
                            value: "Bukalapak",
                            label: "Bukalapak"
                        },
                        {
                            value: "Media Sosial",
                            label: "Media Sosial"
                        },
                        {
                            value: "Online Shop Sendiri",
                            label: "Online Shop Sendiri"
                        },
                    ],
                }
            },
            async created() {
            await this.fetchData()
        },
            watch: {
                "barang_scm.tempat_barang_dijual": {
                    handler: function(value) {
                        this.switcher.tempat_barang_dijual = this.barang_scm.tempat_barang_dijual.includes(
                            "Online");
                    }
                },
                "switcher.tempat_barang_dijual": {
                    handler: function(value) {
                        if (this.switcher.tempat_barang_dijual == false)
                            this.barang_scm.detail_tempat_barang_dijual = null
                    }
                },
                "barang_scm.jenis_kemasan": {
                    handler: function(value) {
                        this.switcher.jenis_kemasan = this.barang_scm.jenis_kemasan === "LAINNYA";
                    }
                },

                "barang_scm.perlakuan_barang_tidak_laku": {
                    handler: function(value) {
                        this.switcher.perlakuan_barang_tidak_laku = this.barang_scm
                            .perlakuan_barang_tidak_laku === "LAINNYA";
                    }
                },
                "barang_scm.tipe_barang": {
                    handler: function(value) {
                        this.switcher.barang_produksi = this.barang_scm.tipe_barang === "PRODUKSI";     
                        if (this.switcher.barang_produksi) {
                            this.perlakuan_barang_tidak_laku_list = this.perlakuan_barang_tidak_laku_list
                                .filter(item => item.value !== "Dikembalikan")
                        } else {
                            this.perlakuan_barang_tidak_laku_list.push({
                                value: "Dikembalikan",
                                label: "Dikembalikan"
                            })
                        }
                    }
                }
            },
            methods: {
                async fetchData(){
                const response = await httpClient.post("{!! url()->current() !!}/")
                this.barang_scm = response.data.result
                console.log(this.barang_scm)
                },
                back() {
                    history.back()
                },
                resetForm() {
                    this.$refs.barang_scm_form.reset()
                },
                async store() {
                    try {
                        showLoading()
                        const response = await httpClient.post("{!! url($urlnow) !!}", this.barang_scm)
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
                'Multiselect': VueformMultiselect
            },
        }).mount("#add-input-scm")
    </script>
@endsection
