@extends('portal_layout.templates')
@section('content')

    <head>
        <style>
            .content {
                margin-bottom: 14rem;
            }
        </style>
    </head>
    <div class="container mt-5" id="container">
        <div class="frame">
            <div class="title">
                <h2>Keranjang Belanja</h2>
            </div>

            <div class="content">
                <div class="cart-box table-responsive">
                    <table id="table" class="table">
                        <thead>
                            <tr>
                                <th scope="col">Foto Produk</th>
                                <th scope="col">Nama Produk</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Total</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="keranjang in keranjangList ">
                                <td><img :src="keranjang.barang.thumbnail.includes('https://') ? keranjang.barang.thumbnail : keranjang.barang.thumbnail_readable" 
                                    alt="Product" 
                                    style="width: 100px;">                               
                                </td>
                                <td>@{{ keranjang.barang.nama_barang }}</td>
                                <td class="product-price">@{{ rupiah(keranjang.barang.harga_user) }}</td>
                                <td>
                                    <input class="form-control-sm form-control" type="number" name="quantity"
                                        value="1" min="1" v-model="keranjang.jumlah">
                                </td>
                                <td><span class="total-sar">@{{ rupiah(keranjang.barang.harga_user * keranjang.jumlah) }}</span></td>
                                <td><button @click="hapusKeranjang(keranjang.id)" class="btn btn-danger">Hapus</button></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="payment-box float-right">
                    <div class="payment-info">
                        <div class="payment-section total-section">
                            <b>Total Sementara: <span class="payment-amount"
                                    id="total">@{{ totalKeranjang() }}</span></b><br>
                            <small class="text-secondary">*Total belum termasuk biaya ongkir</small>
                        </div>
                    </div><br>
                    <button class="btn btn-primary btn-block" @click="checkout() ">Checkout</button>
                    {{-- <button class="btn btn-danger btn-block" @click="scan() ">Scan QR Code</button> --}}
                </div>
            </div>
        </div>
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
                                    <div class="col-md-6">

                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary btn-block" @click="saveKode() ">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let keranjangController = new AbortController();
        createApp({
            data() {
                return {
                    keranjangList: [],
                    userRole: null,
                    keranjangTotal: 0,
                    barcode: {
                        showData : false,
                        data : {},
                        id : null
                    },
                };
            },
            methods: {
                async barcodeKeyUp(){
                    try{
                        keranjangController.abort();
                    }catch(err){console.log(err)}

                    var barcode = this.barcode.id;
                    keranjangController = new AbortController();
                    showLoading();
                    const response = await httpClient.get(`{!! url('') !!}/p/barang/check`, {
                        signal: keranjangController.signal,
                        params: { barcode },
                    });
                    hideLoading();
                    this.barcode.showData =true;
                    this.barcode.data = response.data.result;
                    

                    
                },
                async scan() {
                    $('#modalBarcode').modal('show')

                },
                async checkout() {
                    try {
                        showLoading()
                        var all = {
                            data_keranjang: this.keranjangList,
                            keranjang_total: this.keranjangTotal
                        }
                        data = {
                            data: JSON.stringify(all)
                        }
                        const response = await httpClient.post(`{{ url('') }}/p/keranjang`, data)
                        hideLoading()
                        showToast({
                            message: "Berhasil checkout! Anda akan diarahkan ke halaman Checkout"
                        })
                        window.location.href = "{{ url('') }}/p/checkout"

                    } catch (err) {
                        hideLoading()
                        showToast({
                            message: err.message,
                            type: 'error'
                        })
                    }
                },
                totalKeranjang() {
                    this.keranjangTotal = 0;
                    this.keranjangList.map(keranjang => {
                        this.keranjangTotal += keranjang.jumlah * keranjang.barang.harga_user
                    })

                    return this.rupiah(this.keranjangTotal)
                },
                rupiah(amount) {
                    const rupiahFormat = "Rp " + amount.toLocaleString("id-ID");
                    return rupiahFormat;
                },
                async hapusKeranjang(id) {
                    try {
                        showLoading()
                        const response = await httpClient.delete(`{{ url('') }}/p/keranjang/${id}`)
                        await this.fetchData()
                        await this.fetchUserRole()
                        hideLoading()
                        showToast({
                            message: "Data berhasil dihapus!"
                        })


                    } catch (err) {
                        hideLoading()
                        showToast({
                            message: err.message,
                            type: 'error'
                        })
                    }
                },
                async fetchData() {
                    const response = await httpClient.post('{{ url('') }}/p/keranjang/data')
                    this.keranjangList = response.data.result;
                    this.keranjangTotal = 0;
                    console.log(this.keranjangList)

                },
                async fetchUserRole() {
                    const response = await httpClient.post('{{ url('') }}/p/user-role')
                    this.userRole = response.data.result;
                    console.log("ROle User", this.userRole)
                }
            },
            async created() {
                await this.fetchData();
                await this.fetchUserRole();
            },
            watch: {}
        }).mount('#container');
    </script>
@endsection
