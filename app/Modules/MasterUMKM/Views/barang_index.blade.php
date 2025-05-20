@extends('dashboard_layout.index')
@section('content')
<div class="page-inner" id="barangUmkm">
    <div class="d-flex align-items-center mb-4">
        <h5 class="mb-0 mr-2">Data Barang {{ $umkm->nama }}</h5>
        
        <a href="{{ url('mastertoko') }}" class="btn btn-sm btn-outline-primary ml-auto">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="{{ url('data-barang/'.$id.'/create') }}" class="btn btn-sm btn-primary ml-2">
            <i class="fas fa-plus"></i> Tambah Barang
        </a>
    </div>
    
    <default-datatable 
        url="{!! url('mastertoko/'.$id.'/barang') !!}" 
        :headers="headers" 
        :can-add="false"
        :can-edit="false"
        :can-delete="false" 
    >
    
    <template #left-action="{ content }">
        <a :href="`{!! url('data-barang') !!}/inputstok/${content.id}`" class="btn btn-xs btn-success mr-1">Stok</a>
        <a :href="`{!! url('data-barang') !!}/komposisi/${content.id}`" class="btn btn-xs btn-info mr-1">Komposisi</a>
        <a :href="`{!! url('data-barang') !!}/${content.id}/edit`" class="btn btn-info btn-xs mr-1">Edit</a>

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
                        text: 'Harga',
                        value: 'harga_umum',
                    },
                    {
                        text: 'Stok',
                        value: 'stock_global',
                    },
                    // {
                    //     text: 'Satuan',
                    //     value: 'satuan.satuan_nama',
                    // }
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
    }).mount('#barangUmkm');
</script>
@endsection