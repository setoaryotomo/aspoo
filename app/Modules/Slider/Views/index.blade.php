@extends('dashboard_layout.index')
@section('content')
<div class="page-inner" id="slider">
    <default-datatable title="Slider" url="{!! url('slider') !!}" :headers="headers" :can-add="{{ $permissions['create-silder'] }}" :can-edit="{{ $permissions['update-silder'] }}" :can-delete="{{ $permissions['delete-silder'] }}" />
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
        						value: 'foto',
        						text: 'Foto'
    					},    
					{
        						value: 'keterangan',
        						text: 'Keterangan'
    					},    
					{
        						value: 'status',
        						text: 'Status'
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
    }).mount('#slider');
</script>
@endsection