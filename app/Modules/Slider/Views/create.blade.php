@extends('dashboard_layout.index')
@section('content')
<div class="page-inner">
    <div id="add-slider" class="card">
        <div class="card-header pb-0">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Tambah Slider</h4>
            </div>
        </div>
        <div class="card-body">
            <form ref="slider_form" enctype="multipart/form-data">
                <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label">Foto</label>
                        <input v-model="slider.foto" class="form-control" type="file" @change="handleFileChange">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label">Keterangan</label>
                        <input v-model="slider.keterangan" class="form-control" type="text">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label">Status</label>
                        <vue-multiselect v-model="slider.status" :searchable="true" :options="selectOptions"
                                placeholder="Pilih Opsi" />
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
                slider: {
					foto: null,
					keterangan: null,
					status: 1,

                },
                selectOptions: [
                    {
                        value: 1,
                        label: "Aktif" 
                    },
                    {
                        value: 0,
                        label: "Tidak Aktif"
                    }
                ],
             
            }
        },
        methods: {
            handleFileChange(){
                this.slider.foto = event.target.files[0];
            },
            back() {
                history.back()
            },
            resetForm(){
                this.slider = {
					foto: null,
					keterangan: null,
					status: null,
              }
                this.$refs.slider_form.reset()
            },
            async store() {
                const sliderFormData = new FormData()
                    Object.keys(this.slider).forEach(key => {
                        sliderFormData.append(key, this.slider[key])
                    });
                try {
                    showLoading()
                    const response = await httpClient.post("{!! url('slider') !!}", sliderFormData)
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
    }).mount("#add-slider")
</script>
@endsection