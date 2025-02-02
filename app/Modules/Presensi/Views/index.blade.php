@extends('dashboard_layout.index')
@section('content')
<div class="page-inner" id="presensi">
    <default-datatable title="Presensi" url="{!! url('presensi') !!}" :headers="headers" :can-add="{{ $permissions['create-presensi'] }}" :can-edit="{{ $permissions['update-presensi'] }}" :can-delete="{{ $permissions['delete-presensi'] }}" />
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
					{
        						value: 'nip',
        						text: 'NIP'
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
    }).mount('#presensi');
</script>
@endsection