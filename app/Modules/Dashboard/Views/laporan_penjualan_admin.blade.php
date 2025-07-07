@extends('dashboard_layout.index')
@section('content')
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
</style>

<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h5 class="text-white pb-2 fw-bold">Laporan Penjualan</h5>
                {{-- <h5 class="text-white op-7 mb-2">Ringkasan transaksi penjualan semua toko</h5> --}}
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
                                    <option value="0" {{ $status == '0' ? 'selected' : '' }}>Dibatalkan</option>
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
                            <p>Total Toko: {{ $tokos->count() }}</p>
                            
                            <!-- Updated Export PDF link dengan parameter filter -->
                            {{-- <a href="{{ route('laporan.penjualan.export.pdf', [
                                'tanggal_mulai' => $startDate,
                                'tanggal_selesai' => $endDate,
                                'status' => $status,
                                'toko_id' => $tokoId
                            ]) }}" 
                            class="btn btn-success btn-sm" 
                            target="_blank">
                                <i class="fas fa-file-pdf"></i> EXPORT PDF
                            </a> --}}
                            <button onclick="exportPDF()" class="btn btn-success btn-sm">
                                <i class="fas fa-file-pdf"></i> CETAK LAPORAN
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Transaction Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light" style="position: sticky; top: 0; z-index: 1; background: white;">
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Kode Master</th>
                                <th>Toko</th>
                                {{-- <th>Pelanggan</th> --}}
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksi as $index => $trx)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $trx->kode_transaksi}}</td>
                                <td>{{ $trx->kode_transaksi_master}}</td>
                                <td>{{ $trx->penjual->name}}</td>
                                {{-- <td>{{ $trx->pembeli->name ?? 'Guest' }}</td> --}}
                                <td>{{ date('Y-m-d', strtotime($trx->created_at)) }}</td>
                                <td>Rp {{ number_format($trx->total_biaya, 0, ',', '.') }}</td>
                                {{-- <td>{{ $trx->status_readable}}</td> --}}
                                <td>
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
                </div>
        </div>
    </div>
</div>

<script>
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