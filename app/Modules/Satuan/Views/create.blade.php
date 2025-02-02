@extends('dashboard_layout.index')
@section('content')
<div class="page-inner">
    <div id="add-satuan" class="card">
        <div class="card-header pb-0">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Tambah Satuan</h4>
            </div>
        </div>
        <div class="card-body">
            <form ref="satuan_form">
                <div class="row">
                    <div class="form-group">
                        <label class="form-control-label">Nama Satuan</label>
                        <input v-model="satuan.satuan_nama" class="form-control" type="text">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Simbol Satuan</label>
                        <input v-model="satuan.satuan_simbol" class="form-control" type="text">
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
                satuan: {
                    
                },
                selectOptions: [
                    {
                        value: 1,
                        label: "Yes" 
                    },
                    {
                        value: 0,
                        label: "No"
                    }
                ],
                radioOptions: [
                    {
                        id: 1,
                        label: "Yes"
                    },
                    {
                        id: 0,
                        label: "No"
                    }
                ],
            }
        },
        methods: {
            back() {
                history.back()
            },
            resetForm(){
                this.satuan = {
              }
                this.$refs.satuan_form.reset()
            },
            async store() {
                try {
                    showLoading()
                    const response = await httpClient.post("{!! url('satuan') !!}", this.satuan)
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
    }).mount("#add-satuan")
</script>
@endsection