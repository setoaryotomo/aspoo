@extends('dashboard_layout.index')
@section('content')
<div class="page-inner" id="pembelian">
    <default-datatable title="Pembelian" url="{!! url('pembelian') !!}" :headers="headers" :can-add="{{ $permissions['create-pembelian'] }}" :can-edit="{{ $permissions['update-pembelian'] }}" :can-delete="{{ $permissions['delete-pembelian'] }}" />
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
    }).mount('#pembelian');
</script>
@endsection