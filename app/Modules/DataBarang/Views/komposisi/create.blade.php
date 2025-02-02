@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner">
        <div id="add-data-komposisi" class="card">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Tambah Data Komposisi</h4>
                </div>
            </div>
            <div class="card-body">
                <form ref="data_komposisi_form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label">Komposisi Barang</label>
                                <vue-multiselect v-model="komposisi.id_komposisi" :searchable="true" :options="komposisi_list" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Jumlah</label>
                                <input type="number" class="form-control" v-model="komposisi.jumlah">
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
                    komposisi: {
                        id_komposisi: null,
                    },
                    komposisi_list: [],
                    path: null,
                    name: null,


                }
            },
            created() {
                this.fetchKomposisiList()
            },
            methods: {
                async fetchKomposisiList() {
                    const response = await httpClient.get("{!! url('komposisi/all') !!}")
                    console.log(response)
                    this.komposisi_list = [
                        ...this.komposisi_list,
                        ...response.data.result.map(el => {
                            return {
                                value: el.id,
                                label: el.nama + "-"+el?.satuan?.satuan_simbol
                            }
                        })
                    ]
                },
                back() {
                    history.back()
                },
                resetForm() {
                    this.komposisi = {}
                    this.$refs.data_komposisi_form.reset()
                },
                async store() {
                    const komposisiFormData = new FormData()
                    Object.keys(this.komposisi).forEach(key => {
                        komposisiFormData.append(key, this.komposisi[key])
                    });

                    try {
                        showLoading()
                        const response = await httpClient.post("{!! url()->current() !!}", komposisiFormData)
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
        }).mount("#add-data-komposisi")
    </script>
@endsection
