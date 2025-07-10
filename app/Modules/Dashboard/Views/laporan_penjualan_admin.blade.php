@extends('dashboard_layout.index')
@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<style>
    .sales-report {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
    }
    .filter-section {
        background-color: white;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .summary-card {
        background-color: white;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .table-responsive {
        background-color: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
    .master-row {
        background-color: #f8f9fa;
        cursor: pointer;
    }
    .master-row:hover {
        background-color: #e9ecef;
    }
    .child-row {
        background-color: white;
    }
    .child-details {
        display: none;
        background-color: #f8f9fa;
    }
    .child-details.active {
        display: table-row;
    }
    .detail-table {
        width: 100%;
        margin: 10px 0;
    }
    .detail-table th {
        background-color: #e9ecef;
        padding: 8px;
        text-align: left;
    }
    .detail-table td {
        padding: 8px;
        border-bottom: 1px solid #dee2e6;
    }
</style>

<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h5 class="text-white pb-2 fw-bold">Laporan Penjualan</h5>
            </div>
        </div>
    </div>
</div>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <div class="sales-report">
                <!-- Filter Section -->
                <div class="filter-section">
                    <form action="{{ route('laporan.penjualan.admin') }}" method="GET">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="tanggal_mulai">Tanggal Mulai</label>
                                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" 
                                    value="{{ $startDate }}">
                            </div>
                            <div class="col-md-2">
                                <label for="tanggal_selesai">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" 
                                    value="{{ $endDate }}">
                            </div>
                            <div class="col-md-2">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="semua" {{ $status == 'semua' ? 'selected' : '' }}>Semua</option>
                                    <option value="4" {{ $status == '4' ? 'selected' : '' }}>Selesai</option>
                                    <option value="2" {{ $status == '2' ? 'selected' : '' }}>Pending</option>
                                    {{-- <option value="0" {{ $status == '0' ? 'selected' : '' }}>Dibatalkan</option> --}}
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="toko_id">Toko</label>
                                <select class="form-control" id="toko_id" name="toko_id">
                                    <option value="semua" {{ $tokoId == 'semua' ? 'selected' : '' }}>Semua</option>
                                    @foreach($tokos as $toko)
                                        <option value="{{ $toko->user_id }}" {{ $tokoId == $toko->user_id ? 'selected' : '' }}>
                                            {{ $toko->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Summary Card -->
                <div class="summary-card">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Total Penjualan</h5>
                            <h5 class="text-primary">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</h5>
                        </div>
                        <div class="col-md-6 text-right">
                            <p>Periode: {{ date('d M Y', strtotime($startDate)) }} - {{ date('d M Y', strtotime($endDate)) }}</p>
                            <p>Total Transaksi: {{ $totalTransaksi }}</p>
                            {{-- <p>Total Toko: {{ $tokos->count() }}</p> --}}
                            <button onclick="exportPDF()" class="btn btn-success btn-sm">
                                <i class="fas fa-file-pdf"></i> CETAK LAPORAN
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Add this after the Summary Card section and before the Transaction Table section -->
                <div class="summary-card">
                    {{-- <h5>Grafik Penjualan Bulanan</h5> --}}
                    <canvas id="monthlySalesChart" height="100"></canvas>
                </div>

                
                
                <!-- Transaction Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light" style="position: sticky; top: 0; z-index: 1; background: white;">
                            <tr>
                                <th>No</th>
                                <th>Kode Master</th>
                                {{-- <th>Toko</th> --}}
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Pembeli</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $index = 1; @endphp
                            @foreach($transaksiMaster as $masterCode => $transactions)
                                <tr class="master-row" onclick="toggleDetails('details-{{ $index }}')">
                                    <td>{{ $index }}</td>
                                    <td>{{ $masterCode }}</td>
                                    {{-- <td>{{ $transactions->first()->penjual->name ?? '-' }}</td> --}}
                                    <td>{{ date('Y-m-d', strtotime($transactions->first()->created_at)) }}</td>
                                    <td>Rp {{ number_format($transactions->sum('total_biaya'), 0, ',', '.') }}</td>
                                    <td>{{ $transactions->first()->pembeli->name }}</td>
                                    <td>
                                        @if($transactions->first()->status == 4)
                                            <span class="status-completed">Selesai</span>
                                        @elseif($transactions->first()->status == 1)
                                            <span class="status-pending">Diproses</span>
                                        @else
                                            <span class="status-cancelled">Diproses</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-info" onclick="showTransactionDetails('{{ $masterCode }}')">
                                            <i class="fas fa-eye"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Detail Transaksi -->
                                <tr class="child-details" id="details-{{ $index }}" style="display: none">
                                    <td colspan="6">
                                        <div style="padding: 15px;">
                                            {{-- <h5>Detail Transaksi</h5> --}}
                                            @foreach($transactions as $trx)
                                                <div style="margin-bottom: 20px; border: 1px solid #dee2e6; border-radius: 5px; padding: 10px;">
                                                    {{-- <h6>Transaksi: {{ $trx->kode_transaksi }}</h6> --}}
                                                    <p>Toko: {{ $trx->penjual->name ?? '-' }}</p>
                                                    {{-- <p>Tanggal: {{ date('Y-m-d H:i:s', strtotime($trx->created_at)) }}</p> --}}
                                                    <p>Total: Rp {{ number_format($trx->total_biaya, 0, ',', '.') }}</p>
                                                    
                                                    <table class="detail-table">
                                                        <thead>
                                                            <tr>
                                                                {{-- <th>Kode</th> --}}
                                                                <th>Nama Barang</th>
                                                                <th>Harga</th>
                                                                <th>Jumlah</th>
                                                                {{-- <th>Subtotal</th> --}}
                                                                <th>Ongkir</th>
                                                                <th>Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($trx->dataChildren as $child)
                                                                <tr>
                                                                    {{-- <td>{{ $trx->kode_transaksi }}</td> --}}
                                                                    <td>{{ $child->barang->nama_barang ?? 'Barang tidak tersedia' }}</td>
                                                                    <td>Rp {{ number_format($child->harga, 0, ',', '.') }}</td>
                                                                    <td>{{ $child->jumlah }}</td>
                                                                    {{-- <td>Rp {{ number_format($child->harga * $child->jumlah, 0, ',', '.') }}</td> --}}
                                                                    <td>Rp {{ number_format($trx->biaya_pengiriman, 0, ',', '.') }}</td>
                                                                    <td>Rp {{ number_format($child->harga * $child->jumlah + $trx->biaya_pengiriman, 0, ',', '.') }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                @php $index++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Transaction Details -->
<div class="modal fade" id="transactionDetailModal" tabindex="-1" role="dialog" aria-labelledby="transactionDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transactionDetailModalLabel">Detail Transaksi</h5>
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> --}}
            </div>
            <div class="modal-body" id="transactionDetailContent">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Prepare data for the chart
        const transaksiMaster = @json($transaksiMaster);
        
        // Group by month and calculate monthly sales for completed transactions only
        const monthlySales = {};
        Object.values(transaksiMaster).forEach(group => {
            // Filter only completed transactions (status = 4)
            const completedTransactions = group.filter(transaction => transaction.status == 4);
            
            if (completedTransactions.length > 0) {
                const date = new Date(completedTransactions[0].created_at);
                const monthYear = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`;
                const total = completedTransactions.reduce((sum, transaction) => sum + transaction.total_biaya, 0);
                
                if (!monthlySales[monthYear]) {
                    monthlySales[monthYear] = 0;
                }
                monthlySales[monthYear] += total;
            }
        });

        // Sort months chronologically
        const sortedMonths = Object.keys(monthlySales).sort();
        
        // Prepare chart data with month names in Indonesian
        const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                           'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        const labels = sortedMonths.map(monthYear => {
            const [year, month] = monthYear.split('-');
            return `${monthNames[parseInt(month) - 1]} ${year}`;
        });
        
        const data = sortedMonths.map(monthYear => monthlySales[monthYear]);

        // Create the chart
        const ctx = document.getElementById('monthlySalesChart').getContext('2d');
        const monthlySalesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Penjualan Bulanan',
                    data: data,
                    backgroundColor: 'rgba(40, 167, 69, 0.5)', // Green color for completed status
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        bar: {
                            barPercentage: 0.6,
                            categoryPercentage: 0.8
                        }
                    }
                },
                elements: {
                    bar: {
                        borderWidth: 1,
                        borderRadius: 4,
                        borderSkipped: false
                    }
                },
                layout: {
                    padding: {
                        left: 10,
                        right: 10,
                        top: 0,
                        bottom: 0
                    }
                }
            }
        });
    });
</script>

<script>
    function exportPDF() {
        const startDate = document.getElementById('tanggal_mulai').value;
        const endDate = document.getElementById('tanggal_selesai').value;
        const status = document.getElementById('status').value;
        const tokoId = document.getElementById('toko_id').value;
        
        const exportUrl = `/dashboard/export-pdf?tanggal_mulai=${startDate}&tanggal_selesai=${endDate}&status=${status}&toko_id=${tokoId}`;
        window.open(exportUrl, '_blank');
    }

    function toggleDetails(id) {
        const element = document.getElementById(id);
        element.classList.toggle('active');
    }
</script>

<script>
    function showTransactionDetails(masterCode) {
        // Fetch transaction details via AJAX
        $.ajax({
            url: '/dashboard/get-transaction-details',
            type: 'GET',
            data: {
                master_code: masterCode
            },
            success: function(response) {
                $('#transactionDetailContent').html(response);
                $('#transactionDetailModal').modal('show');
            },
            error: function(xhr) {
                alert('Gagal memuat detail transaksi');
            }
        });
    }

    function exportPDF() {
        const startDate = document.getElementById('tanggal_mulai').value;
        const endDate = document.getElementById('tanggal_selesai').value;
        const status = document.getElementById('status').value;
        const tokoId = document.getElementById('toko_id').value;
        
        const exportUrl = `/dashboard/export-pdf?tanggal_mulai=${startDate}&tanggal_selesai=${endDate}&status=${status}&toko_id=${tokoId}`;
        window.open(exportUrl, '_blank');
    }
</script>
@endsection