@extends('dashboard_layout.index')
@section('content')

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div class="page-inner" id="data-barang">
    <div class="filter-section mb-3">
        <div class="row">
            <div class="col-md-3">
                <select v-model="filters.produsen" class="form-control select2-produsen" @change="applyFilters">
                    <option value="">Semua Produsen</option>
                    @foreach($produsenList as $prod)
                        <option value="{{ $prod }}">{{ $prod }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select v-model="filters.user_id" class="form-control select2-umkm" @change="applyFilters">
                    <option value="">Semua UMKM</option>
                    @foreach($umkmList as $umkm)
                        <option value="{{ $umkm->user_id }}">{{ $umkm->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select v-model="filters.kategori_umum" class="form-control select2-kategori" @change="applyFilters">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoriList as $kategori)
                        <option value="{{ $kategori }}">{{ $kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button @click="exportPDF" class="btn btn-primary btn-block">
                    <i class="fas fa-file-pdf"></i> Cetak Laporan
                </button>
            </div>
        </div>
    </div>
    
    <default-datatable 
        title="DataBarang" 
        url="{!! url('data-barang') !!}" 
        :headers="headers"
        :can-add="{{ $permissions['create-data_barang'] }}"
        :can-edit="{{ $permissions['update-data_barang'] }}"
        :can-delete="{{ $permissions['delete-data_barang'] }}"
        :can-export="false"
        :filters="filters"
        ref="datatable"
    >
    <template #left-action="{ content }">
        <a :href="`{!! url('data-barang') !!}/inputstok/${content.id}`" class="btn btn-xs btn-success mr-1"><i class="fa fa-archive" aria-hidden="true"></i></a>
        <a style="color: white" :href="`{!! url('data-barang') !!}/komposisi/${content.id}`" class="btn btn-xs btn-info mr-1"><i class="fa fa-list" aria-hidden="true"></i></a>

    </template>
    </default-datatable>
</div>

<script>
    createApp({
        data() {
            return {
                headers: [
                    {
                        text: 'Nama Barang',
                        value: 'nama_barang',
                    },    
                    {
                        text: 'Harga Umum',
                        value: 'harga_umum',
                    },    
                    {
                        text: 'Stok',
                        value: 'stock_global',
                    },  
                    {
                        text: 'Berat (gram)',
                        value: 'berat',
                    }, 
                    {
                        text: 'UMKM',
                        value: 'user.nama',
                    },  
                ],
                filters: {
                    produsen: '',
                    user_id: '',
                    kategori_umum: ''
                }
            }
        },
        created() {},
        mounted() {
            $('.select2-produsen').select2({
                placeholder: "Cari produsen...",
                allowClear: true
            }).on('change', () => {
                this.filters.produsen = $('.select2-produsen').val();
                this.applyFilters();
            });
            
            $('.select2-umkm').select2({
                placeholder: "Cari UMKM...",
                allowClear: true
            }).on('change', () => {
                this.filters.user_id = $('.select2-umkm').val();
                this.applyFilters();
            });

            $('.select2-kategori').select2({
                placeholder: "Cari kategori...",
                allowClear: true
            }).on('change', () => {
                this.filters.kategori_umum = $('.select2-kategori').val();
                this.applyFilters();
            });
        },
        methods: {
            applyFilters() {
                this.$refs.datatable.refresh();
            },
            exportPDF() {
                let params = new URLSearchParams();
                if (this.filters.produsen) params.append('produsen', this.filters.produsen);
                if (this.filters.user_id) params.append('user_id', this.filters.user_id);
                if (this.filters.kategori_umum) params.append('kategori_umum', this.filters.kategori_umum);
                
                window.open('{!! url("data-barang/export-pdf") !!}?' + params.toString(), '_blank');
            }
        },
        components: {
            ...commonComponentMap(
                [
                    'DefaultDatatable',
                ]
            )
        },
    }).mount('#data-barang');
</script>

<style>
    .select2-container .select2-selection--single {
        height: 37px;
        padding-top: 4px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 35px;
    }
</style>
@endsection