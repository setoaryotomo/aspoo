@extends('dashboard_layout.index')
@section('content')
<div class="page-inner">
    <div id="edit-satuan" class="card">
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
                    <button type="button" @click="update" class="btn btn-sm bg-primary mr-2 text-white">
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
                    satuan_nama : "",
                    satuan_simbol : "",
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
        async created() {
            showLoading()
            await this.fetchData()
            hideLoading()
        },
        methods: {
            async fetchData() {
                const response = await httpClient.get("{!! url('satuan') !!}/{{ $satuan_id }}")
                this.satuan = response.data.result
                console.log(this.satuan)
            },
            back() {
                history.back()
            },
            async update() {
                try {
                    showLoading()
                    const response = await httpClient.put("{!! url('satuan') !!}/{{ $satuan_id }}",
                        this.satuan)
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
        components: {
            'vue-multiselect': VueformMultiselect
        },
    }).mount("#edit-satuan")
</script>
@endsection