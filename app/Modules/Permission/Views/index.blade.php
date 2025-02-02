@extends('dashboard_layout.index')
@section('content')
<div class="page-inner" id="permission-page">
    <default-datatable title="Role" url="{!! url('permission') !!}" :headers="headers" />
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
                        text: 'Code',
                        value: 'code',
                    },
                    {
                        text: 'Description',
                        value: 'description',
                    },
                    {
                        text: 'Menu',
                        value: 'menu.name',
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
    }).mount('#permission-page');
</script>
@endsection