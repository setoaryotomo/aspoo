@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner">
        <div id="add-stok" class="card">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Input Stok</h4>
                </div>
            </div>
            <div class="card-body">
                <form ref="stok_form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Jumlah</label>
                                <input type="number" v-model="input_stok.jumlah" class="form-control" placeholder="Masukkan Jumlah">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Tanggal</label>
                                <input type="date" v-model="input_stok.tanggal" class="form-control">
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
                    input_stok: {
                        jumlah: null,
                        tanggal: null,
                    }
                }
            },
            methods: {
                back() {
                    history.back()
                },
                resetForm() {
                    this.input_stok = {
                        jumlah: null,
                        tanggal: null,
                    }
                    this.$refs.stok_form.reset()
                },
                async store() {
                    try {
                        showLoading()
                        const response = await httpClient.post("{!! url()->current() !!}", this.input_stok)
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
            }
        }).mount("#add-stok")
    </script>
@endsection