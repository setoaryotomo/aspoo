@extends('dashboard_layout.index')
@section('content')
<div class="page-inner" id="cabang">
    <default-datatable title="cabang" url="{!! url('cabang') !!}" :headers="headers" :can-add="false" :can-edit="false" :can-delete="false" />
    
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
                        text: 'Alamat',
                        value: 'alamat',
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
    }).mount('#cabang');
</script>
@endsection