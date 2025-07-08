@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner">
        <div id="add-user" class="card">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Tambah Toko</h4>
                </div>
            </div>
            <div class="card-body">
                <form ref="user_form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" v-model="user.nama">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Nama Toko</label>
                                <input type="text" class="form-control" v-model="user.nama_toko">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control" v-model="user.email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" v-model="user.password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" v-model="user.tanggal_lahir">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="number" class="form-control" v-model="user.telepon">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Ijin Usaha</label>
                                {{-- <label class="control-label">Jenis Ijin Usaha</label> --}}
                                <vue-multiselect v-model="user.ijin_usaha" :searchable="true" :options="ijin_usaha_list" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Omset</label>
                                <vue-multiselect v-model="user.omset" :searchable="true" :options="omset_list" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">NPWP</label>
                                <input type="text" class="form-control" v-model="user.npwp">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Alamat</label>
                                <input type="text" class="form-control" v-model="user.alamat">
                            </div>
                        </div>
                        
                        <div class="col-md-6" style="display: none">
                            <div class="form-group">
                                <label class="form-label"> Role</label>
                                <vue-multiselect v-model="user.role_id" :options="role_list" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-12" v-if="showDetails">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Provinsi</label>
                                        <vue-multiselect v-model="user.provinsi_id" :searchable="true"
                                            :options="provinsi_list" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Kota</label>
                                        <vue-multiselect v-model="user.kota_id" :searchable="true"
                                            :options="kota_list" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Kecamatan</label>
                                        <vue-multiselect v-model="user.kecamatan_id" :searchable="true"
                                            :options="kecamatan_list" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Kelurahan</label>
                                        <vue-multiselect v-model="user.kelurahan_id" :searchable="true"
                                            :options="kelurahan_list" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Alamat</label>
                                <input type="text" class="form-control" v-model="user.alamat">
                            </div>
                        </div> --}}

                        <div class="d-flex justify-content-end">
                            <button type="button" @click="back" class="btn btn-sm bg-warning me-1 text-white">
                                Cancel
                            </button>
                            <button type="button" @click="register" class="btn btn-sm bg-primary me-1 text-white">
                                Save Data
                            </button>
                        </div>
                        {{-- <div class="text-center mt-3">
                            <button @click="register" type="button" class="btn btn-lg w-100 mt-4 mb-0"
                                style="background-color: #606C5D; color: white; font-weight: bold; border-radius: 15px;">Register</button>
                        </div> --}}
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    <script>
        createApp({
            data() {
                return {
                    showDetails: true,
                    role_list: [{
                            value: 2,
                            label: "Konsumen"
                        },
                        {
                            value: 3,
                            label: "UMKM"
                        },
                        {
                            value: 4,
                            label: "Mitra"
                        },
                    ],
                    ijin_usaha_list: [{
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
                            value: "-",
                            label: "-"
                        },
                    ],
                    omset_list: [{
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
                    user: {
                        role_id: 3,
                    },
                    provinsi_list: [],
                    kota_list: [],
                    kecamatan_list: [],
                    kelurahan_list: [],
                };
            },
            created() {
                this.fetchProvinsiList()

            },
            watch: {
                // "user.role_id": {
                //     handler: function(value) {
                //         if (value != 2) {
                //             this.showDetails = true
                //         } else {
                //             this.showDetails = true
                //         }
                //     }
                // },
                "user.provinsi_id": {
                    handler: function(value) {
                        this.fetchKotaList(this.user.provinsi_id)

                    }
                },
                "user.kota_id": {
                    handler: function(value) {
                        this.fetchKecamatanList(this.user.kota_id)

                    }
                },
                "user.kecamatan_id": {
                    handler: function(value) {
                        this.fetchKelurahanList(this.user.kecamatan_id)
                    }
                },
            },
            methods: {
                back() {
                history.back()
                },
                async register() {
                    try {
                        showLoading();

                        const response = await httpClient.post('/p/registrasi', this.user);
                        if (response.data.code == "SUCCESS") {
                            showToast({
                                message: "User berhasil ditambahkan"
                            });
                            location.href = '/mastertoko';
                        }
                        hideLoading();
                    } catch (err) {
                        hideLoading();
                        showToast({
                            message: err.message,
                            type: 'warning'
                        });
                    }
                },
                async fetchKotaList(id_provinsi) {
                    const response = await httpClient.get("{!! url('input-scm/alamat/kota') !!}/" + id_provinsi)
                    this.kota_list = [
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
                        ...response.data.result.map(el => {
                            return {
                                value: el.id,
                                label: el.name
                            }
                        })
                    ]
                },
            },
            components: {
                'vue-multiselect': VueformMultiselect
            },
        }).mount('#add-user');
    </script>
@endsection
