@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner" id="input-scm">
        <default-datatable title="InputSCM" url="{!! url('input-scm') !!}" :headers="headers"
            :can-add="{{ $permissions['create-input_scm'] }}" :can-edit="{{ $permissions['update-input_scm'] }}"
            :can-delete="{{ $permissions['delete-input_scm'] }}">
            <template #left-action="{ content }">
                <a :href="`{!! url('input-scm') !!}/${content.id_umkm}/barang/`" class="btn btn-xs btn-info mr-1">
                    Lihat Detail
                </a>
                <a :href="`{!! url('input-scm') !!}/${content.id_umkm}/preview`" class="btn btn-xs btn-warning mr-1">
                    Preview SCM
                </a>
            </template>
        </default-datatable>
    </div>

    <script>
        createApp({
            data() {
                return {
                    headers: [ {
                            text: 'ID',
                            value: 'id_umkm',
                        },{
                            text: 'Nama UMKM',
                            value: 'nama',
                        },
                       
                    ],
                }
            },
            created() {},
            methods: {},
            components: {
                ...commonComponentMap(
                    [
                        'DefaultDatatable',
                    ]
                )
            },
        }).mount('#input-scm');
    </script>
@endsection
