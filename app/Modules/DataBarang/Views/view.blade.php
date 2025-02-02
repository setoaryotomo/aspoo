@extends('dashboard_layout.index')
@section('content')

<style>
    .product-image {
        float: right;
        margin-left: 20px;
        width: 200px;
        height: auto;
    }

    /* Styling untuk informasi nama dan jumlah barang */
    .product-info {
        display: flex;
        align-items: center;
    }

    .card {
        margin-bottom: 20px;
    }

    .card-header {
        background-color: #007bff;
        color: white;
    }

    .card-body {
        padding: 0;
    }

    .data-label {
        background-color: #007bff;
        /* Warna latar belakang */
        color: #fff;
        /* Warna teks */
        padding: 5px 10px;
        /* Padding untuk label data */
        border-radius: 5px;
        /* Corner radius atau sudut */
    }

    .data-value {
        font-size: 16px;
        /* Ukuran font untuk nilai data */
        color: #333;
        /* Warna untuk nilai data */
        margin-bottom: 8px;
        /* Spasi antara nilai data */
    }

    /* Tampilan baris dan kolom */
    .row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    /* Gaya untuk kolom */
    .col-sm-4 {
        width: 30%;
    }

    /* Gaya untuk paragraf */
    p {
        margin: 5px 0;
        line-height: 1.5;
        font-weight: bold;
        /* Tinggi baris untuk paragraf */
    }

    .margin-40 {
        margin-left: 40px;
    }

    .margin-70 {
        margin-left: 70px;
    }

</style>
<section class="container mt-4">
    <img src="{{URL::asset('/img/test1.png')}}" alt="Foto Produk" class="product-image">
    <div class="product-info">
        <div class="product-details">
            <h1>Nama Toko : CV Merah Putih</h1>
            <h4>Jumlah Barang: 5</h4>
        </div>

        <!-- Foto produk -->

    </div>

    <div class="card">
        <div class="card-header bg-primary">
            <div class="card-title text-white"><strong>Nama Produk 1</strong>
                <span class="float-right">
                    <button data-toggle="collapse" class="btn btn-primary" data-target="#collapse1">Detail</button>
                </span>
            </div>
        </div>
        <div class="collapse" id="collapse1">
            <div class="card-body">
                <div class="p-3">
                    <!-- Isi Detail Produk -->
                    <div class="row mt-4">
                        <div class="col-sm-4">
                            <p class="data-label">Nama Produk: Coklat </p>
                            <p>Contoh Nama Produk</p>

                            <p class="data-label">Tipe Barang:</p>
                            <p>Contoh Tipe Barang</p>

                            <p class="data-label">Jenis Barang:</p>
                            <p>Contoh Jenis Barang</p>

                            <p class="data-label">PIRT:</p>
                            <p>YA</p>

                            <p class="data-label">Sertifikasi Halal:</p>
                            <p>YA</p>

                            <p class="data-label">Daya Tahan Barang:</p>
                            <p>Contoh Daya Tahan Barang</p>
                        </div>

                        <div class="col-sm-4">

                            <p class="data-label">Periode Barang:</p>
                            <p>Contoh Periode Barang</p>

                            <p class="data-label">Jumlah Volume Produksi:</p>
                            <p>Contoh Jumlah Volume Produksi</p>

                            <p class="data-label">Jenis Volume Produksi:</p>
                            <p>Contoh Jenis Volume Produksi</p>

                            <p class="data-label">Jumlah Rata-Rata Penjualan:</p>
                            <p>Contoh Jumlah Rata-Rata Penjualan</p>

                            <p class="data-label">Jenis Rata-Rata Penjualan:</p>
                            <p>Contoh Jenis Rata-Rata Penjualan</p>
                        </div>

                        <div class="col-sm-4">

                            <p class="data-label">Perlakuan Barang Tidak Laku:</p>
                            <p>Contoh Perlakuan Barang Tidak Laku</p>

                            <p class="data-label">Jenis Kemasan:</p>
                            <p>Contoh Jenis Kemasan</p>

                            <p class="data-label">Ukuran Kemasan:</p>
                            <p>Contoh Ukuran Kemasan</p>

                            <p class="data-label">Tempat Barang Dijual:</p>
                            <p>Contoh Tempat Barang Dijual</p>

                            <p class="data-label">Detail Tempat Barang Dijual:</p>
                            <p>Contoh Detail Tempat Barang Dijual</p>
                        </div>
                    </div>
                </div>
            </div>


            <hr>

            <div class="margin-40">
                <div class="p-3">
                    <h2 class="card-header" style="color: black; background-color:#00FF00">
                        <strong>Bahan : Contoh Nama Bahan</strong>
                    </h2>
                    <!-- Isi Detail Bahan -->
                    <div class="row mt-4">
                        <div class="col-sm-4">
                            <p class="data-label">Nama Bahan :</p>
                            <p>Contoh Nama Bahan</p>
                        </div>

                        <div class="col-sm-4">
                            <p class="data-label">Merek :</p>
                            <p>Contoh Merek</p>
                        </div>

                        <div class="col-sm-4">
                            <p class="data-label">Sifat Bahan :</p>
                            <p>Contoh Sifat Bahan</p>
                        </div>

                    </div>

                    <hr>

                    <h2 class="card-header" style="color: rgb(255, 255, 255); background-color:#5353ec">
                        <strong> Supplier : Contoh Nama Supplier</strong>
                    </h2>
                    <!-- Isi Detail Supplier -->
                    <div class="row mt-4">
                        <div class="col-sm-6">

                            <p class="data-label">Nama Supplier :</p>
                            <p>Contoh Nama Supplier</p>

                            <p class="data-label">Alamat Supplier :</p>
                            <p>Contoh Alamat Supplier</p>

                            <p class="data-label">Kontak Supplier :</p>
                            <p>Contoh Kontak Supplier</p>

                            <p class="data-label">Tempo Pengambilan Barang :</p>
                            <p>Contoh Tempo Pengambilan Barang</p>

                            <p class="data-label">Volume Beli Barang :</p>
                            <p>Contoh Volume Beli Barang</p>
                        </div>

                        <div class="col-sm-6">
                            <p class="data-label">Jenis Supplier :</p>
                            <p>Contoh Jenis Supplier</p>

                            <p class="data-label">Lama Langganan :</p>
                            <p>Contoh Lama Langganan</p>

                            <p class="data-label">Alasan Berlangganan :</p>
                            <p>Contoh Alasan Berlangganan</p>

                            <p class="data-label">Catatan :</p>
                            <p>Contoh Catatan</p>
                        </div>
                    </div>
                </div>
            </div>


            <hr>

        </div>
</section>
@endsection
