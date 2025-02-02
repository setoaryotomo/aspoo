@extends('dashboard_layout.index')
@section('content')
<div class="page-inner" id="masterumkm">
    <default-datatable title="MasterUMKM" url="{!! url('masterumkm') !!}" :headers="headers" :can-add="{{ $permissions['create-master_umkm'] }}" :can-edit="{{ $permissions['update-master_umkm'] }}" :can-delete="{{ $permissions['delete-master_umkm'] }}" />
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
                    {
                        text: 'Pengikut',
                        value: 'pengikut',
                    },    
                    {
                        text: 'Desc',
                        value: 'user_id',
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
    }).mount('#masterumkm');
</script>
@endsection