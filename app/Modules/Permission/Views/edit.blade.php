@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner">
        <div id="add-permission" class="card">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Edit Permission</h4>
                </div>
            </div>
            <div class="card-body">
                <form ref="menu_form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Kode Permission</label>
                                <input v-model="permissionData.code" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Deskripsi Menu</label>
                                <input v-model="permissionData.description" class="form-control" type="email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Menu</label>
                                <vue-multiselect v-model="permissionData.menu_id" :searchable="true"
                                    :options="menus" />
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
                    permissionData: {
                        code: null,
                        description: null,
                        menu_id: null,
                    },
                    menus: [{
                        value: null,
                        label: "No Parent"
                    }]
                }
            },
            async created() {
                showLoading()
                await this.fetchMenus()
                await this.fetchData()
                hideLoading()
            },
            methods: {
                async fetchData() {
                    const response = await httpClient.get("{!! url('permission') !!}/{{ $permission_id }}/detail")
                    this.permissionData = response.data.result
                },
                async fetchMenus() {
                    const response = await httpClient.get("{!! url('menu/all') !!}")
                    this.menus = [
                        ...this.menus,
                        ...response.data.result.map(el => {
                            return {
                                value: el.id,
                                label: el.name
                            }
                        })
                    ]
                },
                back() {
                    history.back()
                },
                async update() {
                    try {
                        showLoading()
                        const response = await httpClient.put("{!! url('permission') !!}/{{ $permission_id }}",
                            this.permissionData)
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
        }).component('vue-multiselect', VueformMultiselect).mount("#add-permission")
    </script>
@endsection
