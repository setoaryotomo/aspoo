@extends('dashboard_layout.index')
@section('content')
<div class="page-inner" id="portaluser">
    <default-datatable title="PortalUser" url="{!! url('portaluser') !!}" :headers="headers" :can-add="{{ $permissions['create-portaluser'] }}" :can-edit="{{ $permissions['update-portaluser'] }}" :can-delete="{{ $permissions['delete-portaluser'] }}" />
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
    }).mount('#portaluser');
</script>
@endsection