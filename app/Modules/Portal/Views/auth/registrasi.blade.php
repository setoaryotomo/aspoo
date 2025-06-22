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
        
        /* Error message styling */
        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        
        .is-invalid {
            border-color: #dc3545 !important;
        }
    </style>

    <main id="registrasi-page" class="main-content mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div style="display: flex; justify-content: center;">
                            <div class="card card-plain"
                                style="max-width: 900px; border-radius: 30px; margin: 92px 0 92px 15px;">
                                <div class="row">
                                    <div class="col-md-12" style="text-align: center; margin-top: 20px;">
                                        <img src="../img/portal/logo.png" width="160" height="100" />
                                    </div>

                                    <div class="col-md-8 mx-auto">
                                        <div style="padding: 20px;">
                                            <h5 style="text-align: center; font-weight: bold; color: rgba(0, 0, 0, 0.90); ">
                                                Register</h5>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Nama</label>
                                                        <input type="text" class="form-control" :class="{'is-invalid': errors.nama}" v-model="user.nama">
                                                        <span class="error-message" v-if="errors.nama">@{{ errors.nama }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Email</label>
                                                        <input type="text" class="form-control" :class="{'is-invalid': errors.email}" v-model="user.email">
                                                        <span class="error-message" v-if="errors.email">@{{ errors.email }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Password</label>
                                                        <input type="password" class="form-control" :class="{'is-invalid': errors.password}" v-model="user.password">
                                                        <span class="error-message" v-if="errors.password">@{{ errors.password }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Tanggal Lahir</label>
                                                        <input type="date" class="form-control" :class="{'is-invalid': errors.tanggal_lahir}" v-model="user.tanggal_lahir">
                                                        <span class="error-message" v-if="errors.tanggal_lahir">@{{ errors.tanggal_lahir }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Nomor Telepon</label>
                                                        <input type="text" class="form-control" :class="{'is-invalid': errors.telepon}" v-model="user.telepon">
                                                        <span class="error-message" v-if="errors.telepon">@{{ errors.telepon }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Alamat</label>
                                                        <input type="text" class="form-control" :class="{'is-invalid': errors.alamat}" v-model="user.alamat">
                                                        <span class="error-message" v-if="errors.alamat">@{{ errors.alamat }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-control-label"> Role</label>
                                                        <vue-multiselect v-model="user.role_id" :options="role_list" :class="{'is-invalid': errors.role_id}"/>
                                                        <span class="error-message" v-if="errors.role_id">@{{ errors.role_id }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" v-if="showDetails">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Provinsi</label>
                                                                <vue-multiselect v-model="user.provinsi_id"
                                                                    :searchable="true" :options="provinsi_list" :class="{'is-invalid': errors.provinsi_id}"/>
                                                                <span class="error-message" v-if="errors.provinsi_id">@{{ errors.provinsi_id }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Kota</label>
                                                                <vue-multiselect v-model="user.kota_id" :searchable="true"
                                                                    :options="kota_list" :class="{'is-invalid': errors.kota_id}"/>
                                                                <span class="error-message" v-if="errors.kota_id">@{{ errors.kota_id }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Kecamatan</label>
                                                                <vue-multiselect v-model="user.kecamatan_id"
                                                                    :searchable="true" :options="kecamatan_list" :class="{'is-invalid': errors.kecamatan_id}"/>
                                                                <span class="error-message" v-if="errors.kecamatan_id">@{{ errors.kecamatan_id }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-control-label">Kelurahan</label>
                                                                <vue-multiselect v-model="user.kelurahan_id"
                                                                    :searchable="true" :options="kelurahan_list" :class="{'is-invalid': errors.kelurahan_id}"/>
                                                                <span class="error-message" v-if="errors.kelurahan_id">@{{ errors.kelurahan_id }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="text-center mt-3">
                                                    <button @click="register" type="button"
                                                        class="btn btn-lg w-100 mt-4 mb-0"
                                                        style="background-color: #606C5D; color: white; font-weight: bold; border-radius: 15px;">Register</button>
                                                </div>
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
                    user: {
                        role_id: 2,
                    },
                    provinsi_list: [],
                    kota_list: [],
                    kecamatan_list: [],
                    kelurahan_list: [],
                    errors: {}
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
                            this.showDetails = true
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
                validateForm() {
                    this.errors = {};
                    
                    // Validasi Nama
                    if (!this.user.nama || this.user.nama.trim() === '') {
                        this.errors.nama = 'Nama harus diisi';
                    }
                    
                    // Validasi Email
                    if (!this.user.email || this.user.email.trim() === '') {
                        this.errors.email = 'Email harus diisi';
                    } else if (!this.isValidEmail(this.user.email)) {
                        this.errors.email = 'Format email tidak valid';
                    }
                    
                    // Validasi Password
                    if (!this.user.password || this.user.password.trim() === '') {
                        this.errors.password = 'Password harus diisi';
                    } else if (this.user.password.length < 6) {
                        this.errors.password = 'Password minimal 6 karakter';
                    }
                    
                    // Validasi Tanggal Lahir
                    if (!this.user.tanggal_lahir) {
                        this.errors.tanggal_lahir = 'Tanggal lahir harus diisi';
                    }
                    
                    // Validasi Nomor Telepon
                    if (!this.user.telepon || this.user.telepon.trim() === '') {
                        this.errors.telepon = 'Nomor telepon harus diisi';
                    } else if (!/^[0-9]+$/.test(this.user.telepon)) {
                        this.errors.telepon = 'Nomor telepon hanya boleh berisi angka';
                    }
                    
                    // Validasi Alamat
                    if (!this.user.alamat || this.user.alamat.trim() === '') {
                        this.errors.alamat = 'Alamat harus diisi';
                    }
                    
                    // Validasi Role
                    if (!this.user.role_id) {
                        this.errors.role_id = 'Role harus dipilih';
                    }
                    
                    // Validasi Alamat lengkap jika diperlukan
                    if (this.showDetails) {
                        if (!this.user.provinsi_id) {
                            this.errors.provinsi_id = 'Provinsi harus dipilih';
                        }
                        
                        if (!this.user.kota_id) {
                            this.errors.kota_id = 'Kota harus dipilih';
                        }
                        
                        if (!this.user.kecamatan_id) {
                            this.errors.kecamatan_id = 'Kecamatan harus dipilih';
                        }
                        
                        if (!this.user.kelurahan_id) {
                            this.errors.kelurahan_id = 'Kelurahan harus dipilih';
                        }
                    }
                    
                    return Object.keys(this.errors).length === 0;
                },
                
                isValidEmail(email) {
                    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return re.test(email);
                },
                
                async register() {
                    // Validasi form sebelum submit
                    if (!this.validateForm()) {
                        return;
                    }
                    
                    try {
                        showLoading();
                      
                        const response = await httpClient.post('/p/registrasi', this.user);
                        if (response.data.code == "SUCCESS") {
                            showToast({
                                message: "User berhasil ditambahkan"
                            });
                            location.href = '/p/login';
                        }
                        hideLoading();
                    } catch (err) {
                        hideLoading();
                        
                        // Jika ada error validasi dari server
                        if (err.response && err.response.data.errors) {
                            this.errors = err.response.data.errors;
                            showToast({
                                message: "Terdapat kesalahan pada form, silakan periksa kembali",
                                type: 'warning'
                            });
                        } else {
                            showToast({
                                message: err.message,
                                type: 'warning'
                            });
                        }
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