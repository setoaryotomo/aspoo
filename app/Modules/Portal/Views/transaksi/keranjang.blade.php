@extends('portal_layout.templates')
@section('content')
<style>
    /* Add this to your existing styles */
    .product-image {
        width: 80px;
        height: 80px;
        object-fit: contain; /* Ensures the image maintains aspect ratio */
        border: 1px solid #eee;
        padding: 5px;
        background: white;
        border-radius: 4px;
    }
    
    /* Keep your existing styles */
    .content {
        margin-bottom: 14rem;
    }
    .right-column {
        position: sticky;
        top: 20px;
        height: fit-content;
        padding-left: 20px;
        padding-top: 80px;
        /* border-left: 1px solid #ddd; */
    }
    .payment-box {
        margin-top: 20px;
    }
    .btn-checkout {
        width: 100%;
        background-color: #28a745;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
    }
    .btn-checkout:hover {
        background-color: #218838;
    }
    .total-section {
        margin-bottom: 10px;
    }
    .order-group {
        margin-bottom: 30px;
    }
    .order-group-title {
        padding: 10px;
        background-color: #f8f9fa;
        border-left: 4px solid #007bff;
        margin-bottom: 15px;
    }
    .parcel-group {
        margin-bottom: 25px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
    }
    .parcel-group-header {
        padding: 12px 15px;
        background-color: #f1f3f4;
        border-bottom: 1px solid #e0e0e0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .parcel-group-title {
        font-weight: 600;
        color: #495057;
        margin: 0;
    }
    .parcel-select-all {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: #6c757d;
    }
    .parcel-table-container {
        background-color: white;
    }
    .parcel-table-container table {
        margin-bottom: 0;
    }
    .parcel-info-row {
        padding: 10px 15px;
        background-color: #f8f9fa;
        border-bottom: 1px solid #e0e0e0;
    }
    .parcel-actions {
        padding: 10px 15px;
        text-align: right;
        background-color: #f8f9fa;
    }
</style>

