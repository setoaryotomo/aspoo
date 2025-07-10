
@extends('portal_layout.templates')
@section('content')
    {{-- @php
        $hideHeaderFooter = true;
    @endphp --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
        body { font-family: 'Poppins'; }
        
        .registration-container {
            max-width: 600px;
            margin: 30px auto;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        .form-section {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            transition: all 0.3s;
            font-size: 14px;
        }
        
        .form-control:focus {
            border-color: #606C5D;
            box-shadow: 0 0 0 2px rgba(96, 108, 93, 0.2);
        }
        
        .is-invalid { border-color: #dc3545 !important; }
        .error-message { color: #dc3545; font-size: 0.8rem; margin-top: 5px; }
        
        .btn-action {
            background-color: #606C5D;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 14px;
        }
        
        .btn-action:hover { background-color: #4e5a4b; }
        .btn-outline {
            background-color: transparent;
            border: 1px solid #606C5D;
            color: #606C5D;
        }
        .btn-outline:hover {
            background-color: #f0f0f0;
        }
        
        .title {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
            font-weight: 600;
            font-size: 22px;
        }
        
        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }
        
        .step {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #ddd;
            color: #777;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 10px;
            font-weight: 600;
            position: relative;
        }
        
        .step.active {
            background-color: #606C5D;
            color: white;
        }
        
        .step.completed {
            background-color: #8a9d7e;
            color: white;
        }
        
        .step-line {
            height: 2px;
            background-color: #ddd;
            flex-grow: 1;
            margin: auto 0;
            max-width: 50px;
        }
        
        .step-line.active {
            background-color: #606C5D;
        }
        
        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        
        .step-content {
            display: none;
        }
        
        .step-content.active {
            display: block;
            animation: fadeIn 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @media (max-width: 768px) {
            .registration-container {
                margin: 20px 15px;
                padding: 20px;
            }
            
            .step {
                width: 25px;
                height: 25px;
                font-size: 12px;
                margin: 0 5px;
            }
            
            .step-line {
                max-width: 30px;
            }
        }
    </style>

    <main id="registrasi-page" class="main-content">
        <div class="container">
            <div class="registration-container">
                <h4 class="title">Register</h4>
                
                <!-- Step Indicator -->
                <div class="step-indicator">
                    <div class="step" :class="{'active': currentStep === 1, 'completed': currentStep > 1}">1</div>
                    <div class="step-line" :class="{'active': currentStep >= 2}"></div>
                    <div class="step" :class="{'active': currentStep === 2, 'completed': currentStep > 2}">2</div>
                    <div class="step-line" :class="{'active': currentStep >= 3 && showTokoField}"  v-if="showTokoField"></div>
                    <div class="step" :class="{'active': currentStep === 3, 'completed': currentStep > 3}" v-if="showTokoField">3</div>
                </div>
                
                <!-- Step 1: Personal Information -->
                <div class="step-content" :class="{'active': currentStep === 1}">
                    <div class="form-section">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" :class="{'is-invalid': errors.nama}" v-model="user.nama">
                        <span class="error-message" v-if="errors.nama">@{{ errors.nama }}</span>
                    </div>
                    
                    <div class="form-section">
                        <label class="form-label">Role</label>
                        <vue-multiselect v-model="user.role_id" :options="role_list" :class="{'is-invalid': errors.role_id}"/>
                        <span class="error-message" v-if="errors.role_id">@{{ errors.role_id }}</span>
                    </div>
                    
                    <div class="form-section">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" :class="{'is-invalid': errors.email}" v-model="user.email">
                        <span class="error-message" v-if="errors.email">@{{ errors.email }}</span>
                    </div>
                    
                    <div class="form-section">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" :class="{'is-invalid': errors.password}" v-model="user.password">
                        <span class="error-message" v-if="errors.password">@{{ errors.password }}</span>
                    </div>
                    
                    <div class="form-section">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" :class="{'is-invalid': errors.tanggal_lahir}" v-model="user.tanggal_lahir">
                        <span class="error-message" v-if="errors.tanggal_lahir">@{{ errors.tanggal_lahir }}</span>
                    </div>
                    
                    <div class="form-section">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="tel" class="form-control" :class="{'is-invalid': errors.telepon}" v-model="user.telepon">
                        <span class="error-message" v-if="errors.telepon">@{{ errors.telepon }}</span>
                    </div>
                    
                    <div class="action-buttons">
                        <div></div> <!-- Empty div for spacing -->
                        <button @click="validateStep1" type="button" class="btn-action">
                            Selanjutnya
                        </button>
                    </div>
                </div>
                
                <!-- Step 2: Address Information -->
                <div class="step-content" :class="{'active': currentStep === 2}">
                    <div class="form-section">
                        <label class="form-label">Provinsi</label>
                        <vue-multiselect v-model="user.provinsi_id" :searchable="true" :options="provinsi_list" :class="{'is-invalid': errors.provinsi_id}"/>
                        <span class="error-message" v-if="errors.provinsi_id">@{{ errors.provinsi_id }}</span>
                    </div>
                    
                    <div class="form-section">
                        <label class="form-label">Kota</label>
                        <vue-multiselect v-model="user.kota_id" :searchable="true" :options="kota_list" :class="{'is-invalid': errors.kota_id}" :disabled="!user.provinsi_id"/>
                        <span class="error-message" v-if="errors.kota_id">@{{ errors.kota_id }}</span>
                    </div>
                    
                    <div class="form-section">
                        <label class="form-label">Kecamatan</label>
                        <vue-multiselect v-model="user.kecamatan_id" :searchable="true" :options="kecamatan_list" :class="{'is-invalid': errors.kecamatan_id}" :disabled="!user.kota_id"/>
                        <span class="error-message" v-if="errors.kecamatan_id">@{{ errors.kecamatan_id }}</span>
                    </div>
                    
                    <div class="form-section">
                        <label class="form-label">Kelurahan</label>
                        <vue-multiselect v-model="user.kelurahan_id" :searchable="true" :options="kelurahan_list" :class="{'is-invalid': errors.kelurahan_id}" :disabled="!user.kecamatan_id"/>
                        <span class="error-message" v-if="errors.kelurahan_id">@{{ errors.kelurahan_id }}</span>
                    </div>
                    
                    <div class="form-section">
                        <label class="form-label">Alamat</label>
                        <input type="text" class="form-control" :class="{'is-invalid': errors.alamat}" v-model="user.alamat">
                        <span class="error-message" v-if="errors.alamat">@{{ errors.alamat }}</span>
                    </div>
                    
                    <div class="action-buttons">
                        <button @click="prevStep" type="button" class="btn-action btn-outline">
                            Kembali
                        </button>
                        <button @click="validateStep2" type="button" class="btn-action" v-if="!showTokoField">
                            Daftar
                        </button>
                        <button @click="validateStep2" type="button" class="btn-action" v-else>
                            Selanjutnya
                        </button>
                    </div>
                </div>
                
                <!-- Step 3: Toko Information (Conditional) -->
                <div class="step-content" :class="{'active': currentStep === 3}" v-if="showTokoField">
                    <div class="form-section">
                        <label class="form-label">Nama Toko</label>
                        <input type="text" class="form-control" :class="{'is-invalid': errors.nama_toko}" v-model="user.nama_toko">
                        <span class="error-message" v-if="errors.nama_toko">@{{ errors.nama_toko }}</span>
                    </div>
                    <div class="form-section">
                        <label class="form-label">NPWP (isi 0 bila tidak ada)</label>
                        <input type="text" class="form-control" :class="{'is-invalid': errors.npwp}" v-model="user.npwp">
                        <span class="error-message" v-if="errors.npwp">@{{ errors.npwp }}</span>
                    </div>
                    <div class="form-section">
                        <label class="control-label">Jenis Ijin Usaha</label>
                        <vue-multiselect v-model="user.ijin_usaha" :searchable="true"
                            :options="ijin_usaha_list" />
                    </div>
                    <div class="form-section">
                        <label class="control-label">Omset per Bulan</label>
                        <vue-multiselect v-model="user.omset" :searchable="true"
                            :options="omset_list" />
                    </div>
                    
                    <div class="action-buttons">
                        <button @click="prevStep" type="button" class="btn-action btn-outline">
                            Kembali
                        </button>
                        <button @click="register" type="button" class="btn-action">
                            Daftar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        createApp({
            data() {
                return {
                    currentStep: 1,
                    showTokoField: false,
                    role_list: [
                        { value: 2, label: "Konsumen" },
                        { value: 3, label: "UMKM/Toko" },
                        // { value: 4, label: "Mitra" },
                    ],
                    user: {
                        role_id: 2,
                        nama: '',
                        nama_toko: '',
                        email: '',
                        password: '',
                        tanggal_lahir: '',
                        telepon: '',
                        alamat: '',
                        ijin_usaha: '',
                        npwp: '',
                        omset: '',
                        provinsi_id: null,
                        kota_id: null,
                        kecamatan_id: null,
                        kelurahan_id: null
                    },
                    provinsi_list: [],
                    kota_list: [],
                    kecamatan_list: [],
                    kelurahan_list: [],
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
                    errors: {}
                };
            },
            created() {
                this.fetchProvinsiList();
            },
            watch: {
                "user.role_id": {
                    handler: function(value) {
                        this.showTokoField = value == 3 || value == 4;
                    },
                    immediate: true
                },
                "user.provinsi_id": {
                    handler: function(value) {
                        if (value) {
                            this.fetchKotaList(value);
                        } else {
                            this.kota_list = [];
                            this.user.kota_id = null;
                        }
                    }
                },
                "user.kota_id": {
                    handler: function(value) {
                        if (value) {
                            this.fetchKecamatanList(value);
                        } else {
                            this.kecamatan_list = [];
                            this.user.kecamatan_id = null;
                        }
                    }
                },
                "user.kecamatan_id": {
                    handler: function(value) {
                        if (value) {
                            this.fetchKelurahanList(value);
                        } else {
                            this.kelurahan_list = [];
                            this.user.kelurahan_id = null;
                        }
                    }
                },
            },
            methods: {
                nextStep() {
                    this.currentStep++;
                    // Scroll to top after changing step
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                },
                prevStep() {
                    this.currentStep--;
                    // Scroll to top after changing step
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                },
                
                validateStep1() {
                    this.errors = {};
                    let isValid = true;
                    
                    if (!this.user.nama?.trim()) {
                        this.errors.nama = 'Nama harus diisi';
                        isValid = false;
                    }
                    if (!this.user.role_id) {
                        this.errors.role_id = 'Role harus dipilih';
                        isValid = false;
                    }
                    if (!this.user.email?.trim()) {
                        this.errors.email = 'Email harus diisi';
                        isValid = false;
                    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.user.email)) {
                        this.errors.email = 'Format email tidak valid';
                        isValid = false;
                    }
                    if (!this.user.password) {
                        this.errors.password = 'Password harus diisi';
                        isValid = false;
                    } else if (this.user.password.length < 6) {
                        this.errors.password = 'Password minimal 6 karakter';
                        isValid = false;
                    }
                    if (!this.user.tanggal_lahir) {
                        this.errors.tanggal_lahir = 'Tanggal lahir harus diisi';
                        isValid = false;
                    }
                    if (!this.user.telepon?.trim()) {
                        this.errors.telepon = 'Nomor telepon harus diisi';
                        isValid = false;
                    } else if (!/^[0-9]+$/.test(this.user.telepon)) {
                        this.errors.telepon = 'Hanya boleh berisi angka';
                        isValid = false;
                    }
                    
                    if (isValid) {
                        this.nextStep();
                    } else {
                        // Scroll to the first error if validation fails
                        this.$nextTick(() => {
                            const firstError = document.querySelector('.is-invalid');
                            if (firstError) {
                                firstError.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center'
                                });
                            }
                        });
                    }
                },
                
                validateStep2() {
                    this.errors = {};
                    let isValid = true;
                    
                    if (!this.user.provinsi_id) {
                        this.errors.provinsi_id = 'Provinsi harus dipilih';
                        isValid = false;
                    }
                    if (!this.user.kota_id) {
                        this.errors.kota_id = 'Kota harus dipilih';
                        isValid = false;
                    }
                    if (!this.user.kecamatan_id) {
                        this.errors.kecamatan_id = 'Kecamatan harus dipilih';
                        isValid = false;
                    }
                    if (!this.user.kelurahan_id) {
                        this.errors.kelurahan_id = 'Kelurahan harus dipilih';
                        isValid = false;
                    }
                    if (!this.user.alamat?.trim()) {
                        this.errors.alamat = 'Alamat harus diisi';
                        isValid = false;
                    }
                    
                    if (isValid) {
                        if (this.showTokoField) {
                            this.nextStep();
                        } else {
                            this.register();
                        }
                    } else {
                        // Scroll to the first error if validation fails
                        this.$nextTick(() => {
                            const firstError = document.querySelector('.is-invalid');
                            if (firstError) {
                                firstError.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center'
                                });
                            }
                        });
                    }
                },
                
                async register() {
                    if (this.showTokoField && !this.user.nama_toko?.trim()) {
                        this.errors.nama_toko = 'Nama toko harus diisi';
                        return;
                    }
                    if (this.showTokoField && !this.user.npwp?.trim()) {
                        this.errors.npwp = 'NPWP harus diisi';
                        return;
                    }
                    if (this.showTokoField && !this.user.omset?.trim()) {
                        this.errors.omset = 'Omset harus diisi';
                        return;
                    }
                    if (this.showTokoField && !this.user.ijin_usaha?.trim()) {
                        this.errors.ijin_usaha = 'Ijin Usaha harus diisi';
                        return;
                    }
                    
                    try {
                        showLoading();
                        const response = await httpClient.post('/p/registrasi', this.user);
                        
                        if (response.data.code == "SUCCESS") {
                            showToast({ message: "Registrasi berhasil" });
                            location.href = '/p/login';
                        }
                    } catch (err) {
                        if (err.response?.data?.errors) {
                            this.errors = err.response.data.errors;
                            showToast({
                                message: "Terdapat kesalahan pada form",
                                type: 'warning'
                            });
                            
                            // Determine which step to go back to based on errors
                            if (err.response.data.errors.nama_toko) {
                                this.currentStep = 3;
                            } else if (
                                err.response.data.errors.provinsi_id || 
                                err.response.data.errors.kota_id || 
                                err.response.data.errors.kecamatan_id || 
                                err.response.data.errors.kelurahan_id ||
                                err.response.data.errors.alamat
                            ) {
                                this.currentStep = 2;
                            } else {
                                this.currentStep = 1;
                            }
                            
                            // Scroll to the first error
                            this.$nextTick(() => {
                                const firstError = document.querySelector('.is-invalid');
                                if (firstError) {
                                    firstError.scrollIntoView({
                                        behavior: 'smooth',
                                        block: 'center'
                                    });
                                }
                            });
                        } else {
                            showToast({
                                message: err.message || 'Registrasi gagal',
                                type: 'error'
                            });
                        }
                    } finally {
                        hideLoading();
                    }
                },
                
                async fetchProvinsiList() {
                    try {
                        const response = await httpClient.get("{!! url('input-scm/alamat/provinsi') !!}");
                        this.provinsi_list = response.data.result.map(el => ({
                            value: el.id,
                            label: el.name
                        }));
                    } catch (error) {
                        console.error("Failed to fetch provinces:", error);
                        showToast({
                            message: "Gagal memuat data provinsi",
                            type: 'error'
                        });
                    }
                },
                
                async fetchKotaList(provinsiId) {
                    try {
                        const response = await httpClient.get("{!! url('input-scm/alamat/kota') !!}/" + provinsiId);
                        this.kota_list = response.data.result.map(el => ({
                            value: el.id,
                            label: el.name
                        }));
                        this.user.kota_id = null;
                    } catch (error) {
                        console.error("Failed to fetch cities:", error);
                        showToast({
                            message: "Gagal memuat data kota",
                            type: 'error'
                        });
                    }
                },
                
                async fetchKecamatanList(kotaId) {
                    try {
                        const response = await httpClient.get("{!! url('input-scm/alamat/kecamatan') !!}/" + kotaId);
                        this.kecamatan_list = response.data.result.map(el => ({
                            value: el.id,
                            label: el.name
                        }));
                        this.user.kecamatan_id = null;
                    } catch (error) {
                        console.error("Failed to fetch districts:", error);
                        showToast({
                            message: "Gagal memuat data kecamatan",
                            type: 'error'
                        });
                    }
                },
                
                async fetchKelurahanList(kecamatanId) {
                    try {
                        const response = await httpClient.get("{!! url('input-scm/alamat/kelurahan') !!}/" + kecamatanId);
                        this.kelurahan_list = response.data.result.map(el => ({
                            value: el.id,
                            label: el.name
                        }));
                        this.user.kelurahan_id = null;
                    } catch (error) {
                        console.error("Failed to fetch villages:", error);
                        showToast({
                            message: "Gagal memuat data kelurahan",
                            type: 'error'
                        });
                    }
                }
            },
            components: {
                'vue-multiselect': VueformMultiselect
            },
        }).mount('#registrasi-page');
    </script>
@endsection