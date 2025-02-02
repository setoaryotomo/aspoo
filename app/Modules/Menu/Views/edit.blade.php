@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner">
        <div id="add-menu" class="card">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <h4 class="mb-0">Edit Menu</h4>
                </div>
            </div>
            <div class="card-body">
                <form ref="menu_form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Nama Module</label>
                                <input v-model="menuData.module.name" class="form-control" type="text" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Nama Menu</label>
                                <input v-model="menuData.name" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Path</label>
                                <input v-model="menuData.path" class="form-control" type="email" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Description</label>
                                <input v-model="menuData.description" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Parent</label>
                                <vue-multiselect v-model="menuData.parent_id" :searchable="true"
                                    :options="parents" />
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
                    menuData: {
                        module: [],
                        name: null,
                        path: null,
                        description: null,
                        parent_id: null,
                    },
                    parents: [{
                        value: null,
                        label: "No Parent"
                    }]
                }
            },
            async created() {
                showLoading()
                await this.fetchParents()
                await this.fetchData()
                hideLoading()
            },
            methods: {
                async fetchData() {
                    const response = await httpClient.get("{!! url('menu') !!}/{{ $menu_id }}/detail")
                    this.menuData = response.data.result
                },
                async fetchParents() {
                    const response = await httpClient.get("{!! url('menu/parents') !!}")
                    this.parents = [
                        ...this.parents,
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
                        const response = await httpClient.put("{!! url('menu') !!}/{{ $menu_id }}",
                            this.menuData)
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
