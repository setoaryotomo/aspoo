@extends('dashboard_layout.index')

@section('content')
<div class="page-inner">
    <div id="add-permintaan-parcel" class="card">
        <div class="card-header pb-0">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Tambah Permintaan Parcel</h4>
            </div>
        </div>
        <div class="card-body">
            <form ref="parcel_form">
                <div class="row">
                    <!-- Input for Nama Pemesan -->
                    {{-- <div class="col-md-6 mb-3">
                        <label for="nama_pemesan">Nama Pemesan</label>
                        <input v-model="parcel.nama_pemesan" type="text" class="form-control" id="nama_pemesan" placeholder="Masukkan nama pemesan" required>
                    </div> --}}

                    <!-- Input for Harga -->
                    <div class="col-md-6 mb-3">
                        <label for="harga">Harga yang Diinginkan</label>
                        <input v-model="parcel.harga" type="number" class="form-control" id="harga" placeholder="Masukkan harga" required>
                    </div>

                    <!-- Input for Barang -->
                    <div class="col-md-6 mb-3">
                        <label for="barang">Barang yang Diinginkan</label>
                        <input v-model="parcel.barang" type="text" class="form-control" id="barang" placeholder="Masukkan nama barang" required>
                    </div>

                    <!-- Input for Tanggal Dibutuhkan -->
                    <div class="col-md-6 mb-3">
                        <label for="tanggal">Tanggal Dibutuhkan</label>
                        <input v-model="parcel.tanggal" type="date" class="form-control" id="tanggal" required>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="button" @click="back" class="btn btn-sm bg-warning mr-2 text-white">
                        Cancel
                    </button>
                    <button type="button" @click="store" class="btn btn-sm bg-primary text-white">
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
                parcel: {
                    // nama_pemesan: '',
                    harga: '',
                    barang: '',
                    tanggal: ''
                }
            }
        },
        methods: {
            back() {
                history.back()
            },
            resetForm() {
                this.parcel = {
                    // nama_pemesan: '',
                    harga: '',
                    barang: '',
                    tanggal: ''
                };
                this.$refs.parcel_form.reset();
            },
            async store() {
                try {
                    showLoading();
                    const response = await httpClient.post("{{ url('permintaan-parcel') }}", this.parcel);
                    hideLoading();
                    showToast({
                        message: "Data berhasil ditambahkan"
                    });
                    this.resetForm();
                } catch (err) {
                    hideLoading();
                    showToast({
                        message: err.message,
                        type: 'error'
                    });
                }
            }
        }
    }).mount("#add-permintaan-parcel");
</script>
@endsection


{{-- @extends('dashboard_layout.index')
@section('content')
<div class="page-inner">
    <div id="add-permintaan-parcel" class="card">
        <div class="card-header pb-0">
            <div class="d-flex align-items-center">
                <h4 class="card-title">Tambah permintaanparcel</h4>
            </div>
        </div>
        <div class="card-body">
            <form ref="permintaan_parcel_form">
                <div class="row">

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
                permintaan_parcel: {

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
                this.permintaan_parcel = {
              }
                this.$refs.permintaan_parcel_form.reset()
            },
            async store() {
                try {
                    showLoading()
                    const response = await httpClient.post("{!! url('permintaan-parcel') !!}", this.permintaan_parcel)
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
    }).mount("#add-permintaan-parcel")
</script>
@endsection --}}