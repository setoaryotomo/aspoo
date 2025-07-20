<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            margin: 20mm;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
            font-size: 9pt;
        }
        th {
            background-color: #e6e6e6;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .header {
            margin-bottom: 20px;
        }
        .summary {
            margin-top: 15px;
            font-size: 10pt;
        }
        .filter-info {
            margin-bottom: 15px;
            font-size: 10pt;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Data Barang</h2>
        <div class="filter-info">
            <p>Filter: 
                <strong>Produsen:</strong> {{ $filter_produsen }}, 
                <strong>UMKM:</strong> {{ $filter_umkm }},
                <strong>Kategori:</strong> {{ $filter_kategori }}
            </p>
        </div>
        <p class="text-right">Dicetak pada: {{ $report_date }}</p>
    </div>

    

    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nama Barang</th>
                <th>UMKM/Toko</th>
                <th>Kategori</th>
                <th>Produsen</th>
                <th>Harga</th>
                <th>Berat (Gram)</th>
                <th>Stok</th>
                {{-- <th width="20%">Tanggal Dibuat</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach($data_barang as $index => $barang)
            <tr>
                {{-- <td>{{ $index + 1 }}</td> --}}
                <td>{{ $barang['id'] }}</td>
                <td>{{ $barang['nama_barang'] }}</td>
                <td>{{ $barang['user_name'] }}</td>
                <td>{{ $barang['kategori_umum'] }}</td>
                <td>{{ $barang['produsen'] }}</td>
                <td>{{ $barang['harga_umum'] }}</td>
                <td>{{ $barang['berat'] }}</td>
                <td>{{ $barang['stock_global'] }}</td>
                {{-- <td>{{ $barang['created_at'] }}</td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary text-right">
        <p>Total Barang: {{ count($data_barang) }}</p>
        <p>Total Stok: {{ $total_stok }}</p>
    </div>
</body>
</html>