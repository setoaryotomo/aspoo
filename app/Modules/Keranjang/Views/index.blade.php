@extends('dashboard_layout.index')
@section('content')
<div class="page-inner" id="keranjang">
    <default-datatable title="Keranjang" url="{!! url('keranjang') !!}" :headers="headers" :can-add="{{ $permissions['create-keranjang'] }}" :can-edit="{{ $permissions['update-keranjang'] }}" :can-delete="{{ $permissions['delete-keranjang'] }}" />
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
    }).mount('#keranjang');
</script>
@endsection