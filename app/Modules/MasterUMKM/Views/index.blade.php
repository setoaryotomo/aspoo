@extends('dashboard_layout.index')
@section('content')
<div class="page-inner" id="masterumkm">
    {{-- <default-datatable title="MasterUMKM" url="{!! url('masterumkm') !!}" :headers="headers" :can-add="{{ $permissions['create-master_umkm'] }}" :can-edit="{{ $permissions['update-master_umkm'] }}" :can-delete="{{ $permissions['delete-master_umkm'] }}" /> --}}
    <default-datatable title="MasterUMKM" url="{!! url('masterumkm') !!}" :headers="headers" :can-add="false" :can-edit="false" :can-delete="false" />
    <template #left-action="{ content }">
        <a :href="`{!! url('masterumkm') !!}/${content.user_id}/barang`" class="btn btn-xs btn-success mr-1">Barang</a>

    </template>
</div>

<script>
    createApp({
        data() {
            return {
                headers: [
                    {
                        text: 'Nama',
                        value: 'nama',
                    },    
                    // {
                    //     text: 'Pengikut',
                    //     value: 'pengikut',
                    // },    
                    // {
                    //     text: 'user id',
                    //     value: 'user_id',
                    // },    
                    // {
                    //     text: 'id',
                    //     value: 'id',
                    // },    
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
    }).mount('#masterumkm');
</script>
@endsection