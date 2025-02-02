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
        display: flex;
        align-items: center;
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
                    style="font-size: 21px; color:#000; text-decoration: underline; text-decoration-color: red;"><i class="bi bi-archive"></i><span
                    style="margin-left: 8px; margin-top: 5px"></i>Barang
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/p/daftarparcel') }}" class="nav-link active" aria-current="page"
                    style="font-size: 21px; color:#000; text-decoration:"><i class="fa-solid fa-box"></i><span
                        style="margin-left: 8px;">Parcel</span></a>
            </li>
        </ul>
    </div>
    @if($data == null)
    <div class="content-container">
        <h1>Anda belum memiliki transaksi</h1>
    </div>
    @endif
    @foreach($data as $transaksi)
    <div class="content-container mt-3">
        <img src="{{url($transaksi['thumbnail'])}}" alt="Product Image" class="product-image">
        <div class="product-details">
            <div class="product-name">Nama Produk: {{ $transaksi['namaBarang'] }}</div>
            <p style="color: #987544;">Kode Transaksi : {{ $transaksi['kodeTransaksi'] }}</p>
            <p>Tanggal  : {{ $transaksi['createdDate'] }} <br>
                Status  : {{$transaksi['statusReadable']}}
            </p>
            @if($transaksi['status'] == '3')
            <button type="button" class="btn btn-primary ubah-status" data-transaksi-id="{{ $transaksi['transaksiId'] }}" style="background-color: #FBD9C0;">Barang Diterima</button>
            <button type="button" class="btn btn-warning ubah-status-gagal" data-transaksi-id="{{ $transaksi['transaksiId'] }}" style="background-color: #FBD9C0;">Barang Tidak Diterima</button>
            @endif
            <div class="product-quantity"> {{ $transaksi['jumlah'] }} Barang</div>
        </div>
        <div class="caption-total">
            <a>Total Harga</a><br>
            <a><b>{{ $transaksi['totalHargaFormatted'] }}</b></a>
            <br><br><br>
            <a href="{{url('p/status/').'/'.$transaksi['kodeTransaksi']}}" class="caption-link">Lihat Status Transaksi</a>
        </div>
        <div class="vertical-line" style="background-color: #FBD9C0;"></div>

    </div>
    @endforeach
</div>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script>
$(document).ready(function() {
    $(".ubah-status").click(function() {
        var transaksiId = $(this).data("transaksi-id");
        
        // Send an AJAX request to update the status
        $.ajax({
            type: "POST",
            url: "{{ route('update.status') }}", // Replace with the actual route name
            data: {
                "_token": "{{ csrf_token() }}",
                "transaksiId": transaksiId,
                "newStatus": "4"
            },
            success: function(response) {
                if (response.success) {
                    alert("status diupdate.");
                    // Update the button text and disable the button
                    $(".ubah-status[data-transaksi-id='" + transaksiId + "']").text("Status Updated").prop("disabled", true);
                } else {
                    alert("gagal mengupdate status.");
                }
            },
            error: function(err) {
                alert(err);
            }
        });
    });
});
</script>

<script>
    $(document).ready(function() {
    $(".ubah-status-gagal").click(function() {
        var transaksiId = $(this).data("transaksi-id");

        // Menggunakan prompt untuk meminta nama dari pengguna
        var barangtidakditerima = prompt("Masukkan alasan barang tidak diterima:");

        if (barangtidakditerima === null || barangtidakditerima === "") {
            alert("Silakan masukkan pesan disini");
            return;
        }
        
        // Send an AJAX request to update the status
        $.ajax({
            type: "POST",
            url: "{{ route('update.status.gagal') }}", // Replace with the actual route name
            data: {
                "_token": "{{ csrf_token() }}",
                "transaksiId": transaksiId,
                "newStatus": "44",
                "barangtidakditerima" : barangtidakditerima
            },
            success: function(response) {
                if (response.success) {
                    alert("status diupdate.");
                    // Update the button text and disable the button
                    $(".ubah-status[data-transaksi-id='" + transaksiId + "']").text("Status Updated").prop("disabled", true);
                } else {
                    alert("gagal mengupdate status.");
                }
            },
            error: function() {
                alert("mbuh ra ketemu error e");
            }
        });
    });
});
</script>

@endsection