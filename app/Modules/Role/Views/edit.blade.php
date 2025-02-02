@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner">
        <div id="add-menu" class="card">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Edit Role</h4>
                </div>
            </div>
            <div class="card-body">
                <form ref="menu_form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Nama Role</label>
                                <input v-model="roleData.name" class="form-control" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" @click="back" class="btn btn-sm bg-warning mr-1 text-white">
                            Cancel
                        </button>
                        <button type="button" @click="update" class="btn btn-sm bg-primary mr-1 text-white">
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
                    roleData: {
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
                    const response = await httpClient.get("{!! url('role') !!}/{{ $role_id }}/detail")
                    this.roleData = response.data.result
                    console.log(this.roleData)
                },
                back() {
                    history.back()
                },
                async update() {
                    try {
                        showLoading()
                        const response = await httpClient.put("{!! url('role') !!}/{{ $role_id }}",
                            this.roleData)
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
        }).component('vue-multiselect', VueformMultiselect).mount("#add-menu")
    </script>
@endsection
