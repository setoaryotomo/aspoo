@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner" id="data-barang">
        <default-datatable title="Input Stok" url="{!! url('data-barang/inputstok') . '/' . $id !!}" :headers="headers"
            :can-add="true" :can-edit="false" :can-delete="true">
            
        </default-datatable>
    </div>
    <script>
        createApp({
            data() {
                return {
                    headers: [{
                            text: 'Tanggal',
                            value: 'tanggal',
                        },
                        {
                            text: 'Jumlah Barang Masuk',
                            value: 'jumlah',
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
        }).mount('#data-barang');
    </script>
@endsection
