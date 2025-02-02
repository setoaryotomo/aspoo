@extends('dashboard_layout.index')
@section('content')
    <style>
        .card {
            margin-bottom: 20px;
        }

        .card-header {
            color: white;
        }

        .card-body {
            padding: 0;
        }

        .data-label {
            font-weight: bold;
        }

        .margin-40 {
            margin-left: 40px;
        }

        .margin-70 {
            margin-left: 70px;
        }
    </style>
    <section class="container">
        @php
            $jumlahBarang = count($data->barang);
        @endphp
        <div class="mt-4 mb-4">
            <h1>{{ $data->nama }}</h1>
            <h1 style="display: none">{{ $data->user_id }}</h1>
            <h4>Jumlah Barang : {{ $jumlahBarang }}</h4>
        </div>
        @foreach ($data->barang as $barang)
            @php
                $isDifferentUser = $data->user_id != $barang->barang->user->user_id;
                $headerColor = $isDifferentUser ? 'background-color: #28a745;' : 'background-color: #007bff;';
            @endphp
            <div class="card">
                <div class="card-header" style="{{ $headerColor }}">
                    <div class="card-title text-white"><strong>{{ $barang['nama'] }}</strong>
                        <span class="float-right">
                            <button data-toggle="collapse" class="btn btn-primary"
                                data-target="#collapse{{ $barang->id }}">Detail</button>
                        </span>
                    </div>
                </div>
                <div class="collapse" id="collapse{{ $barang->id }}">
                    <div class="card-body">
                        <div class="p-3">

                            <p class="data-label">Nama Produk:</p>
                            <p>{{ $barang['nama'] }}</p>

                            <p class="data-label">Barang Milik:</p>
                            <p><b>{{ $barang->barang->user->nama }}</b></p>
                            <p style="display: none">{{ $barang->barang->user->user_id }}</p>

                            <p class="data-label">Tipe Barang:</p>
                            <p>{{ $barang['tipe_barang'] }}</p>

                            <p class="data-label">Jenis Barang:</p>
                            <p>{{ $barang['jenis_barang'] }}</p>

                            <p class="data-label">PIRT:</p>
                            <p>{{ $barang['pirt'] == 1 ? 'YA' : '' }}</p>

                            <p class="data-label">Sertifikasi Halal:</p>
                            <p>{{ $barang['sertifikasi_halal'] == 1 ? 'YA' : '' }}</p>

                            <p class="data-label">Daya Tahan Barang:</p>
                            <p>{{ $barang['kategori_daya_tahan_barang'] }}</p>

                            <p class="data-label">Periode Barang:</p>
                            <p>{{ $barang['periode_barang'] }}</p>

                            <p class="data-label">Jumlah Volume Produksi:</p>
                            <p>{{ $barang['jumlah_volume_produksi'] }}</p>

                            <p class="data-label">Jenis Volume Produksi:</p>
                            <p>{{ $barang['jenis_volume_produksi'] }}</p>

                            <p class="data-label">Jumlah Rata-Rata Penjualan:</p>
                            <p>{{ $barang['jumlah_rata2_penjualan'] }}</p>

                            <p class="data-label">Jenis Rata-Rata Penjualan:</p>
                            <p>{{ $barang['jenis_rata2_penjualan'] }}</p>

                            <p class="data-label">Perlakuan Barang Tidak Laku:</p>
                            <p>{{ $barang['perlakuan_barang_tidak_laku'] }}</p>

                            <p class="data-label">Jenis Kemasan:</p>
                            <p>{{ $barang['jenis_kemasan'] }}</p>

                            <p class="data-label">Ukuran Kemasan:</p>
                            <p>{{ $barang['ukuran_kemasan'] }}</p>

                            <p class="data-label">Tempat Barang Dijual:</p>
                            <p>{{ $barang['tempat_barang_dijual'] }}</p>

                            <p class="data-label">Detail Tempat Barang Dijual:</p>
                            <p>{{ $barang['detail_tempat_barang_dijual'] }}</p>
                            
                        </div>
                        <hr>
                        <div class="margin-40">
                            <div class="p-3">
                                @foreach ($barang->bahan as $bahan)
                                    <h2 class="card-header" style="color: black; background-color:#00FF00"><strong>Bahan : {{ $bahan['nama'] }}</strong>
                                    </h2>
                                    <p class="data-label">Nama Bahan :</p>
                                    <p>{{ $bahan['nama'] }}</p>

                                    <p class="data-label">Merek :</p>
                                    <p>{{ $bahan['merk'] }}</p>

                                    <p class="data-label">Sifat Bahan :</p>
                                    <p>{{ $bahan['sifat_bahan'] }}</p>
                                    <div class="margin-70">
                                        <div class="p-3">
                                            @foreach ($bahan->supplier as $supplier)
                                            <h2 class="card-header"
                                                style="color: rgb(255, 255, 255); background-color:#5353ec">
                                                <strong> Supplier : {{ $supplier['nama'] }}</strong>
                                            </h2>
                                                <p class="data-label">Nama Supplier :</p>
                                                <p>{{ $supplier['nama'] }}</p>

                                                <p class="data-label">Alamat Supplier :</p>
                                                <p>{{ $supplier['alamat'] }}</p>

                                                <p class="data-label">Kontak Supplier :</p>
                                                <p>{{ $supplier['kontak'] }}</p>

                                                <p class="data-label">Tempo Pengambilan Barang :</p>
                                                <p>{{ $supplier['tempo_barang'] }}</p>

                                                <p class="data-label">Volume Beli Barang :</p>
                                                <p>{{ $supplier['vol_beli'] }}</p>

                                                <p class="data-label">Jenis Supplier :</p>
                                                <p>{{ $supplier['jenis_supplier'] }}</p>

                                                <p class="data-label">Lama Langganan :</p>
                                                <p>{{ $supplier['lama_langganan'] }}</p>

                                                <p class="data-label">Alasan Berlangganan :</p>
                                                <p>{{ $supplier['alasan'] }}</p>

                                                <p class="data-label">Catatan :</p>
                                                <p>{{ $supplier['catatan'] }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <hr>

                    </div>
                </div>
            </div>
        @endforeach
    </section>
@endsection
