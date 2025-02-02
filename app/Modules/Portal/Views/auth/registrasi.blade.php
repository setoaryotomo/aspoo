<?php $hideHeaderFooter = true; ?>
@extends('portal_layout.templates')
@section('content')
    @php
        $hideHeaderFooter = true; // Atur nilai $hideHeaderFooter menjadi true
    @endphp
    <style>
        /* Add the Poppins font */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        body {
            font-family: 'Poppins';
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-plain {
                margin: 50px 0 0 0;
            }

            .col-md-6 {
                margin-top: 15px;
            }

            img {
                max-width: 100%;
                height: auto;
            }
        }
    </style>

    <main id="registrasi-page" class="main-content mt-0" style="background: #FBD9C0;">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div style="display: flex; justify-content: center;">
                            <div class="card card-plain"
                                style="max-width: 1100px; border-radius: 30px; margin: 92px 0 92px 15px;">
                                <div class="row">
                                    <div class="col-md-12" style="text-align: center; margin-top: 20px;">
                                        <img src="../img/portal/logo.png" width="160" height="100" />
                                    </div>
                                    <div class="col-md-6"
                                        style="display: flex; align-items: center; justify-content: center; margin-top: 20px;">
                                        <div style="text-align: center;">
                                            <img src="{{ URL::asset('/img/portal/registrasi_logo.png') }}" width="520"
                                                height="600" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div style="padding: 20px;">
                                            <h1 style="text-align: center; font-weight: bold; color: rgba(0, 0, 0, 0.90); ">
                                                Register</h1>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Nama</label>
                                                        <input type="text" class="form-control" v-model="user.nama">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Email</label>
                                                        <input type="text" class="form-control" v-model="user.email">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Password</label>
                                                        <input type="password" class="form-control" v-model="user.password">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Tanggal Lahir</label>
                                                        <input type="date" class="form-control"
                                                            v-model="user.tanggal_lahir">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Alamat</label>
                                                        <input type="text" class="form-control" v-model="user.alamat">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label"> Role</label>
                                                        <vue-multiselect v-model="user.role_id" :options="role_list"
                                                            class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-md-12" v-if="showDetails">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Provinsi</label>
                                                                <vue-multiselect v-model="user.provinsi_id"
                                                                    :searchable="true" :options="provinsi_list" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Kota</label>
                                                                <vue-multiselect v-model="user.kota_id" :searchable="true"
                                                                    :options="kota_list" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Kecamatan</label>
                                                                <vue-multiselect v-model="user.kecamatan_id"
                                                                    :searchable="true" :options="kecamatan_list" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Kelurahan</label>
                                                                <vue-multiselect v-model="user.kelurahan_id"
                                                                    :searchable="true" :options="kelurahan_list" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="text-center mt-3">
                                                    <button @click="register" type="button"
                                                        class="btn btn-lg w-100 mt-4 mb-0"
                                                        style="background-color: #606C5D; color: white; font-weight: bold; border-radius: 15px;">Register</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </main>
    <script>
        createApp({
            data() {
                return {
                    showDetails: false,
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
                    user: {
                        role_id: 2,
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
                "user.role_id" : {
                    handler: function(value){
                        if(value != 2){
                            this.showDetails = true
                        }else{
                            this.showDetails = false
                        }
                    }
                },
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
                async register() {
                    try {
                        showLoading();
                      
                        const response = await httpClient.post('/p/registrasi',this.user);
                        if (response.data.code == "SUCCESS") {
                            showToast({
                                message: "User berhasil ditambahkan"
                            });
                            location.href = '/p/login';
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
        }).mount('#registrasi-page');
    </script>
@endsection
