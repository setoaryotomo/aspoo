@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner" id="komposisi">
        <default-datatable title="Komposisi" url="{!! url('komposisi') !!}" :headers="headers"
            :can-add="{{ $permissions['create-komposisi'] }}" :can-edit="{{ $permissions['update-komposisi'] }}"
            :can-delete="{{ $permissions['delete-komposisi'] }}">
            <template #left-action="{ content }">
            </template>
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
