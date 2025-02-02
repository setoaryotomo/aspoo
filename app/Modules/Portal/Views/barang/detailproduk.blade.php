@extends('portal_layout.templates')
@section('content')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .page-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .product-details {
            display: flex;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .product-image {
            flex: 1;
            max-width: 100%;
        }

        .product-image img {
            max-width: 100%;
            height: auto;
            object-fit: cover;
        }

        .product-info {
            flex: 2;
            padding-left: 20px;
            width: 50%;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .product-name {
            font-size: 18px;
            font-weight: 600;
        }

        .product-price {
            font-size: 15px;
            color: #FF5733;
        }

        .discount-label {
            font-size: 14px;
            font-weight: 400;
            color: #FBD9C0;
            margin-left: 10px;
        }

        .product-original-price {
            font-size: 14px;
            color: #999;
            text-decoration: line-through;
            margin-top: 5px;
        }

        .product-description {
            margin-top: 20px;
        }

        .product-description h3 {
            font-size: 18px;
            font-weight: 600;
        }

        .product-description p {
            margin-top: 10px;
        }

        .description-sections {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .description-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 5px 10px;
            background-color: #FFF;
            border: 1px solid #DDD;
            border-radius: 5px;
            transition: background-color 0.3s;
            cursor: pointer;
            margin-right: 10px;
            font-weight: 600;
            font-zize: 15px;
            color: #606C5D;
        }

        .description-section:hover {
            background-color: #606C5D;
            color: #FFF;
        }

        .description-content {
            display: none;
            margin-top: 10px;
            font-size: 14px;
            color: #606C5D;
        }

        .order-box {
            width: 20%;
            padding: 10px;
            margin-top: 20px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .order-title {
            font-size: 18px;
            font-weight: 400;
        }

        .order-quantity {
            margin-top: 5px;
        }

        .order-buttons {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .order-button {
            background-color: #606C5D;
            color: #fff;
            border: none;
            padding: 2px 4px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .order-button:hover {
            background-color: #5E745C;
        }

        .order-quantity {
            margin-top: 10px;
            display: flex;
            align-items: center;
            font-size: 14px;
        }

        .quantity-label {
            margin-right: 10px;
        }

        .stock-info {
            color: #FF6B6B;
            font-weight: bold;
            margin-top: 5px;
        }

        .total-price {
            margin-top: 20px;
            font-size: 18px;
            font-weight: 600;
        }

        .section-divider {
            margin-top: 40px;
            border-top: 2px solid #DDD;
        }

        .section2 {
            padding: 20px 0;
            text-align: left;
        }

        .store-card {
            display: flex;
            align-items: center;
        }

        .store-image {
            max-width: ;
        }

        .store-card .store-details {
            margin-left: 15px;
            text-align: left;
        }

        .store-card .store-name {
            font-size: 18px;
            font-weight: 600;
        }

        .store-card .store-rating,
        .store-card .store-location {
            margin-top: 5px;
        }

        .visit-store-button {
            margin-top: 10px;
            background-color: #606C5D;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .visit-store-button:hover {
            background-color: #5E745C;
        }

        .review {
            margin-top: 20px;
        }

        .customer-review {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
        }

        .customer-profile {
            display: flex;
            align-items: center;
        }

        .customer-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }

        .customer-name {
            font-weight: 600;
        }

        .review-content {
            margin-top: 10px;
        }

        .rating {
            color: #FF5733;
            margin-top: 5px;
        }

        .comment {
            margin-top: 5px;
        }

        .review-image img {
            max-width: 100%;
            max-height: 200px;
            margin-top: 10px;
        }

        .customer-review {
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .product-info {
                width: 100%;
            }

            .order-box {
                width: 100%;
            }
        }
    </style>
    </head>
    @php
        function rupiah($angka)
        {
            $rupiah = 'Rp. ' . number_format($angka, 0, ',', '.');
            return $rupiah;
        }
    @endphp

    <body>
        <div id="container" class="container mt-5">

            <div class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <span class="card-title">Detail Produk</span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="product-image">
                                                @if (strpos($data->thumbnail, 'https://') !== false)
                                                <img src="{{ $data->thumbnail }}" alt="Product Image">
                                                @else
                                                <img src="{{ $data->thumbnail_readable }}" alt="Product Image">
                                                @endif
                                            </div>

                                        </div>
                                        <div class="col-md-12">

                                            <div class="section2">
                                                <hr>

                                                <div class="store-card">
                                                    <div class="store-image">
                                                        <img style="max-width: 75px" src="{{ asset('storage/' . $data->user->detail->foto) }}" alt="Toko Image">
                                                        
                                                    </div>
                                                    <div class="store-details">
                                                        <div class="store-name">{{@$data->user->nama}}</div>
                                                        <div class="store-location">{{@$data->user->detail->alamat}}</div>
                                                        <div style="font-size: 8px;">{{@$data->user->user->username}}</div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h1 style="margin-bottom: 0px"><strong>{{ $data->nama_barang }}</strong></h1>
                                            <small>
                                                Terjual <span class="text-secondary">{{ $data->terjual }}</span>
                                            </small>
                                        </div>

                                        <div class="col-md-12 mt-3">
                                            <h1><strong>{{ rupiah($data->harga_user) }}</strong></h1>
                                        </div>
                                        <div class="col-md-12">
                                            <span class="badge badge-danger">{{ $data->diskon }}%</span> <span
                                                class="text-muted"><del>{{ rupiah($data->harga_user_asli) }}</del></span>
                                        </div>
                                    </div>
                                    <div class="product-description">
                                        <div class="description-sections">
                                            <div class="description-section">Detail</div>
                                            <div class="description-section">Info Penting</div>
                                        </div>
                                        <div class="description-content" id="detailContent">
                                            {{-- <img src="https://chart.googleapis.com/chart?cht=qr&chl={{$data->id}}&chs=180x180&choe=UTF-8&chld=L|2" ><br> --}}
                                                {!! $data->keterangan !!}<br>
                                                @if($data->panjang && $data->lebar && $data->tinggi)
                                                    Dimensi : {{ $data->panjang }} x {{ $data->lebar }} x {{ $data->tinggi }}<br>
                                                @endif
                                                                                    
                                                @if($data->berat)
                                                    Berat : {{ $data->berat }} Gram
                                                @endif
                                        </div>
                                        <div class="description-content" id="infoPentingContent">
                                                {!! $data->info_penting !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <span class="card-title">Atur Jumlah</span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-control">
                                        <div class="form-label">Quantity : </div>
                                        <input type="number" min="1" max="{{$data->stock_global}}" v-model="barang.jumlah" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <p><b>Stok Sisa :</b> {{ $data->stock_global }}</p>
                                </div>
                                <div class="col-md-12">
                                    <h3><b>Total Harga :</b> @{{ rupiah(Math.round(parseFloat(this.barang.harga)) * parseInt(this.barang.jumlah)) }}</h3>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button @click="tambahKeranjang()" class="btn btn-dark btn-block"> <span>Keranjang</span>
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            Vue.createApp({
                data() {
                    return {
                        barang: {
                            id: '{{ $data->id }}',
                            harga: '{{ $data->harga_user }}',
                            jumlah: 1,
                        }
                    }
                },
                methods: {
                    rupiah(amount) {
                        const rupiahFormat = "Rp " + amount.toLocaleString("id-ID");
                        return rupiahFormat;
                    },
                    async tambahKeranjang() {
                        try {
                            showLoading()
                            const response = await httpClient.post("{!! url('p/barang/keranjang') !!}/", {
                                barang_id: this.barang.id,
                                jumlah: this.barang.jumlah
                            })
                            hideLoading()
                            showToast({
                                message: "Data berhasil masuk keranjang!"
                            })
                        } catch (err) {
                            hideLoading()
                            showToast({
                                message: err.message,
                                type: 'error'
                            })
                        }
                    }
                },

            }).mount("#container")
        </script>
        <script>
            const detailSection = document.querySelector('.description-section:nth-child(1)');
            const infoPentingSection = document.querySelector('.description-section:nth-child(2)');
            const detailContent = document.getElementById('detailContent');
            const infoPentingContent = document.getElementById('infoPentingContent');

            detailSection.addEventListener('click', () => {
                detailSection.style.backgroundColor = '#606C5D';
                detailSection.style.color = '#FFF';
                infoPentingSection.style.backgroundColor = '#FFF';
                infoPentingSection.style.color = '#000';
                detailContent.style.display = 'block';
                infoPentingContent.style.display = 'none';
            });

            infoPentingSection.addEventListener('click', () => {
                infoPentingSection.style.backgroundColor = '#606C5D';
                infoPentingSection.style.color = '#FFF';
                detailSection.style.backgroundColor = '#FFF';
                detailSection.style.color = '#000';
                detailContent.style.display = 'none';
                infoPentingContent.style.display = 'block';
            });
        </script>
    @endsection
