@extends('dashboard_layout.index')
@section('content')
<div class="page-inner">
    <div id="add-input-scm" class="card">
        <div class="card-header pb-0">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Tambah UMKM</h4>
            </div>
        </div>
        <div class="card-body">
            <form ref="input_scm_form" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Nama UMKM</label>
                            <input v-model="input_scm.nama" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Tahun Berdiri</label>
                            <input v-model="input_scm.tahun_berdiri" class="form-control" type="number">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Provinsi</label>
                            <vue-multiselect v-model="input_scm.provinsi" :searchable="true"
                                :options="provinsi_list" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Kota</label>
                            <vue-multiselect v-model="input_scm.kota" :searchable="true" :options="kota_list" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Kecamatan</label>
                            <vue-multiselect v-model="input_scm.kecamatan" :searchable="true"
                                :options="kecamatan_list" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Kelurahan</label>
                            <vue-multiselect v-model="input_scm.kelurahan" :searchable="true"
                                :options="kelurahan_list" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Alamat</label>
                            <input v-model="input_scm.alamat" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Jumlah Karyawan</label>
                            <vue-multiselect v-model="input_scm.jumlah_karyawan" :searchable="true"
                                :options="jumlah_karyawan_list" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Jenis Ijin Usaha</label>
                            <vue-multiselect v-model="input_scm.jenis_ijin_usaha" :searchable="true"
                                :options="jenis_ijin_usaha_list" />
                        </div>
                        <div class="form-group" v-if="switcher.jenis_ijin_usaha">
                            <input  v-model="input_scm.ket_jenis_ijin"
                            class="form-control" type="text" placeholder="Keterangan Lainnya">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Omset Per Bulan</label>
                            <vue-multiselect v-model="input_scm.omset_per_bulan" :searchable="true"
                                :options="omset_per_bulan_list" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Permodalan</label>
                            <vue-multiselect v-model="input_scm.permodalan" :searchable="true"
                                :options="permodalan_list" />
                        </div>
                        <div class="form-group" v-if="switcher.permodalan">
                            <input v-if="switcher.permodalan" placeholder="Keterangan Lainnya" v-model="input_scm.ket_permodalan" class="form-control"
                            type="text">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Legalitas</label>
                            <input v-model="input_scm.legalitas" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Kategori Usaha</label>
                            <vue-multiselect v-model="input_scm.kategori_usaha" :searchable="true"
                                :options="kategori_usaha_list" />
                          
                        </div>
                        <div class="form-group" v-if="switcher.kategori_usaha">
                            <input  v-model="input_scm.ket_ket_kategori_usaha"
                            class="form-control" type="text" placeholder="Keterangan lainnya">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Transaksi Lokal</label>
                            <vue-multiselect v-model="input_scm.transaksi_lokal" :searchable="true"
                            :options="transaksi_list" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Transaksi Titipan</label>
                            <vue-multiselect v-model="input_scm.transaksi_titipan" :searchable="true"
                            :options="transaksi_list" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Area Penjualan</label>
                            <input v-model="input_scm.area_penjualan" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Jumlah Gerai</label>
                            <input v-model="input_scm.jumlah_gerai" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Rekaman Wawancara</label>
                            <input  @change="handleFileChange" class="form-control" type="file">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-control-label">Keterangan Voice Text</label>
                            <textarea class="form-control" rows="5" v-model="input_scm.voice_text"></textarea>
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
                input_scm: {
                    provinsi: null,
                    kecamatan: null,
                    kota: null,
                    kelurahan: null,
                    jenis_ijin_usaha: null,
                    permodalan: null,
                    kategori_usaha: null,
                    voice_file : null,
                },
                switcher: {
                    jenis_ijin_usaha: false,
                    permodalan: false,
                    kategori_usaha: false,
                },
                provinsi_list: [],
                kota_list: [],
                kecamatan_list: [],
                kelurahan_list: [],
                transaksi_list : [{
                        value: "1",
                        label: "Ya"
                    },
                    {
                        value: "0",
                        label: "Tidak"
                    },],
                jumlah_karyawan_list: [{
                        value: "0>10",
                        label: "0 sampai 10"
                    },
                    {
                        value: "11>50",
                        label: "11 sampai 50"
                    },
                    {
                        value: ">51",
                        label: "Lebih dari 51"
                    },

                ],
                jenis_ijin_usaha_list: [{
                        value: "BELUM_BERIJIN",
                        label: "Belum Berijin"
                    },
                    {
                        value: "CV",
                        label: "CV"
                    },
                    {
                        value: "PERSEORANGAN",
                        label: "Perseorangan"
                    },
                    {
                        value: "PT",
                        label: "PT"
                    },
                    {
                        value: "UD",
                        label: "UD"
                    },
                    {
                        value: "LAINNYA",
                        label: "Lainnya"
                    },
                ],
                omset_per_bulan_list: [{
                        value: "<10jt",
                        label: "Kurang dari 10 juta"
                    },
                    {
                        value: "10-50jt",
                        label: "10 sampai 50 juta"
                    },
                    {
                        value: "50-150jt",
                        label: "50 sampai 150 juta"
                    },
                    {
                        value: ">150jt",
                        label: "Lebih dari 150 juta"
                    },
                ],
                permodalan_list: [{
                        value: "PRIBADI",
                        label: "Pribadi"
                    },
                    {
                        value: "PERBANKAN",
                        label: "Perbankan"
                    },
                    {
                        value: "LAINNYA",
                        label: "Lainnya"
                    },
                ],
                kategori_usaha_list: [{
                        value: "USAHA_KELUARGA",
                        label: "Usaha Keluarga"
                    },
                    {
                        value: "RINTISAN",
                        label: "Rintisan"
                    },
                    {
                        value: "LAINNYA",
                        label: "Lainnya"
                    },
                ],
            }
        },
        async created() {
            await this.fetchProvinsiList()
            await this.fetchData()
        },
        watch: {
            "input_scm.jenis_ijin_usaha": {
                handler: function(value) {
                    this.switcher.jenis_ijin_usaha = this.input_scm.jenis_ijin_usaha === "LAINNYA";

                }
            },
            "input_scm.permodalan": {
                handler: function(value) {
                    this.switcher.permodalan = this.input_scm.permodalan === "LAINNYA";
                }
            },
            "input_scm.kategori_usaha": {
                handler: function(value) {
                    this.switcher.kategori_usaha = this.input_scm.kategori_usaha === "LAINNYA";
                }
            },
            "input_scm.provinsi": {
                handler: function(value) {
                    this.fetchKotaList(this.input_scm.provinsi)
                }
            },
            "input_scm.kota": {
                handler: function(value) {
                    this.fetchKecamatanList(this.input_scm.kota)
                }
            },
            "input_scm.kecamatan": {
                handler: function(value) {
                    this.fetchKelurahanList(this.input_scm.kecamatan)
                }
            },
        },
        methods: {
            async fetchData(){
                const response = await httpClient.post("{!! url()->current() !!}/")
                this.input_scm = response.data.result
                console.log(this.input_scm)
            },
            handleFileChange(event) {
                this.input_scm.voice_file = event.target.files[0];
                console.log(this.input_scm.voice_file,event.target.files)
            },
            async fetchKotaList(id_provinsi) {
                const response = await httpClient.get("{!! url('input-scm/alamat/kota') !!}/" + id_provinsi)
                this.kota_list = [
                    ...this.kota_list,
                    ...response.data.result.map(el => {
                        return {
                            value: el.id,
                            label: el.name
                        }
                    })
                ]
            },
            async fetchKecamatanList(data) {
                const response = await httpClient.get("{!! url('input-scm/alamat/kecamatan') !!}/" + data)
                this.kecamatan_list = [
                    ...this.kecamatan_list,
                    ...response.data.result.map(el => {
                        return {
                            value: el.id,
                            label: el.name
                        }
                    })
                ]
            },
            async fetchKelurahanList(data) {
                const response = await httpClient.get("{!! url('input-scm/alamat/kelurahan') !!}/" + data)
                this.kelurahan_list = [
                    ...this.kelurahan_list,
                    ...response.data.result.map(el => {
                        return {
                            value: el.id,
                            label: el.name
                        }
                    })
                ]
            },
            async fetchProvinsiList() {
                const response = await httpClient.get("{!! url('input-scm/alamat/provinsi') !!}")
                this.provinsi_list = [
                    ...this.provinsi_list,
                    ...response.data.result.map(el => {
                        return {
                            value: el.id,
                            label: el.name
                        }
                    })
                ]
            },
            back() {
                history.back()
            },
            resetForm() {
                this.input_scm = {}
                this.$refs.input_scm_form.reset()
            },
            async store() {
                const input_scm_form_data = new FormData()
                Object.keys(this.input_scm).forEach(key => {
                    input_scm_form_data.append(key, this.input_scm[key])
                });

                try {
                    showLoading()
                    const response = await httpClient.post("{!! url()->current()  !!}/save", input_scm_form_data)
                    hideLoading()
                    showToast({
                        message: "Data berhasil diedit"
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
            'vue-multiselect': VueformMultiselect
        },
    }).mount("#add-input-scm")
</script>
@endsection