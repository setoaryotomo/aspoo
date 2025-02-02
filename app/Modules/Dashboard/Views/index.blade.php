@extends('dashboard_layout.index')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .card {
            border-radius: 8px;
            height: 130px;
        }
    </style>

    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">Dashboard</h2>
                    <h5 class="text-white op-7 mb-2">SmartAspoo Admin Panel</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-md-6 mt-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card" style="background-color: #E1EFFA; color: #3621c2;">
                            <div class="card-body">
                                <h5 class="card-text">Total Stok Barang</h5>
                                <h1 class="card-text fw-bold" id="total-stok">{{ $data['total_stock'] }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card" style="background-color: #E1EFFA; color: #3621c2;">
                            <div class="card-body">
                                <h5 class="card-text">Total Barang</h5>
                                <h1 class="card-text fw-bold" id="total-stok">{{ $data['total_barang'] }}</h1>
                            </div>
                        </div>
                    </div>
                    <!-- Tabel Data Barang -->
                    <div class="col-md-12 mt-4" mb-4>
                        <div class="table-responsive" style="background-color: #E1EFFA; color: #3621c2;">
                            <div class="card-header align-items-center">
                                <div class="card-head-row align-items-center">
                                    <h4 class="card-title text-center" style="color: #3621c2"><strong>Data Barang</strong>
                                    </h4>
                                </div>
                            </div>
                            <div class="card-body px-0 pt-0 pb-2">
                                <div class="table-responsive p-0">
                                    <table class="table table-responsive align-items-center mb-0 table-hover"
                                        style="background-color: #E1EFFA;">
                                        <thead>
                                            <tr class="font-weight-bold" style="color: black">
                                                <th>No</th>
                                                <th>Nama Barang</th>
                                                <th>Harga Supplier</th>
                                                <th>Harga Umum</th>
                                                <th>Stok</th>
                                                <th>Berat (gram)</th>
                                                <th>Satuan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $nomor = 1;
                                            @endphp
                                            @foreach ($data['get_data'] as $barang)
                                                <tr>
                                                    <td>{{ $nomor++ }}</td>
                                                    <td> {{ $barang->nama_barang }}</td>
                                                    <td>{{ $barang->harga_supplier }}</td>
                                                    <td>{{ $barang->harga_umum }}</td>
                                                    <td>{{ $barang->stock_global }}</td>
                                                    <td>{{ $barang->berat }}</td>
                                                    <td>{{ $barang->satuan_id }}</td>
                                            @endforeach
                                            </tr>
                                            <!-- Tambahkan baris data sesuai kebutuhan -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <!-- Kolom Kanan -->
            <div class="col-md-6 mt-4">
                <canvas id="myPieChart" style="background-color: #E1EFFA;"></canvas>
            </div>

            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-12">
                        <select name="periodeSelect" id="periodeSelect" onchange="runChart()" class="form-control">
                            <option value="7" selected>7 hari</option>
                            <option value="14">14 hari</option>
                            <option value="30">30 hari</option>
                            <option value="all">Semua</option>
                        </select>
                        <canvas id="barChart1" width="400" height="300"></canvas>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        const data = {
            labels: [
                'Transaksi Diterima Penjual',
                'Transaksi Ditolak Penjual',
                'Uang Diterima ASPOO',
                'Uang Ditolak ASPOO',
                'Barang Dikirim Oleh Penjual',
                'Barang Tidak Jadi Dikirim Oleh Penjual',
                'barang Diterima Oleh Pembeli',
                'barang Tidak Diterima',
                'Transaksi Dibuat Oleh Pembeli'
            ],
            datasets: [{
                label: 'Transaksi',
                data: [{{ $data['transaksi_berhasil'] }}, {{ $data['transaksi_gagal'] }},
                    {{ $data['uang_diterima'] }}, {{ $data['uang_ditolak'] }},
                    {{ $data['barang_dikirim'] }}, {{ $data['barang_tidak_dikirim'] }},
                    {{ $data['barang_diterima'] }}, {{ $data['barang_tidak_diterima'] }},
                    {{ $data['transaksi_dibuat'] }}
                ],
                backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFA500',
                    '#00000',
                    '#FFD700',
                    '#D6BD68',
                    '#FF0000',
                    '#D3D3D3',
                    '#800080'
                ],
                borderColor: "#BBBBBB",
                hoverOffset: 4
            }]
        };

        const ctx = document.getElementById('myPieChart');
        const config = {
            type: 'pie',
            data: data,
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Chart Status Transaksi',
                        color: "#3621c2"

                    },
                    legend: {
                        position: "bottom"
                    }
                }
            }
        };

        const myPieChart = new Chart(ctx, config);
        var myChart;

        document.addEventListener("DOMContentLoaded", function() {

            runChart()
            // runChart2()
        });

        function runChart2() {
            var ctx2 = document.getElementById('barChart2').getContext('2d');
            var data2 = {
                labels: ['Bantir', 'Karangjati', 'Kembangarum', 'Ngalian'],
                datasets: [{
                    label: 'Grafik Supplier Gula',
                    data: [20, 5, 5, 10],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            };
            var config2 = {
                type: 'bar',
                data: data2,
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                stepSize: 10,
                                max: 50
                            }
                        }]
                    }
                }
            };
            new Chart(ctx2, config2);
        }

        function runChart() {
            var periode = document.getElementById("periodeSelect").value

            var axios = fetch("{{ url('dashboard/komposisi') }}?periode=" + periode, {
                method: "GET",

            }).then(x => x.json()).then(function(result) {
                var key = Object.keys(result.result)
                var value = Object.values(result.result)
                var max = Math.ceil((Math.max(...value)) / 10) * 10;
                console.log(value, max)
                var barchart = document.getElementById('barChart1')
                var ctx1 = barchart.getContext('2d');
                if (myChart) {
                    myChart.destroy();
                }
                var data1 = {
                    labels: key,
                    datasets: [{
                        label: 'Grafik Komposisi',
                        data: value,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                };
                var config1 = {
                    type: 'bar',
                    data: data1,
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    stepSize: 10,
                                    max: max
                                }
                            }]
                        }
                    }
                };
                myChart = new Chart(ctx1, config1);
            })


        }
    </script>
@endsection
