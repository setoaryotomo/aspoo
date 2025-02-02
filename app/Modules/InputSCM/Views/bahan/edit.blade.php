@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner">
        <div id="add-input-scm" class="card">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Tambah Bahan Baku Barang {!! $barang->nama !!}</h4>
                </div>
            </div>
            <div class="card-body">
                <form ref="barang_scm_form">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Nama Barang</label>
                                <input v-model="barang_scm.nama" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Nama Merk</label>
                                <input v-model="barang_scm.merk" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Sifat Bahan Baku</label>
                                <vue-multiselect v-model="barang_scm.sifat_bahan" :searchable="true"
                                    :options="sifat_bahan_list" />
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
                    barang_scm: {},
                    sifat_bahan_list: [{
                            value: "MENTAH",
                            label: "Mentah"
                        },
                        {
                            value: "OLAHAN",
                            label: "Olahan"
                        },

                    ],
                    headers: [{
                            text: 'Nama Supplier',
                            value: 'nama',
                        },
                        {
                            text: 'Jenis Supplier',
                            value: 'jenis_supplier',
                        },
                    ],

                }
            },
            created() {
                this.fetchData();
            },
            methods: {
                async fetchData() {
                    console.log("sadtas")
                    const response = await httpClient.post("{!! url()->current() !!}/")
                    this.input_scm = response.data.result
                    console.log(this.input_scm)
                },
                back() {
                    history.back()
                },
                resetForm() {
                    this.barang_scm = {}
                    this.$refs.barang_scm_form.reset()
                },

                async store() {
                    try {
                        showLoading()
                        const response = await httpClient.post("{!! url($urlnow) !!}", this
                            .barang_scm)
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
                ...commonComponentMap(
                    [
                        'DefaultDatatable',
                    ]
                )
            },
        }).mount("#add-input-scm")
    </script>
@endsection
