@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner" id="validasi-transaksi">
        <default-datatable title="Validasi Transaksi" url="{!! url('validasi-transaksi') !!}" :headers="headers"
            :can-add="false" :can-edit="false" :can-delete="false">
            <template #left-action="{ content }">
                <a :href="`{!! url('validasi-transaksi') !!}/preview/${content.kode_transaksi}`" class="btn btn-xs btn-info mr-1">
                    Lihat Data
                </a>
            </template>
        </default-datatable>
    </div>

    <script>
        createApp({
            data() {
                return {
                    headers: [{
                            text: 'Kode Master',
                            value: 'kode_transaksi',
                        },
                        {
                            text: 'Tipe Rekening',
                            value: 'tipe_rekening',
                        },
                        {
                            text: 'Total Biaya',
                            value: 'total_biaya',
                        },
                        {
                            text: 'Kode Unik',
                            value: 'kode_unik',
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
        }).mount('#validasi-transaksi');
    </script>
@endsection
