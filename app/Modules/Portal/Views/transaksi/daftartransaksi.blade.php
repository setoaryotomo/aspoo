@extends('portal_layout.templates')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    :root {
        /* --primary-color: #FBD9C0; */
        --primary-color: #bec2c6;
        /* --primary-hover: #f8c9a5; */
        --primary-hover: #6c757d;
        --text-dark: #333;
        --text-muted: #6c757d;
        --bg-light: #f8f9fa;
        --border-color: #e0e0e0;
        --border-radius: 10px;
        --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    
    .container {
        /* max-width: 1000px; */
        max-width: 1200px;
        padding: 0 15px;
    }
    
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        border-bottom: 2px solid var(--primary-color);
        padding-bottom: 0.75rem;
    }
    
    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        color: var(--text-dark);
    }
    
    .search-container {
        position: relative;
        max-width: 400px;
        margin-bottom: 1.5rem;
    }
    
    .search-input {
        width: 100%;
        border: 2px solid var(--primary-color);
        border-radius: var(--border-radius);
        padding: 10px 15px;
        padding-left: 40px;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .search-input:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(251, 217, 192, 0.3);
    }
    
    .search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary-color);
    }
    
    .transaction-list {
        display: grid;
        grid-gap: 1rem;
    }
    
    .master-transaction {
        background-color: #fff;
        border-radius: var(--border-radius);
        padding: 1.25rem;
        box-shadow: var(--box-shadow);
        transition: transform 0.2s ease;
    }
    
    .master-transaction:hover {
        transform: translateY(-3px);
    }
    
    .master-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .order-info h6 {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    
    .order-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        font-size: 0.875rem;
        color: var(--text-muted);
    }
    
    .meta-item {
        display: flex;
        align-items: center;
    }
    
    .meta-item i {
        margin-right: 0.375rem;
        font-size: 0.875rem;
    }
    
    .status-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
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
    
    .transaction-items {
        width: 1100px;
        margin: 0.75rem 0;
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        gap: 1rem;
        padding: 0.5rem 0;
        scrollbar-width: thin;
        scrollbar-color: var(--primary-color) #f0f0f0;
    }
    
    .transaction-items::-webkit-scrollbar {
        height: 6px;
    }
    
    .transaction-items::-webkit-scrollbar-track {
        background: #f0f0f0;
        border-radius: 10px;
    }
    
    .transaction-items::-webkit-scrollbar-thumb {
        background-color: var(--primary-color);
        border-radius: 10px;
    }
    
    .transaction-item {
        display: flex;
        flex-direction: column;
        min-width: 180px;
        max-width: 200px;
        padding: 0.75rem;
        background-color: #fff;
        border-radius: 8px;
        border: 1px solid #f0f0f0;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
        flex-shrink: 0;
    }
    
    .transaction-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        border-color: var(--primary-color);
    }
    
    .product-image {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 6px;
        margin-bottom: 0.75rem;
        border: 1px solid #eee;
    }
    
    .product-details {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .product-name {
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        color: var(--text-dark);
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        height: 2.8em;
    }
    
    .product-meta {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        margin-top: 0.25rem;
        font-size: 0.75rem;
        color: var(--text-muted);
    }
    
    .product-meta span {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .product-price {
        font-weight: 600;
        color: var(--text-dark);
        margin-top: 0.5rem;
        text-align: left;
        padding-top: 0.5rem;
        border-top: 1px dashed #f0f0f0;
    }
    
    .product-price .amount {
        display: block;
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
    }
    
    .product-price .qty {
        font-size: 0.75rem;
        color: var(--text-muted);
    }
    
    .master-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #f0f0f0;
    }
    
    .total-price {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--text-dark);
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50px;
        padding: 0.5rem 1.25rem;
        margin-right: 0.5rem;
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        text-decoration: none;
    }
    
    .btn i {
        margin-right: 0.5rem;
    }
    
    .btn-primary {
        background-color: var(--primary-color);
        color: var(--text-dark) !important;
    }
    
    .btn-primary:hover {
        background-color: var(--primary-hover);
        transform: translateY(-2px);
    }
    
    .btn-secondary {
        background-color: #f0f0f0;
        color: var(--text-dark) !important;
    }
    
    .btn-secondary:hover {
        background-color: #e0e0e0;
        transform: translateY(-2px);
    }
    
    .btn-outline {
        background-color: transparent;
        border: 1px solid var(--primary-color);
        color: var(--text-dark) !important;
    }
    
    .btn-outline:hover {
        background-color: var(--primary-color);
        transform: translateY(-2px);
    }
    
    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 0.75rem;
        width: 100%;
    }
    
    .action-buttons .btn {
        padding: 0.375rem 0.75rem;
        font-size: 0.75rem;
        white-space: nowrap;
        flex: 1;
        min-width: 0;
        justify-content: center;
    }
    
    .action-buttons .btn i {
        margin-right: 0.25rem;
    }
    
    .review-section {
        margin-top: 1rem;
        padding: 1rem;
        background-color: var(--bg-light);
        border-radius: var(--border-radius);
    }
    
    .review-title {
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1rem;
    }
    
    .review-form {
        display: grid;
        gap: 1rem;
    }
    
    .review-form label {
        font-weight: 500;
        font-size: 0.875rem;
        display: block;
        margin-bottom: 0.375rem;
    }
    
    .star-rating {
        display: flex;
    }
    
    .star-rating i {
        color: #ddd;
        cursor: pointer;
        font-size: 1.25rem;
        margin-right: 0.375rem;
        transition: all 0.2s ease;
    }
    
    .star-rating i:hover, .star-rating i.active {
        color: #FFD700;
        transform: scale(1.1);
    }
    
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem;
        text-align: center;
        background-color: #fff;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
    }
    
    .empty-state i {
        font-size: 3rem;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }
    
    .empty-state h5 {
        font-size: 1.125rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }
    
    .empty-state p {
        font-size: 0.875rem;
        color: var(--text-muted);
        max-width: 400px;
        margin: 0 auto;
    }
    
    .review-display {
        margin-top: 0.5rem;
        font-size: 0.875rem;
    }
    
    .review-display p {
        margin-bottom: 0.5rem;
    }
    
    
    @media (max-width: 768px) {
        .page-header {
            margin-top: 50px;
        }

        .master-header {
            flex-direction: column;
        }
        
        .status-badge {
            margin-top: 0.5rem;
            align-self: flex-start;
        }
        
        .transaction-items {
            padding-bottom: 12px;
            width: 320px;
        }
        
        .transaction-item {
            min-width: 150px;
        }
        
        .master-footer {
            flex-direction: column-reverse;
            gap: 1rem;
        }
        
        .total-price {
            margin-bottom: 0.5rem;
        }
        
        .btn {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
        }
    }
