@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner" id="user-page">
        <default-datatable title="User" url="{!! url('user') !!}" :headers="headers">
            <template #left-action="{ content }">
                <button @click="handleRoleButtonClick(content.id)" type="button" class="btn btn-xs btn-info mr-1"
                    data-toggle="modal">
                    Role
                </button>
            </template>
        </default-datatable>

        <div ref="modal" class="modal fade" id="addRoleModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Role</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-sm-10 mb-2">
                                    <vue-multiselect v-model="selectedRoleId" :searchable="true"
                                        :options="roles" />
                                </div>
                                <div class="col-sm-2">
                                    <div v-if="isAddingRole" class="loader loader-lg"></div>
                                    <button v-if="!isAddingRole" @click="addUserRole" type="button"
                                        class="btn btn-sm btn-primary btn-block">
                                        Tambah Role
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-items-center table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            Role
                                        </th>
                                        <th class="text-center">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="isFetchingUserRole">
                                        <td :colspan="2">
                                            <div class="d-flex justify-content-center">
                                                <div class="loader loader-lg"></div>
                                            </div>
                                        </td>
                                    </tr>
                                    <template v-if="!isFetchingUserRole">
                                        <tr v-for="role in userRoles">
                                            <td class="text-center">@{{ role.name }}</td>
                                            <td class="text-center">
                                                <div v-if="isRemoveRole" class="loader loader-lg"></div>
                                                <button v-if="!isRemoveRole" @click="removeUserRole(role.id)" type="button"
                                                    class="btn btn-xs btn-danger">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        createApp({
            data() {
                return {
                    roles: [],
                    userRoles: [],
                    isFetchingUserRole: false,
                    showModal: false,
                    headers: [{
                            text: 'id',
                            value: 'id',
                        },
                        {
                            text: 'Nama User',
                            value: 'name',
                        },
                        {
                            text: 'Username User',
                            value: 'username',
                        },
                        {
                            text: 'Email User',
                            value: 'email',
                        },
                    ],
                    selectedRoleId: null,
                    selectedUserId: null,
                    isAddingRole: false,
                    isRemoveRole: false
                }
            },
            created() {
                this.fetchRoles()
            },
            components: {
                ...commonComponentMap(
                    [
                        'DefaultDatatable',
                    ]
                )
            },
            methods: {
                async handleRoleButtonClick(userId) {
                    this.selectedUserId = userId
                    $('#addRoleModal').modal()
                    await this.fetchUserRoles(userId)
                },
                async addUserRole() {
                    this.isAddingRole = true;
                    await httpClient.post(`user/${this.selectedUserId}/role`, {
                        role_id: this.selectedRoleId
                    });
                    this.isAddingRole = false;
                    this.fetchUserRoles(this.selectedUserId)
                },
                async removeUserRole(role_id) {
                    this.isRemoveRole = true;
                    await httpClient.delete(`user/${this.selectedUserId}/role/${role_id}`);
                    this.isRemoveRole = false;
                    this.fetchUserRoles(this.selectedUserId)
                },
                async fetchUserRoles(userId) {
                    this.isFetchingUserRole = true
                    const response = await httpClient.get(`{{ url('') }}/user/${userId}/role`);
                    this.userRoles = response.data.result
                    this.isFetchingUserRole = false
                },
                async fetchRoles() {
                    const response = await httpClient.get('{{ url('') }}/role/all');
                    this.roles = response.data.result.map((role) => {
                        return {
                            value: role.id,
                            label: role.name
                        }
                    })
                }
            },
        }).component('vue-multiselect', VueformMultiselect).mount('#user-page');
    </script>
@endsection
