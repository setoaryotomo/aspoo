@extends("portal_layout.templates")
@section("content")
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    body {
        font-family: 'Poppins';
    }

    p {
        margin-bottom: 0;
    }

    .custom-margin {
        margin-top: 121px;
        margin-bottom: 50px;
    }

    .custom-card {
        margin-left: 202px;
    }

    .card {
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        min-height: 330px;
        max-height: 330px;
    }

    .card-img {
        width: 100%;
        height: 170px;
        object-fit: cover;
    }

    .card-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
        
    }

    .card-text {
        font-size: 16px;
        color: #333;
        margin-bottom: 8px;
        text-transform: capitalize;
    }

    a.btn {
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: bold;
        transition: background-color 0.2s;
    }

    a.btn:hover {
        background-color: #0056b3;
    }

    .section-divider {
        border-top: 2px solid #e0e0e0;
        margin-top: 10px;
        margin-left: 75px;
        margin-right: 75px;
    }
    .daerah {
        text-transform: capitalize;
        font-size: 13px;
    }

    /* .card-body {
        overflow: auto;
        height: auto;
    } */

    .pagination {
        margin-left: 40px;
    }

    @media (max-width: 768px) {
        .pagination {
            margin-left: 60px;
        }
    }

    @media (max-width: 576px) {
        .pagination {
            margin-left: 6px;
        }
    }

</style>
</head>

<body>
    <div class="container custom-margin">
        <ul class="nav">
            <li class="nav-item">
                <a href="{{ url('/p/listbarang')}}" class="nav-link active" aria-disabled="true"
                    style="font-size: 21px; color:#000"><i class="bi bi-archive"></i><span
                        style="margin-left: 8px;"></i>PRODUK</a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/p/listtoko')}}" class="nav-link active" aria-current="page"
                    style="font-size: 21px; color:#000; text-decoration: ;"><i
                        class="bi bi-shop-window"></i><span style="margin-left: 8px;">TOKO</span></a>
            <li class="nav-item">
                <a href="{{ url('/p/listparcel') }}" class="nav-link active" aria-current="page"
                    style="font-size: 21px; color:#000; text-decoration: underline; text-decoration-color: red;"><i class="bi bi-gift"></i><span
                        style="margin-left: 8px;">PAKET PARCEL</span></a>
            </li>
            </li>
        </ul>
    </div>
    <div class="section-divider"></div>
    <br>
    <div class="container">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @if($parcels->isEmpty())
                <div class="content-container">
                    <h1>Paket Parcel Kosong</h1>
                </div>
            @else
                @foreach($parcels as $index => $parcel)
                    <div class="content-container">
                        <h2><a href="{{ url('/p/paketparcel/' . $parcel->id) }}">Parcel: {{ $parcel->barang }}</a></h2>
    
                        @if($parcel->parcel_children->isEmpty())
                            <p>Kosong</p>
                        @else
                            @php
                                $totalHargaParcel = 0; // Inisialisasi total harga
                            @endphp
    
                            @foreach($parcel->parcel_children as $child)
                                <div class="product-details">
                                    <div class="product-name"><b>{{ $child->barang->nama_barang }}</b></div>
                                    <p>Dimensi: {{ $child->barang->panjang }} x {{ $child->barang->lebar }} x {{ $child->barang->tinggi }}</p>
                                    <p>Harga: Rp. {{ number_format($child->barang->harga_user, 2) }}
                                        {{-- {{ number_format($child->barang->harga_umum - ($child->barang->harga_umum * ($child->barang->diskon / 100)), 0, ',', '.') }} --}}
                                    </p>
                                    @php
                                        // Tambahkan harga barang setelah diskon ke total
                                        $totalHargaParcel += $child->barang->harga_user;
                                    @endphp
                                </div>
                            @endforeach
                            <p><b>Total Harga Parcel: Rp. {{ number_format($totalHargaParcel, 2) }}</b></p>
                            {{-- <a href="{{ url('/p/paketparcel/' . $parcel->id) }}">Lihat</a> --}}
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    

    <div class="pagination">
        {{ $parcels->links() }}
    </div>

    @endsection