</style>

<div class="container">
    <div class="page-header">
        <h2 class="page-title"><i class="fa-solid fa-cart-shopping"></i> Daftar Transaksi</h2>
        <div class="search-container">
            <input type="text" class="search-input" placeholder="Cari transaksi...">
        </div>
    </div>
    
    {{-- <div class="search-container">
        <i class="bi bi-search search-icon"></i>
        <input type="text" class="search-input" placeholder="Cari transaksi...">
    </div> --}}

    <div class="transaction-list">
        @if(count($data) == 0)
            <div class="empty-state">
                <i class="bi bi-bag-x"></i>
                <h5>Belum Ada Transaksi</h5>
                <p>Anda belum memiliki transaksi. Mulai berbelanja sekarang untuk melihat riwayat transaksi Anda.</p>
            </div>
        @else
            @foreach($data as $master)
                <div class="master-transaction">
                    <div class="master-header">
                        <div class="order-info">
                            <h6>Order #{{ $master['masterKode'] }}</h6>
                            <div class="order-meta">
                                <span class="meta-item"><i class="bi bi-calendar3"></i>{{ $master['createdDate'] }}</span>
                                <span class="meta-item"><i class="bi bi-upc"></i>ID: {{ $master['parcelId'] }}</span>
                            </div>
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

                    {{-- <div class="transaction-items" style="width: 900px"> --}}
                    <div class="transaction-items">
                        @foreach($master['items'] as $item)
                            <div class="transaction-item">
                                <img src="{{ url($item['thumbnail_readable']) }}" alt="{{ $item['namaBarang'] }}" class="product-image">
                                
                                <div class="product-details">
                                    <div class="product-name">{{ $item['namaBarang'] }}</div>
                                    <div class="product-meta">
                                        <span><i class="bi bi-upc"></i> {{ $item['kodeTransaksi'] }}</span>
                                        {{-- <span><i class="bi bi-truck"></i> {{ $item['kurirPengiriman'] }}</span> --}}
                                    </div>
                                </div>
                                
                                <div class="product-price">
                                    <span class="amount">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                                    <span class="qty">{{ $item['jumlah'] }} x Rp {{ number_format($item['harga'], 0, ',', '.') }}</span>
                                </div>
                                
                                @if($item['status'] == 3 && $master['status'] == 3)
                                    <div class="action-buttons">
                                        <button type="button" class="btn btn-success ubah-status" 
                                                data-transaksi-id="{{ $item['transaksiId'] }}">
                                            <i class="bi bi-check-circle"></i> Diterima
                                        </button>
                                        <button type="button" class="btn btn-danger btn-outline ubah-status-gagal" 
                                                data-transaksi-id="{{ $item['transaksiId'] }}">
                                            <i class="bi bi-x-circle"></i> Tidak
                                        </button>
                                    </div>
                                @endif  
                            </div>
                        @endforeach
                    </div>

                    @if($master['parcelId'])
                        <div class="review-section">
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
                                        
                                        <div>
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
                                        
                                        <button type="submit" class="btn btn-primary submit-review">
                                            <i class="bi bi-send"></i> Kirim Review
                                        </button>
                                    </form>
                                @elseif($parcel)
                                    <div class="review-title">Review Anda</div>
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
                            <a href="{{ url('p/status/').'/'.$master['masterKode'] }}" class="btn btn-primary" target="_blank" onclick="window.open(this.href, '_blank'); return false;" style="color: white;te">
                                <i class="bi bi-info-circle" style="color: white;"> Detail</i> 
                            </a>
                        </div>
                        <div class="total-price">
                            Total: {{ $master['totalHargaFormatted'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
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
    $('.star-rating i').hover(
        function() {
            const rating = $(this).data('rating');
            $(this).prevAll('i').addBack().addClass('hover');
        },
        function() {
            $(this).prevAll('i').addBack().removeClass('hover');
        }
    );
    
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
    
    // Search functionality
    $('.search-input').on('keyup', function() {
        const value = $(this).val().toLowerCase();
        $('.master-transaction').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
</script>
@endsection