@extends('portal_layout.templates')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <div class="container">
        <style>
            .search-container {
                margin-bottom: 20px;
            }

            .search-bar {
                display: flex;
                align-items: center;
            }

            .search-input {
                border: 2px solid #FBD9C0;
                border-radius: 5px;
                padding: 10px;
                font-size: 16px;
            }

            .search-icon {
                background-color: #FBD9C0;
                border: none;
                border-radius: 5px;
                color: #fff;
                font-size: 20px;
            }

            .content-container {
                background-color: #ffffff;
                border: 1px solid #e0e0e0;
                border-radius: 8px;
                padding: 20px;
                margin-bottom: 20px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .product-image {
                max-width: 150px;
                height: auto;
                margin-right: 20px;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .product-details {
                flex: 1;
            }

            .product-details .product-name {
                font-weight: bold;
                font-size: 18px;
                margin-bottom: 5px;
                color: #333333;
            }

            .product-details p {
                font-size: 16px;
                margin: 5px 0;
                line-height: 1.6;
                color: #555555;
            }

            .product-quantity {
                font-size: 16px;
                margin-top: 8px;
                color: #777777;
            }

            .btn {
                border-radius: 5px;
                padding: 8px 15px;
                margin-top: 10px;
                cursor: pointer;
                font-size: 16px;
                transition: background-color 0.3s, color 0.3s;
                border: none;
                outline: none;
            }

            .btn-primary {
                background-color: #007bff;
                color: #ffffff;
            }

            .btn-warning {
                background-color: #ffc107;
                color: #212529;
            }

            .vertical-line {
                background-color: #fbd9c0;
                width: 2px;
                height: 80%;
                margin: 0 20px;
            }

            .caption-link {
                color: #007bff;
                font-size: 16px;
                text-decoration: none;
                transition: color 0.3s;
            }

            .caption-link:hover {
                color: #0056b3;
            }

            .caption-total {
                font-size: 16px;
                margin-top: 15px;
                color: #777777;
            }

            .caption-total a {
                color: #007bff;
                text-decoration: none;
                transition: color 0.3s;
            }

            .caption-total a:hover {
                color: #0056b3;
            }
        </style>

        <div class="container custom-margin">
            <ul class="nav">
                <li class="nav-item">
                    <a href="{{ url('/p/daftartransaksi') }}" class="nav-link active" aria-disabled="true"
                        style="font-size: 21px; color:#000; text-decoration-color: red;">
                        <i class="bi bi-archive"></i><span style="margin-left: 8px; margin-top: 5px">Barang</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/p/daftarparcel') }}" class="nav-link active" aria-current="page"
                        style="font-size: 21px; color:#000; text-decoration: underline;">
                        <i class="fa-solid fa-box"></i><span style="margin-left: 8px;">Parcel</span>
                    </a>
                </li>
            </ul>
        </div>

        @if ($parcels->isEmpty())
            <div class="content-container">
                <h1>Anda belum memesan parcel</h1>
            </div>
        @else
            @foreach ($parcels as $index => $parcel)
                @if (!$parcel->parcel_children->isEmpty())
                    <div class="content-container">
                        @php
                            $number = 1;
                        @endphp
                        {{-- <h2>Parcel {{ $index + 1 }}</h2> --}}
                        <h2>Parcel : </h2> 
                        <p>{{ $parcel->created_at }}</p>
                        @foreach ($parcel->parcel_children as $child)
                            <div class="product-details">
                                <div class="product-name">{{ $child->barang->nama_barang }}</div>
                                {{-- <p>Total Harga: {{ $child->total_harga }}</p> --}}
                            </div>
                        @endforeach
                        {{-- <a href="{{ url('p/status/') }}" class="caption-link">Lihat Status Transaksi</a> --}}
                    </div>
                @endif
            @endforeach
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var buttons = document.querySelectorAll('.ubah-status, .ubah-status-gagal');

            buttons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var transaksiId = this.getAttribute('data-transaksi-id');
                    var newStatus = this.classList.contains('ubah-status') ? '4' : '44';
                    var alasan = newStatus === '44' ? prompt(
                        "Masukkan alasan barang tidak diterima:") : null;

                    if (newStatus === '44' && (alasan === null || alasan === "")) {
                        alert("Silakan masukkan pesan disini");
                        return;
                    }

                    alert('Status akan diupdate untuk transaksi ID: ' + transaksiId +
                        ' dengan status baru: ' + newStatus);
                });
            });
        });
    </script>
@endsection
