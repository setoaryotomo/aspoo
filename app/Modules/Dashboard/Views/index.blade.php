@extends('dashboard_layout.index')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        .dashboard-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 0 0 24px 24px;
            position: relative;
            overflow: hidden;
        }

        .dashboard-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .dashboard-header .page-inner {
            position: relative;
            z-index: 1;
        }

        .dashboard-title {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .dashboard-subtitle {
            font-size: 1.1rem;
            color: rgba(255,255,255,0.9);
            font-weight: 400;
        }

        .stats-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            height: auto;
            min-height: 140px;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 16px 16px 0 0;
        }

        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .stats-card .card-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .stats-card.stock-card .card-icon {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .stats-card.items-card .card-icon {
            background: linear-gradient(135deg, #ffecd2, #fcb69f);
            color: #d97706;
        }

        .stats-card .card-title {
            font-size: 0.875rem;
            font-weight: 500;
            color: #6b7280;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stats-card .card-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
            line-height: 1.2;
        }

        .stats-card .card-change {
            font-size: 0.875rem;
            color: #10b981;
            margin-top: 0.5rem;
            font-weight: 500;
        }

        .report-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            padding: 2rem;
            color: white;
            text-decoration: none;
            display: block;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            min-height: 140px;
        }

        .report-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            transition: all 0.3s ease;
        }

        .report-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
            text-decoration: none;
            color: white;
        }

        .report-card:hover::before {
            top: -20%;
            right: -20%;
        }

        .report-card .card-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            backdrop-filter: blur(10px);
        }

        .report-card .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
            position: relative;
            z-index: 1;
        }

        .report-card .card-description {
            font-size: 0.875rem;
            opacity: 0.9;
            margin-top: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .container-fluid {
            padding: 0 1.5rem;
        }

        .row {
            margin: 0 -12px;
        }

        .col-md-6, .col-md-12 {
            padding: 0 12px;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1.5rem;
            padding-left: 0.5rem;
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        .animate-slide-up {
            animation: slideUp 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { 
                opacity: 0;
                transform: translateY(20px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stats-row {
            margin-bottom: 2rem;
        }

        @media (max-width: 768px) {
            .dashboard-title {
                font-size: 1.5rem;
            }
            
            .stats-card {
                margin-bottom: 1rem;
            }
            
            .container-fluid {
                padding: 0 1rem;
            }
        }
    </style>

    <div class="dashboard-header">
        <div class="page-inner py-5">
            <div class="d-flex align-items-center justify-content-between">
                <div class="animate-fade-in">
                    <h1 class="dashboard-title">Dashboard</h1>
                    <p class="dashboard-subtitle">SmartAspoo Admin Panel</p>
                </div>
                <div class="animate-fade-in">
                    <i class="bi bi-speedometer2" style="font-size: 3rem; color: rgba(255,255,255,0.3);"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="margin-top: -2rem;">
        <div class="row stats-row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="stats-card stock-card animate-slide-up">
                            <div class="card-icon">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <div class="card-title">Total Stok</div>
                            <div class="card-value" id="total-stok">{{ $data['total_stock'] }}</div>
                            {{-- <div class="card-change">
                                <i class="bi bi-arrow-up"></i> +2.5% dari minggu lalu
                            </div> --}}
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="stats-card items-card animate-slide-up" style="animation-delay: 0.1s;">
                            <div class="card-icon">
                                <i class="bi bi-grid-3x3-gap"></i>
                            </div>
                            <div class="card-title">Total Barang</div>
                            <div class="card-value" id="total-barang">{{ $data['total_barang'] }}</div>
                            {{-- <div class="card-change">
                                <i class="bi bi-arrow-up"></i> +5.2% dari minggu lalu
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <a href="{{ url('dashboard/laporan-penjualan-admin') }}" class="report-card animate-slide-up" style="animation-delay: 0.2s;">
                    <div class="card-icon">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <div class="card-title">Laporan Penjualan</div>
                    <div class="card-description">Lihat detail laporan penjualan</div>
                    <div style="position: absolute; bottom: 1rem; right: 1rem;">
                        <i class="bi bi-arrow-right-circle" style="font-size: 1.5rem; opacity: 0.7;"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Menambahkan animasi counter untuk angka
        function animateCounter(element, start, end, duration) {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                const value = Math.floor(progress * (end - start) + start);
                element.textContent = value.toLocaleString();
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        // Jalankan animasi ketika halaman dimuat
        document.addEventListener("DOMContentLoaded", function() {
            const totalStokElement = document.getElementById('total-stok');
            const totalBarangElement = document.getElementById('total-barang');
            
            const totalStok = parseInt(totalStokElement.textContent);
            const totalBarang = parseInt(totalBarangElement.textContent);
            
            // Reset nilai awal
            totalStokElement.textContent = '0';
            totalBarangElement.textContent = '0';
            
            // Animasi counter
            setTimeout(() => {
                animateCounter(totalStokElement, 0, totalStok, 1500);
            }, 500);
            
            setTimeout(() => {
                animateCounter(totalBarangElement, 0, totalBarang, 1500);
            }, 700);
        });

        // Data untuk chart (tetap sama dengan yang asli)
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

        var myChart;

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