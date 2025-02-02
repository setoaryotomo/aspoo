@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner" id="input-scm">
        <default-datatable title="Data Supplier dari Bahan Baku {{ $bahan->nama }}" url="{!! url($urlnow) !!}"
            :headers="headers" :can-add="{{ $permissions['create-input_scm'] }}"
            :can-edit="{{ $permissions['update-input_scm'] }}" :can-delete="{{ $permissions['delete-input_scm'] }}">
           
        </default-datatable>
    </div>

    <script>
        createApp({
            data() {
                return {
                    headers: [
                        {
                            text: 'ID',
                            value: 'id_supplier',
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
