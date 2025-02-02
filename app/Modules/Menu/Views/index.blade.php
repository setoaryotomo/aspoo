@extends('dashboard_layout.index')
@section('content')
<div class="page-inner" id="app">
    <default-datatable title="Menu" url="{!! url('menu') !!}" :headers="headers" />
</div>

<script>
    createApp({
        data() {
            return {
                headers: [
                    {
                        text: 'id',
                        value: 'id',
                        align: 'center'
                    },
                    {
                        text: 'Nama Menu',
                        value: 'name',
                    },
                    {
                        text: 'Path',
                        value: 'path',
                    },
                    {
                        text: 'Description',
                        value: 'description',
                    },
                    {
                        text: 'Parent',
                        value: 'parent.name',
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
    }).mount('#app');
</script>
@endsection