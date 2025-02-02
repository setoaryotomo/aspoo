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
                                <input v-model="userData.name" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Username</label>
                                <input v-model="userData.username" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Email</label>
                                <input v-model="userData.email" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Password</label>
                                <input v-model="userData.password" class="form-control" type="text">
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
                    userData: {
                        name: null,
                    },
                }
            },
            async created() {
                showLoading()
                await this.fetchData()
                hideLoading()
            },
            methods: {
                async fetchData() {
                    const response = await httpClient.get("{!! url('user') !!}/{{ $user_id }}/detail")
                    this.userData = response.data.result
                    delete this.userData.password
                    console.log(this.userData)
                },
                back() {
                    history.back()
                },
                async update() {
                    try {
                        showLoading()
                        const response = await httpClient.put("{!! url('user') !!}/{{ $user_id }}",
                            this.userData)
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
