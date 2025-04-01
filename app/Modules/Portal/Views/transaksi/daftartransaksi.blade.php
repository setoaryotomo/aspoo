@extends('portal_layout.templates')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

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
    .master-transaction {
        background-color: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .master-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 10px;
        border-bottom: 1px solid #f0f0f0;
        margin-bottom: 15px;
    }
    .transaction-item {
        display: flex;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #f5f5f5;
    }
    .product-image {
        max-width: 80px;
        height: auto;
        margin-right: 15px;
        border-radius: 4px;
    }
    .product-details {
        flex: 1;
    }
    .product-name {
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 5px;
        color: #333;
    }
    .transaction-meta {
        font-size: 14px;
        color: #777;
        margin: 3px 0;
    }
    .master-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #f0f0f0;
    }
    .total-price {
        font-size: 18px;
        font-weight: bold;
        color: #333;
    }
    .status-badge {
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 500;
    }
    .status-waiting {
        background-color: #fff3cd;
        color: #856404;
    }
    .status-paid {
        background-color: #d1ecf1;
        color: #0c5460;
    }
    .status-shipped {
        background-color: #cce5ff;
        color: #004085;
    }
    .status-completed {
        background-color: #d4edda;
        color: #155724;
    }
    .status-failed {
        background-color: #f8d7da;
        color: #721c24;
    }
    .action-buttons {
        margin-top: 10px;
    }
    .btn {
        border-radius: 5px;
        padding: 8px 15px;
        margin-right: 10px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s;
        border: none;
    }
    .btn-primary {
        background-color: #FBD9C0;
        color: #333;
    }
    .btn-warning {
        background-color: #FBD9C0;
        color: #333;
    }
</style>

<div class="container">
    <div class="container custom-margin">
        <ul class="nav">
            <li class="nav-item">
                <a href="{{ url('/p/daftartransaksi') }}" class="nav-link active" aria-disabled="true"
                    style="font-size: 21px; color:#000; text-decoration: underline; text-decoration-color: red;">
                    <i class="bi bi-archive"></i><span style="margin-left: 8px;">Barang</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/p/daftarparcel') }}" class="nav-link active" aria-current="page"
                    style="font-size: 21px; color:#000; text-decoration: none;">
                    <i class="fa-solid fa-box"></i><span style="margin-left: 8px;">Parcel</span>
                </a>
            </li>
        </ul>
    </div>

    @if(count($data) == 0)
        <div class="master-transaction">
            <h4>Anda belum memiliki transaksi</h4>
        </div>
    @endif

    @foreach($data as $master)
        <div class="master-transaction">
            <div class="master-header">
                <div>
                    <h5>Order #{{ $master['masterKode'] }}</h5>
                    <p class="transaction-meta">Tanggal: {{ $master['createdDate'] }}</p>
                </div>
                <div>
                    @php
                        $statusClass = '';
                        if(in_array($master['status'], [1])) $statusClass = 'status-waiting';
                        elseif(in_array($master['status'], [2])) $statusClass = 'status-paid';
                        elseif(in_array($master['status'], [3])) $statusClass = 'status-shipped';
                        elseif(in_array($master['status'], [4])) $statusClass = 'status-completed';
                        elseif(in_array($master['status'], [44])) $statusClass = 'status-failed';
                    @endphp
                    <span class="status-badge {{ $statusClass }}">{{ $master['statusReadable'] }}</span>
                </div>
            </div>

            @foreach($master['items'] as $item)
                <div class="transaction-item">
                    <img src="{{ url($item['thumbnail']) }}" alt="Product Image" class="product-image">
                    <div class="product-details">
                        <div class="product-name">{{ $item['namaBarang'] }}</div>
                        <p class="transaction-meta">Kode: {{ $item['kodeTransaksi'] }}</p>
                        <p class="transaction-meta">Jumlah: {{ $item['jumlah'] }} x Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                        <p class="transaction-meta">Subtotal: Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                        <p class="transaction-meta">Pengiriman: {{ $item['kurirPengiriman'] }} (Rp {{ number_format($item['biayaPengiriman'], 0, ',', '.') }})</p>
                        
                        @if($item['status'] == 3 && $master['status'] == 3)
                            <div class="action-buttons">
                                <button type="button" class="btn btn-primary ubah-status" 
                                        data-transaksi-id="{{ $item['transaksiId'] }}" style="color: white">
                                    Barang Diterima
                                </button>
                                <button type="button" class="btn btn-warning ubah-status-gagal" 
                                        data-transaksi-id="{{ $item['transaksiId'] }}">
                                    Barang Tidak Diterima
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

            <div class="master-footer">
                <div>
                    <a href="{{ url('p/status/').'/'.$master['masterKode'] }}" class="btn btn-primary" style="color: white" target="_blank">
                        Lihat Detail Transaksi
                    </a>
                </div>
                <div class="total-price">
                    Total: {{ $master['totalHargaFormatted'] }}
                    @if($master['kodeUnik'] > 0)
                        <small>(termasuk kode unik Rp {{ number_format($master['kodeUnik'], 0, ',', '.') }})</small>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>

<script>
$(document).ready(function() {
    $(".ubah-status").click(function() {
        var transaksiId = $(this).data("transaksi-id");
        
        $.ajax({
            type: "POST",
            url: "{{ route('update.status') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "transaksiId": transaksiId,
                "newStatus": "4"
            },
            success: function(response) {
                if (response.success) {
                    alert("Status berhasil diupdate.");
                    location.reload();
                } else {
                    alert("Gagal mengupdate status.");
                }
            },
            error: function(err) {
                alert("Terjadi kesalahan: " + err.responseText);
            }
        });
    });

    $(".ubah-status-gagal").click(function() {
        var transaksiId = $(this).data("transaksi-id");
        var barangtidakditerima = prompt("Masukkan alasan barang tidak diterima:");

        if (barangtidakditerima === null || barangtidakditerima === "") {
            alert("Silakan masukkan alasan barang tidak diterima");
            return;
        }
        
        $.ajax({
            type: "POST",
            url: "{{ route('update.status.gagal') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "transaksiId": transaksiId,
                "newStatus": "44",
                "barangtidakditerima": barangtidakditerima
            },
            success: function(response) {
                if (response.success) {
                    alert("Status berhasil diupdate.");
                    location.reload();
                } else {
                    alert("Gagal mengupdate status.");
                }
            },
            error: function() {
                alert("Terjadi kesalahan saat mengupdate status.");
            }
        });
    });
});
</script>
@endsection