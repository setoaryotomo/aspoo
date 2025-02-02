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
                    style="font-size: 21px; color:#000; text-decoration: underline; text-decoration-color: red;"><i
                        class="bi bi-shop-window"></i><span style="margin-left: 8px;">TOKO</span></a>
            {{-- <li class="nav-item">
                <a href="{{ url('/p/listparcel') }}" class="nav-link active" aria-current="page"
                    style="font-size: 21px; color:#000; text-decoration:"><i class="bi bi-gift"></i><span
                        style="margin-left: 8px;">PAKET PARCEL</span></a>
            </li> --}}
            </li>
        </ul>
    </div>
    <div class="section-divider"></div>
    <br>
    <div class="container">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($results as $users_toko)
            <div class="col col-md-4">
                <div class="card mx-auto">
                    <img src="{{ asset('storage/' . $users_toko->detail->foto) }}" alt="{{ $users_toko->nama}}" class="card-img">
                    <div class="card-body">
                        <h5 class="card-title">{{ $users_toko->nama }}</h5>
                        {{-- <p class="card-text">Tautan: {{ $users_toko->tautan }}</p> --}}
                        @if($users_toko->detail && $users_toko->detail->kotaModel)
                        <p class="card-text daerah">{{ $users_toko->detail->kotaModel->name }}</p>
                        @else
                        <p class="card-text"></p>
                        @endif

                        {{-- <p class="card-text">Lokasi: {{ $users_toko->detail->alamat }}</p> --}}
                        <a href="{{ url('/p/toko/' . $users_toko->id) }}">Lihat Toko</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="pagination">
        {{ $results->links() }}
    </div>

    @endsection
