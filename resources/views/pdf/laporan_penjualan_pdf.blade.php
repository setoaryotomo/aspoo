<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #007bff;
            font-size: 24px;
            margin: 0;
            font-weight: bold;
        }
        
        .header p {
            margin: 5px 0;
            color: #666;
        }
        
        .summary-section {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #dee2e6;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .summary-label {
            font-weight: bold;
            color: #495057;
        }
        
        .summary-value {
            color: #007bff;
            font-weight: bold;
        }
        
        .filter-info {
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 11px;
        }
        
        .filter-info strong {
            color: #495057;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 10px;
        }
        
        th, td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }
        
        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        
        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        tbody tr:hover {
            background-color: #e9ecef;
        }
        
        .status-completed {
            color: #28a745;
            font-weight: bold;
        }
        
        .status-pending {
            color: #ffc107;
            font-weight: bold;
        }
        
        .status-cancelled {
            color: #dc3545;
            font-weight: bold;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .currency {
            font-weight: bold;
            color: #28a745;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #dee2e6;
            padding-top: 15px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .no-data {
            text-align: center;
            color: #6c757d;
            font-style: italic;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENJUALAN</h1>
        <p>Sistem Manajemen Toko</p>
        <p>Dicetak pada: {{ $tanggalCetak }}</p>
    </div>

    <div class="filter-info">
        <strong>Filter yang Diterapkan:</strong><br>
        Periode: {{ date('d M Y', strtotime($startDate)) }} - {{ date('d M Y', strtotime($endDate)) }} |
        Status: {{ $status == 'semua' ? 'Semua Status' : ($status == '4' ? 'Selesai' : ($status == '2' ? 'Pending' : 'Dibatalkan')) }} |
        Toko: {{ $tokoId == 'semua' ? 'Semua Toko' : $tokos->where('user_id', $tokoId)->first()->nama ?? 'Tidak Diketahui' }}
    </div>

    <div class="summary-section">
        <div class="summary-row">
            <span class="summary-label">Total Penjualan:</span>
            <span class="summary-value">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Total Transaksi:</span>
            <span class="summary-value">{{ $totalTransaksi }}</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Total Toko:</span>
            <span class="summary-value">{{ $tokos->count() }}</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">Rata-rata per Transaksi:</span>
            <span class="summary-value">Rp {{ $totalTransaksi > 0 ? number_format($totalPenjualan / $totalTransaksi, 0, ',', '.') : '0' }}</span>
        </div>
    </div>

    @if($transaksi->count() > 0)
    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">Kode Transaksi</th>
                <th style="width: 15%">Kode Master</th>
                <th style="width: 20%">Nama Toko</th>
                <th style="width: 12%">Tanggal</th>
                <th style="width: 15%">Jumlah</th>
                <th style="width: 10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $index => $trx)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $trx->kode_transaksi }}</td>
                <td>{{ $trx->kode_transaksi_master }}</td>
                <td>{{ $trx->penjual->name }}</td>
                <td class="text-center">{{ date('d/m/Y', strtotime($trx->created_at)) }}</td>
                <td class="text-right currency">Rp {{ number_format($trx->total_biaya, 0, ',', '.') }}</td>
                <td class="text-center">
                    @if($trx->status == 4)
                        <span class="status-completed">Selesai</span>
                    @elseif($trx->status == 1)
                        <span class="status-pending">Diproses</span>
                    @else
                        <span class="status-cancelled">Diproses</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-data">
        <p>Tidak ada data transaksi yang ditemukan untuk periode yang dipilih.</p>
    </div>
    @endif
{{-- 
    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh sistem pada {{ $tanggalCetak }}</p>
        <p>Waktu Indonesia Barat (WIB) - Halaman 1 dari 1</p>
    </div> --}}
</body>
</html>