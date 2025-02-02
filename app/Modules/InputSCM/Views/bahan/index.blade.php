@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner" id="input-scm">
        <default-datatable title="Data Bahan dari Barang {{ $barang->nama }}" url="{!! url($urlnow) !!}"
            :headers="headers" :can-add="{{ $permissions['create-input_scm'] }}"
            :can-edit="{{ $permissions['update-input_scm'] }}" :can-delete="{{ $permissions['delete-input_scm'] }}">
            <template #left-action="{ content }">
                <a :href="`{!! url('input-scm') !!}/supplier/${content.id_bahan_baku}`" class="btn btn-xs btn-info mr-1">
                    Tambah Supplier
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
                            value: 'id_bahan_baku',
                        },{
                        text: 'Nama Bahan',
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
