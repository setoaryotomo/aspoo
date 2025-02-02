@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner" id="data-barang">
        <default-datatable title="Komposisi Barang" url="{!! url('data-barang/komposisi') . '/' . $id !!}" :headers="headers"
            :can-add="true" :can-edit="false" :can-delete="true">
            <template #left-action="{ content }">
                <a :href="`{!! url()->current() !!}/supplier/${content.id_komposisi}`" class="btn btn-xs btn-info mr-1">Data Supplier</a>
    
            </template>
        </default-datatable>
    </div>
    <script>
        createApp({
            data() {
                return {
                    headers: [{
                            text: 'Nama Komposisi',
                            value: 'komposisi.nama',
                        },
                        {
                            text: 'Satuan',
                            value: 'komposisi.satuan.satuan_nama',
                        },
                        {
                            text: 'Jumlah',
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
