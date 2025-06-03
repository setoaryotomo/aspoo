@extends('portal_layout.templates')
@section('content')
    <style>
        .detail-pengirim {
            align-items: center;
        }
        .right-column {
            position: sticky;
            top: 20px;
            height: fit-content;
            border-left: 1px solid #ddd;
            padding-left: 20px;
        }
        .payment-methods, .payment-details {
            margin-bottom: 20px;
        }
        .payment-methods label, .payment-details p {
            margin-bottom: 5px;
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
        /* .badge {
            background-color: black;
        } */
    </style>
    @php
        function rupiah($angka)
        {
            $rupiah = 'Rp ' . number_format($angka, 0, ',', '.');
            return $rupiah;
        }
        $totalHarga = 0;
    @endphp
    <main class="container" id="container" style="margin-top: 30px; font-size: 16px;">
        <div class="row">
            <!-- Left Column: List of Items -->
            <div class="col-md-8">
                <?php
                $iteration = 0;
                ?>
                @foreach ($data as $data_group_seller_id)
                @if ($data_group_seller_id[0]->barang->harga_user != null)
                    <div class="col-md-12 mb-1">
                        <span class="badge">{{ @$data_group_seller_id[0]->barang->user->nama }}</span>
                    </div>
                @endif
                <?php
                $totalHargaPerSeller = 0;
                $isParcel = $data_group_seller_id[0]->parcel_id != null;
                $parcelAddress = $isParcel ? json_decode($data_group_seller_id[0]->parcel->alamat, true) : null;
                ?>
                @foreach ($data_group_seller_id as $keranjang)
                    <?php $barang = $keranjang->barang; ?>
                    <div class="col-md-12">
                        <div class="card bg-light mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <img src="{{ $barang->thumbnail_readable }}" alt="Product Image"
                                            class="product-image" width="100">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="row justify-content-between">
                                            <div class="col-md-6">
                                                <p style="font-size: 18px"><b>{{ $barang->nama_barang }}</b></p>
                                            </div>
                                            <div class="col-md-6">
                                                @php
                                                    $satuanTotalHarga = $barang->harga_user * $keranjang->jumlah;
                                                    $totalHarga += $satuanTotalHarga;
                                                    $totalHargaPerSeller += $satuanTotalHarga;
                                                @endphp
                                                
                                                <p style="text-align: right">Total Harga: <b>{{ rupiah($satuanTotalHarga) }}</b></p>
                                                <p style="text-align: right">X {{ $keranjang->jumlah }}</p>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @if ($data_group_seller_id[0]->barang->harga_user != null)
                    <div class="col-md-12" @if($iteration !== count($data) - 1 && $isParcel) style="display: none;" @endif>
                        <div class="form-group">
                            <label>Pilih Pengiriman</label>
                            <select v-model="transaksi.ongkirData[{{ $iteration }}]" 
                                    @change="fetchRajaOngkir(transaksi.ongkirData[{{ $iteration }}],{{ $iteration }}, {{ $isParcel ? 'true' : 'false' }}, {{ $isParcel ? json_encode($parcelAddress) : 'null' }})"
                                    name="courier" id="courier" class="form-control" required>
                                <option value="jne">JNE</option>
                                <option value="pos">POS</option>
                                <option value="tiki">TIKI</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Pesan</label>
                            <input type="text" v-model="transaksi.pesan[{{ $iteration }}]" value=" "
                                name="pesan[]" class="form-control">
                        </div>
                        <hr class="border border-danger border-2 opacity-50">
                    </div>
                    <?php $iteration++; ?>
                @endif
            @endforeach
            </div>

            <!-- Right Column: Address, Payment Methods, and Checkout -->
            <div class="col-md-4 right-column">
                <!-- Address Section -->
                <div class="detail-pengirim mb-4">
                    <b>Alamat Pengiriman</b>
                    @php
                        $allFromParcel = collect($data)
                            ->flatten()
                            ->every(function ($item) {
                                return $item->parcel_id !== null;
                            });
                        $parcelsShown = collect();
                    @endphp
                    @foreach ($data as $datas_group_seller_id)
                        @if ($datas_group_seller_id[0]->parcel_id)
                            @php
                                $parcelAddress = json_decode($datas_group_seller_id[0]->parcel->alamat, true);
                            @endphp
                            <div class="alert alert-info mt-2">
                                <strong>Parcel Delivery Address:</strong><br>
                                {{ $parcelAddress['alamat_lengkap'] }}<br>
                                {{ $parcelAddress['kelurahan']['name'] }}, 
                                {{ $parcelAddress['kecamatan']['name'] }}, 
                                {{ $parcelAddress['kota']['name'] }}, 
                                {{ $parcelAddress['provinsi']['name'] }}
                            </div>
                            @break
                        @endif
                    @endforeach
                    @unless ($allFromParcel)
                        <p>
                            {{ $user->userMaster->name }} {{ @$user->telepon }} <br>
                            {{ $user->provinsiModel->name }} | {{ $user->kotaModel->name }} |
                            {{ $user->kecamatanModel->name }} | {{ $user->kelurahanModel->name }}
                        </p>
                    @endunless
                </div>


                <!-- Payment Details -->
                <div class="payment-details">
                    <h6><b>Rincian Pembayaran</b></h6>
                    <div class="row justify-content-between">
                        <div class="col-6">
                            <p>Subtotal Untuk Produk</p>
                        </div>
                        <div class="col-6 text-right">
                            {{ rupiah($totalHarga) }}
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="col-6">
                            <p>Subtotal Untuk Pengiriman</p>
                        </div>
                        <div class="col-6 text-right">
                            @{{ rupiah(totalPengiriman) }}
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="col-6">
                            <p>Kode Unik</p>
                        </div>
                        <div class="col-6 text-right">
                            {{ rupiah($kodeUnik) }}
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="col-6">
                            <p>Total Pembayaran</p>
                        </div>
                        <div class="col-6 text-right">
                            @{{ rupiah(parseInt(totalPembayaran) + totalPengiriman + parseInt(kodeUnik)) }}
                        </div>
                    </div>
                </div>

                <!-- Checkout Button -->
                <button style="background-color: black" class="btn-checkout" @click='saveCheckout()'>Bayar Sekarang</button>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        createApp({
            data() {
                return {
                    checkout: {
                        pesan: null,
                        ongkir: 20000,
                        alamat: "{{ $userdetail->alamat }}",
                    },
                    transaksi: {
                        ongkir: [],
                        pesan: [],
                        ongkirData: [],
                    },
                    rajaongkirData: 0,
                    totalPengiriman: 0,
                    totalPembayaran: "{{ $totalHarga }}",
                    kodeUnik: "{{ $kodeUnik }}",
                    defaultOngkir: 20000
                }
            },
            methods: {
                async fetchRajaOngkir(value, id, isParcel, parcelAddress) {
    try {
        showLoading();
        var data = {
            courier: value,
            is_parcel: isParcel,
            parcel_address: isParcel ? parcelAddress : null
        };

        // Validate parcel address if isParcel is true
        if (isParcel && (!parcelAddress || !parcelAddress.kota || !parcelAddress.kota.kota_rajaongkir)) {
            throw new Error("Invalid parcel address provided.");
        }

        const response = await httpClient.post("{{ url('p/checkout/rajaongkir') }}", data);
        if (response.data.result && response.data.result.results && response.data.result.results[0].costs) {
            this.transaksi.ongkir[id] = response.data.result.results[0].costs[0].cost[0].value;
            this.transaksi.ongkirData[id] = value;
            this.countTotalPembayaran();
        } else {
            throw new Error("Pilihan pengiriman tidak tersedia untuk toko ini.");
        }
        hideLoading();
    } catch (e) {
        hideLoading();
        console.log(e);

        // Set default ongkir instead of showing error
        this.transaksi.ongkir[id] = this.defaultOngkir;
        this.transaksi.ongkirData[id] = value;
        this.countTotalPembayaran();

        // Optionally notify the user
        showToast({
            message: `Pilihan pengiriman tidak tersedia. Menggunakan ongkir default sebesar ${this.rupiah(this.defaultOngkir)}.`,
            type: 'warning'
        });
    }
},
                countTotalPembayaran() {
                    this.totalPengiriman = 0;
                    this.transaksi.ongkir.forEach(e => {
                        if (e) {
                            this.totalPengiriman += parseInt(e);
                        }
                    });
                },
                rupiah(amount) {
                    const rupiahFormat = "Rp " + amount.toLocaleString("id-ID");
                    return rupiahFormat;
                },
                async saveCheckout() {
    try {
        showLoading();
        var data = {
            "checkout": this.checkout,
            "transaksi": this.transaksi,
            "totalPengiriman": this.totalPengiriman,
            "totalPembayaran": this.totalPembayaran,
            'kodeUnik': this.kodeUnik
        };
        // Use explicit route instead of url()->current()
        const response = await httpClient.post("{{ url('p/checkout') }}", data);
        console.log(response);
        hideLoading();
        showToast({
            message: "Data berhasil ditambahkan"
        });
        var data = response.data.result;
        window.location.href = data.midtrans_link;
    } catch (err) {
        hideLoading();
        showToast({
            message: err.message,
            type: 'error'
        });
    }
}
            }
        }).mount("#container");
    </script>
@endsection