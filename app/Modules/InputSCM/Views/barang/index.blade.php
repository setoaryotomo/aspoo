@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner" id="input-scm">
        <default-datatable title="Data Barang Milik {{ $umkm->nama }}" url="{!! url($urlnow) !!}" :headers="headers"
            :can-add="{{ $permissions['create-input_scm'] }}" :can-edit="{{ $permissions['update-input_scm'] }}"
            :can-delete="{{ $permissions['delete-input_scm'] }}">
            <template #left-action="{ content }">
                <a :href="`{!! url('input-scm') !!}/bahan/${content.id_barang}`" class="btn btn-xs btn-info mr-1">
                    Lihat Detail
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
                            value: 'id_barang',
                        },{
                        text: 'Nama Barang',
                        value: 'nama',
                    }, ],
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
