@extends('dashboard_layout.index')
@section('content')
<div class="page-inner" id="transaksi-barang">
    <default-datatable title="TransaksiBarang" url="{!! url('transaksi-barang') !!}" :headers="headers" :can-add="{{ $permissions['create-transaksi_barang'] }}" :can-edit="{{ $permissions['update-transaksi_barang'] }}" :can-delete="{{ $permissions['delete-transaksi_barang'] }}" />
</div>

<script>
    createApp({
        data() {
            return {
                headers: [
                    {
                        text: 'Id',
                        value: 'id',
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
    }).mount('#transaksi-barang');
</script>
@endsection