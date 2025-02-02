@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner" id="komposisi">
        <default-datatable title="Data Supplier " url="{!! url()->current() !!}" :headers="headers"
            :can-add="{{true }}" :can-edit="{{true }}"
            :can-delete="{{true }}">
        </default-datatable>
    </div>

    <script>
        createApp({
            data() {
                return {
                    headers: [{
                        text: 'Nama',
                        value: 'nama',
                    }, ],
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
        }).mount('#komposisi');
    </script>
@endsection
