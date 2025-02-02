@extends('dashboard_layout.index')
@section('content')
<div class="page-inner">
<div id="add-user" class="card">
    <div class="card-header pb-0">
        <div class="d-flex align-items-center">
            <h4 class="card-title">Tambah User</h4>
        </div>
    </div>
    <div class="card-body">
        <form ref="user_form">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label">Nama User</label>
                        <input v-model="userData.name" class="form-control" type="text">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label">Email User</label>
                        <input v-model="userData.email" class="form-control" type="text">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label">Username User</label>
                        <input v-model="userData.username" class="form-control" type="text">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label">Password User</label>
                        <input v-model="userData.password" type="password" class="form-control" type="text">
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="button" @click="back" class="btn btn-sm bg-warning me-1 text-white">
                    Cancel
                </button>
                <button type="button" @click="store" class="btn btn-sm bg-primary me-1 text-white">
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
                userData: {
                    name: null,
                    username: null,
                    email: null,
                    password: null
                }
            }
        },
        methods: {
            back() {
                history.back()
            },
            async store() {
                try {
                    showLoading()
                    const response = await httpClient.post("{!! url('user') !!}", this.userData)
                    hideLoading()
                    showToast({
                        message: "Data berhasil ditambahkan"
                    })
                    this.$refs.user_form.reset()

                } catch (err) {
                    hideLoading()
                    showToast({
                        message: err.message,
                        type: 'error'
                    })
                }
            }
        },
    }).mount("#add-user")
</script>
@endsection