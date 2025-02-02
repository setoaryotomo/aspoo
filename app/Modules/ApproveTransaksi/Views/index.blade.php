@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner" id="approve-transaksi">
        <default-datatable title="Approve Transaksi" url="{!! url('approve-transaksi') !!}" :headers="headers"
            :can-add="false" :can-edit="false" :can-delete="false">
            <template #left-action="{ content }">
                <button @click="approveTransaksi(content.kode_transaksi)" class="btn btn-xs btn-primary mr-1">
                    Approve
                </button>
                <a :href="`{!! url('approve-transaksi') !!}/preview/${content.kode_transaksi}`" class="btn btn-xs btn-info mr-1">
                    Lihat Data
                </a>
            </template>
        </default-datatable>
    </div>

    <script>
        createApp({
            data() {
                return {
                    headers: [
                        {
                            text: 'Kode Master',
                            value: 'kode_transaksi_master',
                        },{
                            text: 'Kode Transaksi',
                            value: 'kode_transaksi',
                        },
                        {
                            text: 'Kurir Pengiriman',
                            value: 'kurir_pengiriman',
                        },

                        {
                            text: 'Total Transaksi',
                            value: 'total_biaya_readable',
                        },
                        {
                            text: 'Pembeli',
                            value: 'pembeli.name',
                        },

                    ],
                }
            },
            created() {},
            methods: {
                async approveTransaksi(kode) {
                    console.log(kode)
                    try {
                        showLoading()
                        const response = await httpClient.post("{!! url('approve-transaksi/preview/') !!}", {
                            kode
                        })
                        hideLoading()
                        showToast({
                            message: "Data berhasil di Approve!"
                        })
                        history.back()

                    } catch (err) {
                        hideLoading()
                        showToast({
                            message: err.message,
                            type: 'error'
                        })
                    }
                }
            },
            components: {
                ...commonComponentMap(
                    [
                        'DefaultDatatable',
                    ]
                )
            },
        }).mount('#approve-transaksi');
    </script>
@endsection
