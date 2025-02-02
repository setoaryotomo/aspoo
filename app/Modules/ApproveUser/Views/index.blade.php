@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner" id="approve-user">
        <default-datatable ref="approveTable" title="Approve User" url="{!! url('approve-user') !!}" :headers="headers" :can-add="false"
            :can-edit="false" :can-delete="false">
            <template #left-action="{ content }">
                <button @click="approveUserData(content.id)" class="btn btn-xs btn-info mr-1">
                    Approve User
                </button>
            </template>
        </default-datatable>
    </div>

    <script>
        createApp({
            data() {
                return {
                    headers: [{
                            text: 'Nama',
                            value: 'name',
                        },
                        {
                            text: 'Email',
                            value: 'email',
                        },
                        {
                            text: 'Username',
                            value: 'username',
                        },
                        {
                            text: 'Role',
                            value: 'role_nama',
                        },

                    ],
                }
            },
            created() {},
            methods: {
                async approveUserData(id) {
                    console.log(id)
                    Swal.fire({
                        title: "Apakah anda ingin Approve User Ini?",
                        showDenyButton: true,
                        confirmButtonText: `Yakin`,
                        denyButtonText: `Tidak`,
                    }).then(async (result) => {
                        if (result.isConfirmed) {
                            await httpClient.post(`{{ url('approve-user')}}/approve/${id}`);
                            Swal.fire("Data berhasil di Approve!", "", "success");
                        this.$refs.approveTable.fetchData()

                        } else if (result.isDenied) {
                            Swal.fire("Proses Approve dibatalkan", "", "info");
                        this.$refs.approveTable.fetchData()


                        }
                    });
                }
            },
            components: {
                ...commonComponentMap(
                    [
                        'DefaultDatatable',
                    ]
                )
            },
        }).mount('#approve-user');
    </script>
@endsection
