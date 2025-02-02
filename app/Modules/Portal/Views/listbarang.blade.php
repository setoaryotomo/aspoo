@extends('portal_layout.templates')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
    }
    p {
        margin-bottom: 0;
    }
    .card {
        min-height: 300px;
        max-height: 300px;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
        /* overflow: hidden; */
    }

    .card:hover {
        transform: translateY(-5px);
        /* Menggeser kartu ke atas saat disorot */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Menambahkan bayangan saat disorot */
    }

    .custom-margin {
        margin-top: 121px;
    }

    .space {
        width: 150px;
    }

    .category-title {
        font-size: 18px;
        margin-top: 20px;
    }

    .section-divider {
        border-top: 2px solid #e0e0e0;
        margin-top: 10px;
        margin-bottom: 30px;
        margin-left: 75px;
        margin-right: 75px;
    }

    .section-heading {
        color: #000;
        font-family: Poppins;
        font-size: 30px;
        font-style: normal;
        font-weight: 600;
        line-height: 24px;
        /* 48% */
    }

    .carouselslide {
        margin-top: 148px;
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: auto;
        padding: 0;
        margin: 0;
    }

    .product-card h4 {
        color: var(--type-high-emphasis, #171520);
        font-size: 18.172px;
        font-style: normal;
        font-weight: 500;
        line-height: 22.715px;
        /* 125% */
    }

    .flex-diskon {
        display: flex;
        margin-top: auto;
        align-items: baseline;
        margin-bottom: 0;
    }

    .badge {
        font-size: 10px;
        padding: 4px 8px;
    }

    .harga {
        color: var(--type-high-emphasis, #171520);
        font-size: 13px;
        font-style: normal;
        font-weight: 500;
        margin-bottom: 0;
    }


    .diskon {
        color: var(--type-high-emphasis, #171520);
        font-size: 11px;
        font-style: normal;
    }
    .stock {
        font-size: 10px;
    }

    .lokasi {
        display: flex;
        width: 294.317px;
        height: 22.715px;
        flex-direction: column;
        justify-content: center;
        flex-shrink: 0;
    }

    .card-title {
        font-size: 13px;
        font-weight: 400;
        color: #000;
    }
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

<div class="container custom-margin">
    <ul class="nav">
        <li class="nav-item">
            <a href="{{ url('/p/listbarang') }}" class="nav-link active" aria-disabled="true"
                style="font-size: 21px; color:#000; text-decoration: underline; text-decoration-color: red;"><i class="bi bi-archive"></i><span
                style="margin-left: 8px; margin-top: 5px"></i>PRODUK
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('/p/listtoko') }}" class="nav-link active" aria-current="page"
                style="font-size: 21px; color:#000; text-decoration:"><i class="bi bi-shop-window"></i><span
                    style="margin-left: 8px;">TOKO</span></a>
        </li>
        {{-- <li class="nav-item">
            <a href="{{ url('/p/listparcel') }}" class="nav-link active" aria-current="page"
                style="font-size: 21px; color:#000; text-decoration:"><i class="bi bi-gift"></i><span
                    style="margin-left: 8px;">PAKET PARCEL</span></a>
        </li> --}}
    </ul>
</div>
<div class="section-divider"></div>
<br>
<div class="container">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="row">
                @foreach($produk as $barang)
                <div class="col-md-2 d-flex align-items-stretch">
                    <div class="card" data-href="{{ url('/p/barang/' . $barang->id) }}">
                        @if (strpos($barang->thumbnail, 'https://') !== false)
                            <img src="{{ URL::asset($barang->thumbnail) }}" alt="{{ $barang->nama_barang }}" class="img-fluid" style="height: 187px">
                        @else
                            <img src="{{ URL::asset($barang->thumbnail_readable) }}" alt="{{ $barang->nama_barang }}" class="img-fluid" style="height: 187px">
                        @endif
                        {{-- <img src="{{ URL::asset($barang->thumbnail_readable) }}" alt="{{ $barang->nama_barang }}" class="img-fluid" style="height: 187px"> --}}
                        <div class="card-body">
                            <h5 class="card-title"><a
                                    href="{{ url('/p/barang/' . $barang->id) }}">{{ $barang->nama_barang }}</a></h5>
                            {{-- <a href="{{ url('/p/barang/' . $barang->id) }}" class="btn-lihat-detail">Lihat Detail</a> --}}
                            <p class="card-text harga">Rp.
                                {{ number_format($barang->harga_user, 2) }}
                            </p>
                            @if($barang->diskon > 0)
                            <div class="flex-diskon">
                                <p><span class="badge bg-danger">-{{ $barang->diskon }}%</span></p>
                                <p class="card-text diskon text-muted"><del>Rp.
                                        {{ number_format($barang->harga_user_asli, 2) }}</del></p>
                            </div>
                            @endif
                            <p class="card-text stock">Stock: {{ $barang->stock_global }}</p>
                            @if($barang->toko)
                            <p class="card-text lokasi">Lokasi: {{ $barang->toko }}</p>
                            <a href="{{ url('/p/barang/' . $barang->id) }}" class="btn btn-primary">Lihat Detail</a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="pagination">
    {{ $produk->links() }}
    </div>

<script>
    Vue.createApp({
        data() {
            return {
                barang: {}
            },
            methods: {
                async tambahKeranjang() {
                    const response = await httpClient.post("{!! url('p/barang/keranjang') !!}/", {
                        id_barang: this.barang.id
                    })
                    console.log(response)
                }
            },
        }
    }).mount("#container")

</script>
<script>
    // Memilih semua elemen kartu dengan kelas "card"
    const cards = document.querySelectorAll('.card');

    // Menambahkan event listener pada setiap kartu
    cards.forEach(card => {
        card.addEventListener('click', () => {
            // Mendapatkan URL halaman detail barang dari atribut data-href pada setiap kartu
            const detailUrl = card.dataset.href;

            // Navigasi ke halaman detail barang
            window.location.href = detailUrl;
        });
    });

</script>

@endsection
