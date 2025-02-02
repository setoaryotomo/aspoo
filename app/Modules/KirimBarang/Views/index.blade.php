@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner" id="kirim-barang">
        <default-datatable title="Kirim Barang" url="{!! url('kirim-barang') !!}" :headers="headers"
            :can-add="false" :can-edit="false" :can-delete="false">
            <template #left-action="{ content }">
                <button @click="approveTransaksi(content.kode_transaksi)" class="btn btn-xs btn-primary mr-1">
                    Approve
                </button>
                <a :href="`{!! url('kirim-barang') !!}/preview/${content.kode_transaksi}`" class="btn btn-xs btn-info mr-1">
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
                        const response = await httpClient.post("{!! url('kirim-barang/preview/') !!}", {
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
        }).mount('#kirim-barang');
    </script>
@endsection
