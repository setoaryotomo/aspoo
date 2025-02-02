@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner">
        <div id="add-komposisi" class="card">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Tambah Komposisi</h4>
                </div>
            </div>
            <div class="card-body">
                <form ref="komposisi_form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Nama Komposisi</label>
                                <input type="text" v-model="komposisi.nama" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label">Satuan</label>
                                <vue-multiselect v-model="komposisi.satuan_id" :searchable="true" :options="satuan_list" />
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
                        satuan_id: null,

                    },
                    satuan_list: [],

                }
            },
            created() {
                this.fetchSatuanList()
            },
            watch: {
                "komposisi.satuan_id": {
                    handler: function(value) {
                        let satuan_data = this.satuan_list.find(satuan_item => satuan_item.value == value)
                        this.path = `${satuan_data.label.toLowerCase().split(" ").join("-")}`
                        if (this.name != null && this.name != "") {
                            this.path += `/${this.name.toLowerCase().split(" ").join("-")}`
                        }
                        this.komposisi.satuan_id = value
                        console.log(this.komposisi)
                    },
                    deep: true,
                },


            },
            methods: {
                back() {
                    history.back()
                },
                async fetchSatuanList() {
                    const response = await httpClient.get("{!! url('satuan/all') !!}")
                    this.satuan_list = [
                        ...this.satuan_list,
                        ...response.data.result.map(el => {
                            return {
                                value: el.id,
                                label: el.satuan_nama
                            }
                        })
                    ]
                },
                resetForm() {
                    this.komposisi = {}
                    this.$refs.komposisi_form.reset()
                },
                async store() {
                    try {
                        showLoading()
                        const response = await httpClient.post("{!! url('komposisi') !!}", this.komposisi)
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
        }).mount("#add-komposisi")
    </script>
@endsection
