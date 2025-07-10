<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 14px;
        }
        .info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .master-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .detail-section {
            margin-bottom: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 10px;
        }
        .detail-table {
            width: 100%;
            margin: 10px 0;
        }
        .detail-table th {
            background-color: #e9ecef;
        }
        .summary {
            margin-top: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Penjualan</h1>
        <p>Periode: {{ date('d M Y', strtotime($startDate)) }} - {{ date('d M Y', strtotime($endDate)) }}</p>
        <p>Dicetak pada: {{ $tanggalCetak }}</p>
    </div>

    <div class="info">
        {{-- <p><strong>Filter:</strong></p> --}}
        <p>Status: {{ $status == 'semua' ? 'Semua' : ($status == '4' ? 'Selesai' : ($status == '2' ? 'Pending' : 'Dibatalkan')) }}</p>
        <p>Toko: {{ $tokoId == 'semua' ? 'Semua' : ($tokos->where('user_id', $tokoId)->first()->nama ?? '-') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Master</th>
                <th>Toko</th>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $index = 1; @endphp
            @foreach($transaksiMaster as $masterCode => $transactions)
                <tr class="master-row">
                    <td>{{ $index }}</td>
                    <td>{{ $masterCode }}</td>
                    <td>{{ $transactions->first()->penjual->name ?? '-' }}</td>
                    <td>{{ date('Y-m-d', strtotime($transactions->first()->created_at)) }}</td>
                    <td>Rp {{ number_format($transactions->sum('total_biaya'), 0, ',', '.') }}</td>
                    <td>
                        @if($transactions->first()->status == 4)
                            Selesai
                        @elseif($transactions->first()->status == 1)
                            Diproses
                        @else
                            Diproses
                        @endif
                    </td>
                </tr>
                
                <!-- Detail Transaksi -->
                {{-- <tr>
                    <td colspan="6">
                        @foreach($transactions as $trx)
                            <div class="detail-section">
                                <h5>Transaksi: {{ $trx->kode_transaksi }}</h5>
                                <p>Toko: {{ $trx->penjual->name ?? '-' }}</p>
                                <p>Tanggal: {{ date('Y-m-d H:i:s', strtotime($trx->created_at)) }}</p>
                                <p>Total: Rp {{ number_format($trx->total_biaya, 0, ',', '.') }}</p>
                                
                                <table class="detail-table">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($trx->dataChildren as $child)
                                            <tr>
                                                <td>{{ $child->barang->nama_barang ?? 'Barang tidak tersedia' }}</td>
                                                <td>Rp {{ number_format($child->harga, 0, ',', '.') }}</td>
                                                <td>{{ $child->jumlah }}</td>
                                                <td>Rp {{ number_format($child->harga * $child->jumlah, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    </td>
                </tr> --}}
                @php $index++; @endphp
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <p><strong>Ringkasan:</strong></p>
        <p>Total Penjualan: Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</p>
        <p>Total Transaksi: {{ $totalTransaksi }}</p>
        <p>Total Toko: {{ $tokos->count() }}</p>
    </div>

    {{-- <div class="footer">
        <p>Sistem Informasi Manajemen Toko</p>
    </div> --}}
</body>
</html>