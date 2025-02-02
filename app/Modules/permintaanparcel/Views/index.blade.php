@extends('dashboard_layout.index')
@section('content')
<div class="page-inner" id="permintaan-parcel">
    <default-datatable title="permintaanparcel" url="{!! url('permintaan-parcel') !!}" :headers="headers" :can-add="true" :can-edit="false" :can-delete="true" />
    <template #left-action="{ content }">
        <a :href="`{!! url('permintaan-parcel') !!}/preview/${content.id}`" class="btn btn-xs btn-info mr-1">
            Lihat Detail
        </a>
    </template>
</div>

<script>
    createApp({
        data() {
            return {
                headers: [
                    {
                        text: 'Username',
                        value: 'user.name',
                    },
                    {
                        text: 'Harga Yang Diinginkan',
                        value: 'harga',
                    },     
                    {
                        text: 'Berat Yang Diinginkan',
                        value: 'berat',
                    },    
                    {
                        text: 'Tanggal Dibutuhkan',
                        value: 'tanggal',
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
    }).mount('#permintaan-parcel');
</script>
@endsection