@extends('dashboard_layout.index')
@section('content')
<div class="page-inner" id="data-barang">
    <default-datatable title="DataBarang" url="{!! url('data-barang') !!}" :headers="headers" :can-add="{{ $permissions['create-data_barang'] }}" :can-edit="{{ $permissions['update-data_barang'] }}" :can-delete="{{ $permissions['delete-data_barang'] }}" >
        <template #left-action="{ content }">
            <a :href="`{!! url('data-barang') !!}/komposisi/${content.id}`" class="btn btn-xs btn-info mr-1">Komposisi</a>

        </template>
    </default-datatable>
</div>

<script>
    createApp({
        data() {
            return {
                headers: [
                    {
                        text: 'Nama Barang',
                        value: 'nama_barang',
                    },    
                    {
                        text: 'Harga Umum',
                        value: 'harga_umum',
                    },    
                    {
                        text: 'Harga Supplier',
                        value: 'harga_supplier',
                    },  
                    {
                        text: 'Stok',
                        value: 'stock_global',
                    },  
                    {
                        text: 'Terjual',
                        value: 'terjual',
                    },
                    {
                        text: 'Berat (gram)',
                        value: 'berat',
                    }, 
                    {
                        text: 'Satuan',
                        value: 'satuan.satuan_nama',
                    },  
                    {
                        text: 'UMKM',
                        value: 'user.nama',
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