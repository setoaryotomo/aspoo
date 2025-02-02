@extends('dashboard_layout.index')
@section('content')
<div class="page-inner" id="diskon">
    <default-datatable title="Diskon" url="{!! url('diskon') !!}" :headers="headers" :can-add="{{ $permissions['create-diskon'] }}" :can-edit="{{ $permissions['update-diskon'] }}" :can-delete="{{ $permissions['delete-diskon'] }}" >
            
    </default-datatable>
</div>

<script>
    createApp({
        data() {
            return {
                headers: [
                    {
                        text: 'Kode Diskon',
                        value: 'kode_diskon',
                    },    
                    {
                        text: 'Jumlah Diskon',
                        value: 'jumlah_diskon',
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
    }).mount('#diskon');
</script>
@endsection