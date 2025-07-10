<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<div class="transaction-details">
    <h6>Kode Transaksi Master: {{ $masterCode }}</h6>
    <p>Total Transaksi: Rp {{ number_format($totalAmount, 0, ',', '.') }}</p>
    <p>{{ $transactions->first()->created_at }}</p>
    <p><strong>Status:</strong> 
        @if($transactions->first()->status == 4)
            <span class="text-success">Selesai</span>
        @elseif($transactions->first()->status == 1)
            <span class="text-warning">Diproses</span>
        @else
            <span class="text-danger">Diproses</span>
        @endif
    </p>
    
    @foreach($transactions as $trx)
        <div class="store-transaction" style="margin-bottom: 20px; border: 1px solid #dee2e6; border-radius: 5px; padding: 10px;">
            <p><strong>Toko:</strong> {{ $trx->penjual->name ?? '-' }}</p>
            {{-- <p><strong>Tanggal:</strong> {{ date('Y-m-d H:i:s', strtotime($trx->created_at)) }}</p> --}}
            <p><strong>Total:</strong> Rp {{ number_format($trx->total_biaya, 0, ',', '.') }}</p>
            {{-- <p><strong>Status:</strong> 
                @if($trx->status == 4)
                    <span class="text-success">Selesai</span>
                @elseif($trx->status == 1)
                    <span class="text-warning">Diproses</span>
                @else
                    <span class="text-danger">Diproses</span>
                @endif
            </p> --}}
            
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Ongkir</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trx->dataChildren as $child)
                        <tr>
                            <td>{{ $child->barang->nama_barang ?? 'Barang tidak tersedia' }}</td>
                            <td>Rp {{ number_format($child->harga, 0, ',', '.') }}</td>
                            <td>{{ $child->jumlah }}</td>
                            <td>Rp {{ number_format($trx->biaya_pengiriman, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($child->harga * $child->jumlah + $trx->biaya_pengiriman, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
</div>