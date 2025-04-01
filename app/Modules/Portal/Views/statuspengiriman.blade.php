<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartASPOO</title>
    <link rel="icon" href="{{ URL::asset('/img/portal/android-chrome-512x512.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #FBD9C0;
            font-weight: 600;
        }

        .status-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
        }

        .container {
            margin-top: 20px;
            margin-bottom: 50px;
        }

        .order-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 20px;
            margin-bottom: 20px;
        }

        .product-card {
            display: flex;
            align-items: center;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .product-card:hover {
            background-color: #f0f0f0;
        }

        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
            margin-right: 15px;
        }

        .product-info {
            flex: 1;
        }

        .product-name {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .product-meta {
            font-size: 14px;
            color: #666;
        }

        .product-price {
            font-weight: 600;
            color: #333;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .status-waiting { background-color: #fff3cd; color: #856404; }
        .status-paid { background-color: #d1ecf1; color: #0c5460; }
        .status-shipped { background-color: #cce5ff; color: #004085; }
        .status-completed { background-color: #d4edda; color: #155724; }
        .status-failed { background-color: #f8d7da; color: #721c24; }

        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .summary-total {
            font-weight: 600;
            font-size: 18px;
        }

        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 20px;
        }

        .timeline-dot {
            position: absolute;
            left: -30px;
            top: 0;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #000;
        }

        .timeline-content {
            padding-left: 10px;
        }

        .timeline-time {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .timeline-title {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .timeline-desc {
            color: #666;
        }

        .timeline-line {
            position: absolute;
            left: -21px;
            top: 20px;
            bottom: 0;
            width: 2px;
            background-color: #000;
        }

        .copy-btn {
            background: none;
            border: none;
            color: #196CE9;
            cursor: pointer;
            font-weight: 600;
        }

        .transaction-group {
            margin-bottom: 30px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }
        .transaction-group:last-child {
            border-bottom: none;
        }
        .transaction-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="status-title">Status Pengiriman</h4>
            <span>Kode Transaksi Master: {{ $data['transaksi_master']->kode_transaksi }}</span>
        </div>

        <!-- For each transaction group -->
        @foreach($data['transaksi_list']->groupBy('kode_transaksi') as $transaksiKode => $transaksiGroup)
        @php
            $transaksi = $transaksiGroup->first();
            $transactionItems = array_filter($data['items'], function($item) use ($transaksiKode) {
                return $item['transaksi_kode'] == $transaksiKode;
            });
            $transactionSubtotal = array_sum(array_map(function($item) { return $item['subtotal']; }, $transactionItems));
        @endphp
        
        <div class="order-card mb-4 transaction-group">
            <div class="transaction-header">
                <h5>Pesanan #{{ $transaksiKode }}</h5>
                <span class="status-badge 
                    @if($transaksi->status == 1) status-waiting
                    @elseif($transaksi->status == 2) status-paid
                    @elseif($transaksi->status == 3) status-shipped
                    @elseif($transaksi->status == 4) status-completed
                    @elseif($transaksi->status == 44) status-failed @endif">
                    {{ $transaksi->status_readable }}
                </span>
            </div>
            
            <!-- Products List -->
            <div class="mb-4">
                <h6 class="mb-3">Produk Dipesan ({{ count($transactionItems) }})</h6>
                @foreach($transactionItems as $item)
                <div class="product-card">
                    <img src="{{ $item['thumbnail'] }}" alt="{{ $item['namaBarang'] }}" class="product-image">
                    <div class="product-info">
                        <div class="product-name">{{ $item['namaBarang'] }}</div>
                        <div class="product-meta">
                            Jumlah: {{ $item['jumlah'] }} × Rp {{ number_format($item['harga'], 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="product-price">
                        Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Order Summary -->
            <div class="order-summary">
                <div class="summary-item">
                    <span>Subtotal Produk</span>
                    <span>Rp {{ number_format($transactionSubtotal, 0, ',', '.') }}</span>
                </div>
                <div class="summary-item">
                    <span>Biaya Pengiriman</span>
                    <span>Rp {{ number_format($transaksi->biaya_pengiriman, 0, ',', '.') }}</span>
                </div>
                <div class="summary-item summary-total">
                    <span>Total Transaksi Ini</span>
                    <span>Rp {{ number_format($transactionSubtotal + $transaksi->biaya_pengiriman, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Shipping Info -->
            <div class="mt-3">
                <div class="mb-2">
                    <strong>Kurir:</strong> {{ $transaksi->kurir_pengiriman }}
                </div>
                <div class="mb-2">
                    <strong>Alamat:</strong> {{ $transaksi->alamat }}
                </div>
                <div class="mb-2">
                    <strong>Nomor Resi:</strong> {{ $transaksi->kode_transaksi }}
                    <button class="copy-btn" onclick="copyToClipboard('{{ $transaksi->kode_transaksi }}')">Salin</button>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Master Transaction Summary -->
        <div class="order-card mb-4">
            <h5 class="mb-3">Ringkasan Pembayaran</h5>
            <div class="summary-item">
                <span>Total Semua Transaksi</span>
                <span>Rp {{ number_format($data['transaksi_master']->total_biaya - $data['transaksi_master']->kode_unik, 0, ',', '.') }}</span>
            </div>
            <div class="summary-item">
                <span>Kode Unik</span>
                <span>Rp {{ number_format($data['kode_unik'], 0, ',', '.') }}</span>
            </div>
            <div class="summary-item summary-total">
                <span>Total Pembayaran</span>
                <span>Rp {{ number_format($data['transaksi_master']->total_biaya, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Combined Shipping Timeline -->
        <div class="order-card">
            <h5 class="mb-3">Riwayat Pengiriman</h5>
            
            @if (count($data['pengiriman']) > 0)
                <div class="timeline">
                    @foreach ($data['pengiriman'] as $timeline)
                        <?php
                        $statusClass = intval($timeline['status']) > 10 ? 'color:red;' : 'color:black;';
                        $date = new DateTime($timeline['created_at'], new DateTimeZone('UTC'));
                        $date->setTimezone(new DateTimeZone('Asia/Jakarta'));
                        $dateInIndonesia = $date->format('d M Y H:i');
                        ?>
                        
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <div class="timeline-time" style="{{ $statusClass }}">{{ $dateInIndonesia }}</div>
                                <div class="timeline-title" style="{{ $statusClass }}">
                                    {{ $timeline['status_readable'] }}
                                </div>
                                <div class="timeline-desc" style="{{ $statusClass }}">
                                    {{ $timeline['keterangan'] }}
                                    <br>
                                    <small>Transaksi: {{ $timeline['transaksi_kode'] ?? '' }}</small>
                                </div>
                            </div>
                            <div class="timeline-line"></div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">
                    Belum ada riwayat pengiriman tersedia.
                </div>
            @endif

            <!-- Confirmation buttons would need to be adjusted to handle multiple transactions -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Nomor Resi telah disalin ke clipboard: ' + text);
            }, function() {
                alert('Gagal menyalin nomor resi');
            });
        }

        function confirmReceived(transaksiId) {
            if (confirm('Apakah Anda yakin barang sudah diterima dengan baik?')) {
                fetch('/update-status-transaksi', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        transaksiId: transaksiId,
                        newStatus: 4
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Status berhasil diperbarui');
                        location.reload();
                    } else {
                        alert('Gagal memperbarui status: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memperbarui status');
                });
            }
        }

        function confirmNotReceived(transaksiId) {
            const reason = prompt('Mohon berikan alasan mengapa barang tidak diterima:');
            if (reason !== null) {
                fetch('/update-status-transaksi-gagal', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        transaksiId: transaksiId,
                        newStatus: 44,
                        barangtidakditerima: reason
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Status berhasil diperbarui');
                        location.reload();
                    } else {
                        alert('Gagal memperbarui status: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memperbarui status');
                });
            }
        }
    </script>
</body>
</html>