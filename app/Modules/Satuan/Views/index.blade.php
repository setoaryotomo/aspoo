@extends('dashboard_layout.index')
@section('content')
<div class="page-inner" id="satuan">
    <default-datatable title="Satuan" url="{!! url('satuan') !!}" :headers="headers" :can-add="{{ $permissions['create-satuan'] }}" :can-edit="{{ $permissions['update-satuan'] }}" :can-delete="{{ $permissions['delete-satuan'] }}" />
</div>

<script>
    createApp({
        data() {
            return {
                headers: [
                        {
                            text: 'Satuan Nama',
                            value: 'satuan_nama',
                        },    
                        {
                            text: 'Satuan Simbol',
                            value: 'satuan_simbol',
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
    }).mount('#satuan');
</script>
@endsection