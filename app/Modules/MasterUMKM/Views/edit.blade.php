@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner">
        <div id="add-user" class="card">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Edit User</h4>
                </div>
            </div>
            <div class="card-body">
                <form ref="menu_form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Nama</label>
                                <input v-model="userData.user.name" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Nama Toko</label>
                                <input v-model="userData.nama" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Username</label>
                                <input v-model="userData.user.username" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Email</label>
                                <input v-model="userData.user.email" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Nomor Telepon</label>
                                <input v-model="userData.detail.telepon" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">NPWP</label>
                                <input v-model="userData.npwp" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Ijin Usaha</label>
                                <input v-model="userData.ijin_usaha" class="form-control" type="text">
                                {{-- <vue-multiselect v-model="userData.ijin_usaha" :searchable="true" :options="ijin_usaha_list" /> --}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Omset</label>
                                <input v-model="userData.omset" class="form-control" type="text">
                                {{-- <vue-multiselect v-model="userData.omset" :searchable="true" :options="omset_list" /> --}}
                            </div>
                        </div>
                        {{-- <div class="col-md-6" style="display: none">
                            <div class="form-group">
                                <label class="form-control-label">Password</label>
                                <input v-model="userData.password" class="form-control" type="text">
                            </div>
                        </div> --}}
                        <div class="col-md-6">
                            {{-- <div class="col-md-12"> --}}
                            <div class="form-group">
                                <label class="form-label">Alamat</label>
                                <input type="text" class="form-control" v-model="userData.detail.alamat">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Provinsi</label>
                                        <vue-multiselect v-model="userData.detail.provinsi" :searchable="true"
                                            :options="provinsi_list" placeholder="Pilih Provinsi"></vue-multiselect>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Kota</label>
                                        <vue-multiselect v-model="userData.detail.kota" :searchable="true"
                                            :options="kota_list" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Kecamatan</label>
                                        <vue-multiselect v-model="userData.detail.kecamatan" :searchable="true"
                                            :options="kecamatan_list" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Kelurahan</label>
                                        <vue-multiselect v-model="userData.detail.kelurahan" :searchable="true"
                                            :options="kelurahan_list" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" @click="back" class="btn btn-sm bg-warning me-1 text-white">
                            Cancel
                        </button>
                        <button type="button" @click="update" class="btn btn-sm bg-primary me-1 text-white">
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
                    isInitialLoad: true,
                    userData: {
                        nama: null,
                        user: {
                            username: null,
                            email: null
                        },
                        detail: {
                            alamat: null,
                            provinsi: null,
                            kota: null,
                            kecamatan: null,
                            kelurahan: null
                        }
                    },
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
                    provinsi_list: [],
                    kota_list: [],
                    kecamatan_list: [],
                    kelurahan_list: [],
                    // Tambahkan variabel untuk menyimpan ID lokasi asli
                    originalLocation: {
                        provinsiId: null,
                        kotaId: null,
                        kecamatanId: null,
                        kelurahanId: null
                    }
                }
            },
            async created() {
                await this.fetchProvinsiList()
                await this.fetchData()
            },
            watch: {
                "userData.detail.provinsi": {
                    handler: async function(value) {
                        if (!value) {
                            this.userData.detail.kota = null
                            this.userData.detail.kecamatan = null
                            this.userData.detail.kelurahan = null
                            this.kota_list = []
                            this.kecamatan_list = []
                            this.kelurahan_list = []
                            return
                        }

                        const provinsiId = value.value || value
                        console.log("Loading cities for province ID:", provinsiId)

                        await this.fetchKotaList(provinsiId)

                        // Jika ini adalah loading awal dan kita memiliki ID kota original
                        if (this.isInitialLoad && this.originalLocation.kotaId) {
                            const foundKota = this.kota_list.find(k => k.value == this.originalLocation.kotaId)
                            if (foundKota) {
                                this.userData.detail.kota = foundKota
                            }
                        }
                    },
                    immediate: true
                },
                "userData.detail.kota": {
                    handler: async function(value) {
                        if (!value) {
                            this.userData.detail.kecamatan = null
                            this.userData.detail.kelurahan = null
                            this.kecamatan_list = []
                            this.kelurahan_list = []
                            return
                        }

                        const kotaId = value.value || value
                        console.log("Loading districts for city ID:", kotaId)

                        await this.fetchKecamatanList(kotaId)

                        // Jika ini adalah loading awal dan kita memiliki ID kecamatan original
                        if (this.isInitialLoad && this.originalLocation.kecamatanId) {
                            const foundKecamatan = this.kecamatan_list.find(k => k.value == this
                                .originalLocation.kecamatanId)
                            if (foundKecamatan) {
                                this.userData.detail.kecamatan = foundKecamatan
                            }
                        }
                    }
                },
                "userData.detail.kecamatan": {
                    handler: async function(value) {
                        if (!value) {
                            this.userData.detail.kelurahan = null
                            this.kelurahan_list = []
                            return
                        }

                        const kecamatanId = value.value || value
                        console.log("Loading villages for district ID:", kecamatanId)

                        await this.fetchKelurahanList(kecamatanId)

                        // Jika ini adalah loading awal dan kita memiliki ID kelurahan original
                        if (this.isInitialLoad && this.originalLocation.kelurahanId) {
                            const foundKelurahan = this.kelurahan_list.find(k => k.value == this
                                .originalLocation.kelurahanId)
                            if (foundKelurahan) {
                                this.userData.detail.kelurahan = foundKelurahan
                                // Setelah semua data lokasi dimuat, akhiri mode loading awal
                                this.isInitialLoad = false
                            }
                        }
                    }
                }
            },
            methods: {
                async fetchData() {
                    try {
                        const response = await httpClient.get(
                            "{!! url('mastertoko') !!}/{{ $masterumkm_id }}/detail")

                        if (!response.data || !response.data.result) {
                            throw new Error("Data tidak valid")
                        }

                        this.userData = response.data.result

                        // Simpan ID lokasi asli
                        this.originalLocation = {
                            provinsiId: this.userData.detail.provinsi,
                            kotaId: this.userData.detail.kota,
                            kecamatanId: this.userData.detail.kecamatan,
                            kelurahanId: this.userData.detail.kelurahan
                        }

                        // Wait for provinsi list to load if needed
                        if (this.provinsi_list.length === 0) {
                            await this.fetchProvinsiList()
                        }

                        // Set provinsi if available
                        if (this.originalLocation.provinsiId) {
                            const provinsiId = this.originalLocation.provinsiId
                                .toString(); // Konversi ke string
                            const foundProvinsi = this.provinsi_list.find(p => p.value === provinsiId);

                            console.log("Searching provinsi:", {
                                provinsiId,
                                provinsi_list: this.provinsi_list,
                                foundProvinsi
                            }); // Debug pencarian

                            if (foundProvinsi) {
                                this.userData.detail.provinsi = foundProvinsi;
                                console.log("Provinsi set:", this.userData.detail
                                    .provinsi); // Debug setelah set
                            } else {
                                console.warn("Provinsi not found in list");
                            }
                        }
                    } catch (error) {
                        console.error("Error fetching user data:", error)
                        throw error
                    } finally {
                        this.isInitialLoad = false
                    }
                },
                async fetchProvinsiList() {
                    try {
                        const response = await httpClient.get("{!! url('input-scm/alamat/provinsi') !!}")
                        console.log("Raw provinsi response:", response.data) // Debug raw data

                        this.provinsi_list = response.data.result.map(el => ({
                            value: el.id,
                            label: el.name
                        }));

                        console.log("Formatted provinsi_list:", this.provinsi_list) // Debug formatted data
                    } catch (error) {
                        console.error("Error fetching province list:", error)
                        throw error
                    }
                },
                async fetchKotaList(id_provinsi) {
                    try {
                        const response = await httpClient.get("{!! url('input-scm/alamat/kota') !!}/" + id_provinsi)
                        this.kota_list = response.data.result.map(el => ({
                            value: el.id,
                            label: el.name
                        }))
                    } catch (error) {
                        console.error("Error fetching city list:", error)
                        this.kota_list = []
                    }
                },
                async fetchKecamatanList(data) {
                    try {
                        const response = await httpClient.get("{!! url('input-scm/alamat/kecamatan') !!}/" + data)
                        this.kecamatan_list = response.data.result.map(el => ({
                            value: el.id,
                            label: el.name
                        }))
                    } catch (error) {
                        console.error("Error fetching district list:", error)
                        this.kecamatan_list = []
                    }
                },
                async fetchKelurahanList(data) {
                    try {
                        const response = await httpClient.get("{!! url('input-scm/alamat/kelurahan') !!}/" + data)
                        this.kelurahan_list = response.data.result.map(el => ({
                            value: el.id,
                            label: el.name
                        }))
                    } catch (error) {
                        console.error("Error fetching village list:", error)
                        this.kelurahan_list = []
                    }
                },
                back() {
                    history.back()
                },
                async update() {
                    try {
                        showLoading()
                        // Prepare the data structure properly
                        const updateData = {
                            nama: this.userData.nama,
                            ijin_usaha: this.userData.ijin_usaha,
                            omset: this.userData.omset,
                            npwp: this.userData.npwp,
                            user: {
                                username: this.userData.user.username,
                                email: this.userData.user.email
                            },
                            detail: {
                                alamat: this.userData.detail.alamat,
                                provinsi: this.userData.detail.provinsi ? (this.userData.detail.provinsi
                                    .value || this.userData.detail.provinsi) : null,
                                kota: this.userData.detail.kota ? (this.userData.detail.kota.value || this
                                    .userData.detail.kota) : null,
                                kecamatan: this.userData.detail.kecamatan ? (this.userData.detail.kecamatan
                                    .value || this.userData.detail.kecamatan) : null,
                                kelurahan: this.userData.detail.kelurahan ? (this.userData.detail.kelurahan
                                    .value || this.userData.detail.kelurahan) : null
                            }
                        }

                        console.log("Sending update data:", updateData)

                        const response = await httpClient.put(
                            "{!! url('mastertoko') !!}/{{ $masterumkm_id }}",
                            updateData
                        )

                        // Perbarui ID lokasi asli setelah sukses menyimpan
                        this.originalLocation = {
                            provinsiId: updateData.detail.provinsi,
                            kotaId: updateData.detail.kota,
                            kecamatanId: updateData.detail.kecamatan,
                            kelurahanId: updateData.detail.kelurahan
                        }

                        hideLoading()
                        showToast({
                            message: "Data berhasil disimpan"
                        })
                    } catch (err) {
                        hideLoading()
                        showToast({
                            message: err.message,
                            type: 'error'
                        })
                    }
                }
            },
        }).component('vue-multiselect', VueformMultiselect).mount("#add-user")
    </script>
@endsection