<body class="preload-wrapper">
    <div class="preload preload-container">
        <div class="preload-logo">
            <div class="spinner"></div>
        </div>
    </div>
    <div class="container mt-5" id="container">
        
        <div class="frame">
            <div class="title">
                <h5><i class="fa-solid fa-cart-shopping"></i> Keranjang Belanja</h5>
            </div>
            <br>
            <div class="content">
                <div class="row">
                    <!-- Left Column: Cart Table -->
                    <div class="col-md-9">
                        <!-- Regular Orders (without parcel_id) -->
                        <div class="order-group" v-if="regularOrders.length > 0">
                            <h5 class="order-group-title">Pesanan</h5>
                            <div class="cart-box table-responsive">
                                <table id="table" class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">
                                                <input type="checkbox" v-model="selectAllRegular" @change="toggleSelectAllRegular">
                                            </th>
                                            <th scope="col">Foto Produk</th>
                                            <th scope="col">Nama Produk</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Jumlah</th>
                                            <th scope="col">Total</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="keranjang in regularOrders" :key="keranjang.id">
                                            <td>
                                                <input type="checkbox" v-model="keranjang.selected" @change="updateSelectAllRegular">
                                            </td>
                                            <td>
                                                <img :src="keranjang.barang.thumbnail_readable" 
                                                    alt="Product" 
                                                    style="width: 100px;">
                                            </td>
                                            <td>@{{ keranjang.barang.nama_barang }}</td>
                                            <td class="product-price">@{{ rupiah(keranjang.barang.harga_user) }}</td>
                                            <td>
                                                <input class="form-control-sm form-control" type="number" name="quantity"
                                                    value="1" min="1" v-model="keranjang.jumlah" @change="updateCartItem(keranjang)">
                                            </td>
                                            <td><span class="total-sar">@{{ rupiah(keranjang.barang.harga_user * keranjang.jumlah) }}</span></td>
                                            <td><button @click="hapusKeranjang(keranjang.id)" class="btn btn-danger">Hapus</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Parcel Orders (grouped by parcel_id) -->
                        <div class="order-group" v-if="Object.keys(groupedParcelOrders).length > 0">
                            <h5 class="order-group-title">Pesanan Parcel</h5>
                            
                            <!-- Loop through each parcel group -->
                            <div class="parcel-group" v-for="(parcelItems, parcelId) in groupedParcelOrders" :key="parcelId">
                                <div class="parcel-group-header">
                                    <h6 class="parcel-group-title">Parcel ID: @{{ parcelId }}</h6>
                                    <div class="parcel-select-all">
                                        <input type="checkbox" 
                                               :id="'select-parcel-' + parcelId"
                                               v-model="parcelSelectAll[parcelId]" 
                                               style="display: none"
                                               @change="toggleSelectParcelGroup(parcelId)">
                                        <label :for="'select-parcel-' + parcelId" class="mb-0">Pilih Semua</label>
                                    </div>
                                </div>
                                
                                <!-- Parcel info row (quantity and delete button) -->
                                <div class="parcel-info-row">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Jumlah:</strong> @{{ parcelItems[0].jumlah }} <!-- Taking quantity from first item -->
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <button @click="hapusParcel(parcelItems)" class="btn btn-danger btn-sm">Hapus Parcel</button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="parcel-table-container">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">
                                                        <input type="checkbox"
                                                               v-model="parcelSelectAll[parcelId]"
                                                               style="display: none" 
                                                               @change="toggleSelectParcelGroup(parcelId)">
                                                    </th>
                                                    <th scope="col">Foto Produk</th>
                                                    <th scope="col">Nama Produk</th>
                                                    <th scope="col">Harga</th>
                                                    {{-- <th scope="col">Subtotal</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="keranjang in parcelItems" :key="keranjang.id">
                                                    <td>
                                                        <input type="checkbox" 
                                                               v-model="keranjang.selected" 
                                                               style="display: none" 
                                                               @change="updateParcelGroupSelection(parcelId)">
                                                    </td>
                                                    <td>
                                                        <img :src="keranjang.barang.thumbnail_readable" 
                                                            alt="Product" 
                                                            style="width: 100px;">
                                                    </td>
                                                    <td>@{{ keranjang.barang.nama_barang }}</td>
                                                    <td class="product-price">@{{ rupiah(keranjang.barang.harga_user) }}</td>
                                                    {{-- <td>@{{ rupiah(keranjang.barang.harga_user * keranjang.jumlah) }}</td> --}}
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Empty Cart Message -->
                        <div v-if="keranjangList.length === 0" class="py-5">
                            <p>Keranjang belanja Anda kosong</p>
                            {{-- <p>Silakan tambahkan produk ke keranjang belanja Anda</p> --}}
                        </div>
                    </div>

                    <!-- Right Column: Total and Checkout Button -->
                    <div class="col-md-3 right-column" v-if="keranjangList.length > 0">
                        <div class="payment-box">
                            <div class="payment-info">
                                <div class="payment-section total-section">
                                    <b>Total: <span class="payment-amount"
                                            id="total">@{{ totalKeranjang() }}</span></b><br>
                                    <small class="text-secondary">*Total belum termasuk biaya ongkir</small>
                                </div>
                            </div>
                            <button style="background-color: black" class="btn-checkout" @click="checkout()">Checkout</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Barcode Scanning -->
        <div class="modal fade bd-example-modal-lg" id="modalBarcode" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        OSKDOKAs
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label">Kode Barcode</label>
                                    <input v-model="barcode.id" class="form-control" v-on:keyup="barcodeKeyUp">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row" v-if="barcode.showData">
                                    <div class="col-md-12"><h1>Data Barang</h1></div>
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-block" @click="saveKode()">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

    <script src="{!! asset('js/bootstrap.min.js') !!}"></script>
    <script src="{!! asset('js/jquery.min.js') !!}"></script>
    <script src="{!! asset('js/swiper-bundle.min.js') !!}"></script>
    <script src="{!! asset('js/carousel.js') !!}"></script>
    <script src="{!! asset('js/bootstrap-select.min.js') !!}"></script>
    <script src="{!! asset('js/lazysize.min.js') !!}"></script>
    <script src="{!! asset('js/bootstrap-select.min.js') !!}"></script>
    <script src="{!! asset('js/count-down.js') !!}"></script>
    <script src="{!! asset('js/wow.min.js') !!}"></script>
    <script src="{!! asset('js/multiple-modal.js') !!}"></script>
    <script src="{!! asset('js/shop.js') !!}"></script>
    <script src="{!! asset('js/nouislider.min.js') !!}"></script>
    <script src="{!! asset('js/main.js') !!}"></script>

    <script>
        let keranjangController = new AbortController();
        createApp({
            data() {
                return {
                    keranjangList: [],
                    userRole: null,
                    keranjangTotal: 0,
                    selectAllRegular: false,
                    selectAllParcel: false,
                    parcelSelectAll: {}, // Object to track select all state for each parcel group
                    barcode: {
                        showData: false,
                        data: {},
                        id: null
                    },
                };
            },
            computed: {
                regularOrders() {
                    return this.keranjangList.filter(item => !item.parcel_id);
                },
                parcelOrders() {
                    return this.keranjangList.filter(item => item.parcel_id);
                },
                groupedParcelOrders() {
                    const grouped = {};
                    this.parcelOrders.forEach(item => {
                        const parcelId = item.parcel_id;
                        if (!grouped[parcelId]) {
                            grouped[parcelId] = [];
                        }
                        grouped[parcelId].push(item);
                    });
                    return grouped;
                }
            },
            methods: {
                async deleteWithPost(url, data = {}) {
                    return await httpClient.post(url, {
                        ...data,
                        _method: 'DELETE'
                    });
                },
                async updateWithPost(url, data = {}) {
                        return await httpClient.post(url, {
                            ...data,
                            _method: 'PATCH'
                        });
                    },
                async requestWithPost(url, data = {}, method = 'POST') {
                    const requestData = method === 'POST' ? data : {
                        ...data,
                        _method: method
                    };
                    
                    return await httpClient.post(url, requestData);
                },
                async hapusParcel(parcelItems) {
                    try {
                        showLoading();
                        
                        // Delete each item in the parcel group individually
                        const deletePromises = parcelItems.map(item => 
                            this.deleteWithPost(`{{ url('') }}/p/keranjang/${item.id}`)
                        );
                        
                        // Wait for all deletions to complete
                        await Promise.all(deletePromises);
                        
                        // Refresh data after all items are deleted
                        await this.fetchData();
                        await this.fetchUserRole();
                        
                        // Clear session to ensure checkout data is refreshed
                        await httpClient.post('{{ url('p/keranjang') }}', { 
                            data: JSON.stringify({ data_keranjang: [] }) 
                        });
                        
                        hideLoading();
                        showToast({
                            message: "Parcel berhasil dihapus!"
                        });
                    } catch (err) {
                        hideLoading();
                        showToast({
                            message: err.message || "Gagal menghapus parcel",
                            type: 'error'
                        });
                    }
                },
                async barcodeKeyUp() {
                    try {
                        keranjangController.abort();
                    } catch (err) {
                        console.log(err);
                    }
                    var barcode = this.barcode.id;
                    keranjangController = new AbortController();
                    showLoading();
                    const response = await httpClient.get(`{!! url('') !!}/p/barang/check`, {
                        signal: keranjangController.signal,
                        params: { barcode },
                    });
                    hideLoading();
                    this.barcode.showData = true;
                    this.barcode.data = response.data.result;
                },
                async scan() {
                    $('#modalBarcode').modal('show');
                },
                async updateCartItem(keranjang) {
                    try {
                        showLoading();
                        await this.updateWithPost(`{{ url('') }}/p/keranjang/${keranjang.id}`, {
                             jumlah: keranjang.jumlah
                         });
                        hideLoading();
                    } catch (err) {
                        hideLoading();
                        showToast({
                            message: err.message,
                            type: 'error'
                        });
                    }
                },
                async checkout() {
                    try {
                        showLoading();
                        // Filter selected items from both regular and parcel orders
                        const selectedKeranjang = this.keranjangList.filter(item => item.selected);
                        if (selectedKeranjang.length === 0) {
                            hideLoading();
                            showToast({
                                message: "Pilih setidaknya satu item untuk checkout!",
                                type: 'error'
                            });
                            return;
                        }

                        // Prepare data for checkout
                        const all = {
                            data_keranjang: selectedKeranjang,
                            keranjang_total: this.keranjangTotal
                        };
                        const data = {
                            data: JSON.stringify(all)
                        };

                        // Send selected items to backend
                        const response = await httpClient.post(`{{ url('') }}/p/keranjang`, data);

                        hideLoading();
                        showToast({
                            message: "Berhasil checkout!"
                        });
                        window.location.href = "{{ url('') }}/p/checkout";
                    } catch (err) {
                        hideLoading();
                        showToast({
                            message: err.message,
                            type: 'error'
                        });
                    }
                },
                totalKeranjang() {
                    this.keranjangTotal = 0;
                    this.keranjangList.forEach(keranjang => {
                        if (keranjang.selected) {
                            this.keranjangTotal += keranjang.jumlah * keranjang.barang.harga_user;
                        }
                    });
                    return this.rupiah(this.keranjangTotal);
                },
                rupiah(amount) {
                    const rupiahFormat = "Rp." + amount.toLocaleString("id-ID");
                    return rupiahFormat;
                },
                
                async hapusKeranjang(id) {
                    try {
                        showLoading();
                        const response = await this.deleteWithPost(`{{ url('') }}/p/keranjang/${id}`);
                        await this.fetchData();
                        await this.fetchUserRole();
                        // Clear session to ensure checkout data is refreshed
                        await httpClient.post('{{ url('p/keranjang') }}', { data: JSON.stringify({ data_keranjang: [] }) });
                        hideLoading();
                        showToast({
                            message: "Data berhasil dihapus!"
                        });
                    } catch (err) {
                        hideLoading();
                        showToast({
                            message: err.message,
                            type: 'error'
                        });
                    }
                },
                async fetchData() {
                    const response = await httpClient.post('{{ url('') }}/p/keranjang/data');
                    this.keranjangList = response.data.result.map(item => ({
                        ...item,
                        selected: false // Initialize selected state
                    }));
                    this.keranjangTotal = 0;
                    console.log(this.keranjangList);

                    // Initialize parcel select all states
                    this.initializeParcelSelectAll();
                },
                async fetchUserRole() {
                    const response = await httpClient.post('{{ url('') }}/p/user-role');
                    this.userRole = response.data.result;
                    console.log("Role User", this.userRole);
                },
                initializeParcelSelectAll() {
                    const parcelIds = [...new Set(this.parcelOrders.map(item => item.parcel_id))];
                    const newParcelSelectAll = {};
                    parcelIds.forEach(parcelId => {
                        newParcelSelectAll[parcelId] = false;
                    });
                    this.parcelSelectAll = newParcelSelectAll;
                },
                toggleSelectAllRegular() {
                    this.regularOrders.forEach(item => {
                        item.selected = this.selectAllRegular;
                    });
                    this.totalKeranjang();
                },
                updateSelectAllRegular() {
                    this.selectAllRegular = this.regularOrders.length > 0 && 
                        this.regularOrders.every(item => item.selected);
                    this.totalKeranjang();
                },
                toggleSelectParcelGroup(parcelId) {
                    const parcelItems = this.groupedParcelOrders[parcelId];
                    const selectAll = this.parcelSelectAll[parcelId];

                    parcelItems.forEach(item => {
                        item.selected = selectAll;
                    });
                    this.totalKeranjang();
                },
                updateParcelGroupSelection(parcelId) {
                    const parcelItems = this.groupedParcelOrders[parcelId];
                    const allSelected = parcelItems.every(item => item.selected);

                    this.parcelSelectAll[parcelId] = allSelected;
                    this.totalKeranjang();
                },
                toggleSelectAllParcel() {
                    this.parcelOrders.forEach(item => {
                        item.selected = this.selectAllParcel;
                    });
                    
                    // Update all parcel group select all states
                    Object.keys(this.parcelSelectAll).forEach(parcelId => {
                        this.parcelSelectAll[parcelId] = this.selectAllParcel;
                    });
                    
                    this.totalKeranjang();
                },
                updateSelectAllParcel() {
                    this.selectAllParcel = this.parcelOrders.length > 0 && 
                        this.parcelOrders.every(item => item.selected);
                    this.totalKeranjang();
                }
            },
            async created() {
                await this.fetchData();
                await this.fetchUserRole();
            },
            watch: {
                keranjangList: {
                    handler() {
                        this.totalKeranjang();
                        this.initializeParcelSelectAll();
                    },
                    deep: true
                }
            }
        }).mount('#container');
    </script>
@endsection