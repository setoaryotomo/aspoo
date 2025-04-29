@extends('portal_layout.templates')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

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
    .review-section {
        margin-top: 15px;
        padding: 15px;
        background-color: #f9f9f9;
        border-radius: 8px;
    }
    .review-title {
        font-weight: bold;
        margin-bottom: 10px;
    }
    .star-rating {
        display: flex;
        margin-bottom: 10px;
    }
    .star-rating i {
        color: #ddd;
        cursor: pointer;
        font-size: 20px;
        margin-right: 5px;
    }
    .star-rating i.active {
        color: #FFD700;
    }
    .review-input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 10px;
    }
    .submit-review {
        background-color: #FBD9C0;
        color: #333;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        cursor: pointer;
    }
    .review-display {
        margin-top: 10px;
        padding: 10px;
        background-color: #f0f0f0;
        border-radius: 5px;
    }
</style>

<div class="container">
    <div class="container custom-margin" style="display: none">
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
            <h7>Anda belum memiliki transaksi</h7>
        </div>
    @else
        <br>
        <div class="master-transaction">
            <h5><b>Daftar Transaksi</b></h5>
        </div>
    @endif 

    @foreach($data as $master)
        <div class="master-transaction">
            <div class="master-header">
                <div>
                    <h6>Order #{{ $master['masterKode'] }}</h6>
                    <p class="transaction-meta">Tanggal: {{ $master['createdDate'] }}</p>
                    <p class="transaction-meta">ID: {{ $master['parcelId'] }}</p>
                    
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
                    <img src="{{ url($item['thumbnail_readable']) }}" alt="Product Image" class="product-image">
                    
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

            @if($master['parcelId'])
            
                <div class="review-section">
                    {{-- <div class="review-title">Review Parcel</div> --}}
                    
                    @if($master['status'] == 4) {{-- Only show review form if transaction is completed --}}
                        @php
                            $parcel = \App\Modules\permintaanparcel\Models\permintaanparcel::find($master['parcelId']);
                        @endphp
                        
                        @if($parcel && !$parcel->review_komposisi && !$parcel->review_pelayanan)
                        <div class="review-title">Review Parcel</div>
                            <form id="reviewForm-{{ $master['parcelId'] }}" class="review-form" data-parcel-id="{{ $master['parcelId'] }}">
                                @csrf
                                <div>
                                    <label>Rating Komposisi:</label>
                                    <div class="star-rating komposisi-rating">
                                        <i class="fas fa-star" data-rating="1"></i>
                                        <i class="fas fa-star" data-rating="2"></i>
                                        <i class="fas fa-star" data-rating="3"></i>
                                        <i class="fas fa-star" data-rating="4"></i>
                                        <i class="fas fa-star" data-rating="5"></i>
                                        <input type="hidden" name="review_komposisi" id="komposisi-rating-input" value="0">
                                    </div>
                                </div>
                                
                                <div style="margin-top: 15px;">
                                    <label>Rating Pelayanan:</label>
                                    <div class="star-rating pelayanan-rating">
                                        <i class="fas fa-star" data-rating="1"></i>
                                        <i class="fas fa-star" data-rating="2"></i>
                                        <i class="fas fa-star" data-rating="3"></i>
                                        <i class="fas fa-star" data-rating="4"></i>
                                        <i class="fas fa-star" data-rating="5"></i>
                                        <input type="hidden" name="review_pelayanan" id="pelayanan-rating-input" value="0">
                                    </div>
                                </div>
                                
                                <button type="submit" class="submit-review">Kirim Review</button>
                            </form>
                        @elseif($parcel)
                            <div class="review-display">
                                <p><strong>Komposisi:</strong> 
                                    @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star" style="@if($i <= $parcel->review_komposisi) color: #FFD700; @else color: #ddd; @endif"></i>
                                    @endfor
                                </p>
                                <p><strong>Pelayanan:</strong> 
                                    @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star" style="@if($i <= $parcel->review_pelayanan) color: #FFD700; @else color: #ddd; @endif"></i>
                                    @endfor
                                </p>
                            </div>
                        @endif
                    @endif
                </div>
            @endif

            <div class="master-footer">
                <div>
                    {{-- <a href="{{ url('p/status/').'/'.$master['masterKode'] }}" class="btn btn-primary" style="color: white" target="_blank">Detail</a> --}}
                    <a href="{{ url('p/status/').'/'.$master['masterKode'] }}" class="btn btn-primary" style="color: white" target="_blank" onclick="window.open(this.href, '_blank'); return false;"> Detail </a>
                </div>
                <div class="total-price">
                    Total: {{ $master['totalHargaFormatted'] }}
                </div>
            </div>
        </div>
    @endforeach
</div>

<script>
$(document).ready(function() {
    // Status update functions
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

    // Star rating functionality
    $('.star-rating i').click(function() {
        const rating = $(this).data('rating');
        const ratingType = $(this).parent().hasClass('komposisi-rating') ? 'komposisi' : 'pelayanan';
        
        $(this).parent().find('i').removeClass('active');
        $(this).prevAll('i').addBack().addClass('active');
        $(`#${ratingType}-rating-input`).val(rating);
    });

    // Review submission
    $('.review-form').submit(function(e) {
        e.preventDefault();
        const parcelId = $(this).data('parcel-id');
        const formData = $(this).serialize();
        
        $.ajax({
            type: "POST",
            url: `/p/parcel/${parcelId}/review`,
            data: formData,
            success: function(response) {
                if (response.success) {
                    alert("Review berhasil dikirim.");
                    location.reload();
                } else {
                    alert("Gagal mengirim review.");
                }
            },
            error: function() {
                alert("Terjadi kesalahan saat mengirim review.");
            }
        });
    });
});
</script>
@endsection