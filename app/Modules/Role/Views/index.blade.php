@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner" id="role-page">
        <default-datatable title="Roles" url="{!! url('role') !!}" :headers="headers">
            <template #left-action="{ content }">
                <button @click="handlePermissionButtonClick(content.id)" type="button" class="btn btn-xs btn-primary mr-1"
                    data-toggle="modal">
                    Permission
                </button>
            </template>
        </default-datatable>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Permission</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-sm-6 mb-2">
                                    <vue-multiselect v-model="selectedMenuId" :searchable="true" :options="menus"
                                        placeholder="Pilih Menu" />
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <vue-multiselect v-model="selectedPermissionId" :searchable="true"
                                        :options="permissions" placeholder="Pilih Permission" />
                                </div>

                                <div class="col-sm-12">
                                    <div v-if="isAddingPermission" class="loader loader-lg"></div>
                                    <button v-if="!isAddingPermission" @click="handleAddPermissionButtonClick" type="button"
                                        class="btn btn-sm btn-primary btn-block mb-2">
                                        Tambah Permission
                                    </button>
                                </div>
                            </div>
                            <default-datatable ref="permissionTable" v-if="selectedRoleId != null" title=""
                                :url="`{!! url('role') !!}/${selectedRoleId}/permission`" :key="selectedRoleId"
                                :headers="permissionHeaders" :can-add="false" :can-edit="false">
                                <template #description={content}>
                                    @{{ content.code }} - @{{ content.description }}
                                </template>
                            </default-datatable>
                        </div>
                    </div>
                </div>
            </div>

    <script>
        createApp({
            data() {
                return {
                    isAddingPermission: false,
                    selectedMenuId: null,
                    selectedPermissionId: null,
                    selectedRoleId: null,
                    menus: [],
                    permissions: [],
                    headers: [{
                            text: 'id',
                            value: 'id',
                        },
                        {
                            text: 'Nama Role',
                            value: 'name',
                        },
                    ],
                    permissionHeaders: [{
                            text: 'Nama Menu',
                            value: 'menu.name'
                        },
                        {
                            text: 'Permission',
                            value: 'description'
                        }
                    ]
                }
            },
            watch: {
                selectedMenuId() {
                    this.fetchPermissions()
                }
            },
            created() {
                this.fetchMenus()
            },
            methods: {
                async fetchPermissions() {
                    const response = await httpClient.get(
                        `{{ url('') }}/menu/${this.selectedMenuId}/permissions`)
                    var staticPermission = {
                        value: "all",
                        label: "All Permission"
                    }
                    this.permissions.push(staticPermission);
                    this.permissions = response.data.result.map(el => {
                        return {
                            value: el.id,
                            label: `${el.code} - ${el.description}`,
                        }
                    })
                    this.permissions.unshift(staticPermission);
                },
                async fetchMenus() {
                    const response = await httpClient.get('{{ url('') }}/menu/all')
                    this.menus = response.data.result.map(el => {
                        return {
                            value: el.id,
                            label: el.name
                        }
                    })
                },
                async handlePermissionButtonClick(roleId) {
                    this.selectedRoleId = roleId
                    $('#addPermissionModal').modal()
                },
                async handleAddPermissionButtonClick() {
                    this.isAddingPermission = true;
                    try {
                        await httpClient.post(`{{ url('') }}/role/${this.selectedRoleId}/permission`, {
                            permission_id: this.selectedPermissionId,
                            menu_id: this.selectedMenuId
                        })
                        this.$refs.permissionTable.fetchData()
                        this.isAddingPermission = false;
                    } catch (err) {
                        console.log(err)
                        this.isAddingPermission = false
                    }
                },
            },
            components: {
                ...commonComponentMap(
                    [
                        'DefaultDatatable',
                    ]
                ),
                'vue-multiselect': VueformMultiselect
            },
        }).mount('#role-page');
    </script>
@endsection
