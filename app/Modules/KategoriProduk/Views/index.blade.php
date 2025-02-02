@extends('dashboard_layout.index')
@section('content')
    <div class="page-inner" id="kategoriproduk">
        <default-datatable title="KategoriProduk" url="{!! url('kategoriproduk') !!}" :headers="headers"
            :can-add="{{ $permissions['create-kategori_produk'] }}" :can-edit="{{ $permissions['update-kategori_produk'] }}"
            :can-delete="{{ $permissions['delete-kategori_produk'] }}">
            <template #left-action="{ content }">
                <button @click="handlePermissionButtonClick(content.id)" type="button" class="btn btn-xs btn-info mr-1"
                    data-toggle="modal">
                    Atur Kategori
                </button>
            </template>
        </default-datatable>
        <div ref="modal" class="modal fade" id="addPermissionModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kategori Produk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-sm-12 mb-2">
                                    <vue-multiselect v-model="selectedKategoriProdukId" :searchable="true"
                                        :options="kategori_produk_list" placeholder="Pilih Barang" mode="tags" />
                                </div>

                                <div class="col-sm-12">
                                    <div v-if="isAddingPermission" class="loader loader-lg"></div>
                                    <button v-if="!isAddingPermission" @click="handleAddPermissionButtonClick"
                                        type="button" class="btn btn-sm btn-primary btn-block mb-2">
                                        Tambah Kategori Produk
                                    </button>
                                </div>
                            </div>
                            <default-datatable ref="permissionTable" v-if="selectedRoleId != null" title=""
                            :url="`{!! url('kategoriproduk') !!}/listkategori/${selectedRoleId}`" :key="selectedRoleId"
                            :headers="barangHeaders" :can-add="false" :can-edit="false">
                            <template #description={content}>
                                @{{ content.barang_id }}
                            </template>
                        </default-datatable>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        createApp({
            data() {
                return {
                    isAddingPermission: false,
                    selectedRoleId: null,
                    headers: [{
                            text: 'Id',
                            value: 'id',
                        },
                        {
                            value: 'nama',
                            text: 'Nama'
                        },
                    ],
                    kategori_produk_list: [],
                    barangHeaders: [{
                            text: 'id',
                            value: 'barang.id',
                        },
                        {
                            text: 'Nama Barang',
                            value: 'barang.nama_barang',
                        },
                    ],
                }
            },
            async created() {
                await this.fetchKategoriProduk()
            },
            methods: {
                async fetchKategoriProduk() {
                    const response = await httpClient.get('{{ url('') }}/data-barang/all')
                    this.kategori_produk_list = response.data.result.map(el => {
                        return {
                            value: el.id,
                            label: el.nama_barang
                        }
                    })
                },
                async handlePermissionButtonClick(roleId) {
                    this.selectedRoleId = roleId
                    $('#addPermissionModal').modal()
                },
                async handleAddPermissionButtonClick() {
                    this.isAddingPermission = true;
                    try {
                        await httpClient.post(`{{ url('') }}/kategoriproduk/setkategori`, {
                            kategori_produk_id: this.selectedRoleId,
                            barang_id: this.selectedKategoriProdukId
                        })
                        this.selectedKategoriProdukId = null;
                        this.isAddingPermission = false;
                    } catch (err) {
                        console.log(err)
                        this.isAddingPermission = false
                    }
                },
            },
            components: {
                ...commonComponentMap(
                    [
                        'DefaultDatatable',
                    ]
                ),
                'vue-multiselect': VueformMultiselect

            },
        }).mount('#kategoriproduk');
    </script>
@endsection
