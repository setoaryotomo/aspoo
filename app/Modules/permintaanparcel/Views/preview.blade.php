@extends('dashboard_layout.index')
@section('content')
<style>
    .border-primary {
    border: 2px solid #17a2b8 !important;
}
</style>
    <div class="container mt-4 mb-0" id="container">
        <section class="card mb-0">
            <div class="card-header">
                <div class="card-title">Detail</div>
                {{-- <div class="card-title">Detail Permintaan Parcel</div> --}}
            </div>
            <div class="card-body">
                <div class="row">
                    <section class="col-md-12">
                        <section class="row">
                            <div class="col-md-6">
                                <p><b>Nama Pemesan : </b> {{ $data->user->name }}</p>

                            </div>
                            <p><b>Alamat : </b>
                                {{ json_decode($data->alamat)->alamat_lengkap .
                                    ', ' .
                                    json_decode($data->alamat)->kelurahan->name .
                                    ', ' .
                                    json_decode($data->alamat)->kecamatan->name .
                                    ', ' .
                                    json_decode($data->alamat)->kota->name .
                                    ', ' .
                                    json_decode($data->alamat)->provinsi->name }}
                            </p>
                            <p><b>Status : </b>
                                @if (count($card['selectedItems']) > 0)
                                    PESAN
                                @else
                                    CEK
                                @endif
                            </p>
                        </section>
                    </section>
                    <hr>
                    <section class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    {{-- <td>Nomor</td> --}}
                                    <td>Harga Yang Di Inginkan</td>
                                    <td>Berat Yang Di Inginkan</td>
                                    {{-- <td>Barang Permintaan</td> --}}
                                    <td>Tanggal Dibutuhkan</td>
                                    {{-- <td>Alamat</td> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $number = 1;
                                @endphp
                                <tr>
                                    {{-- <td>{{ $number++ }}</td> --}}
                                    <td>{{ $data->harga }}</td>
                                    <td>{{ $data->berat }}</td>
                                    {{-- <td>{{ $data->barang }}</td> --}}
                                    <td>{{ $data->tanggal }}</td>
                                    {{-- <td>{{ $data->alamat }}</td> --}}
                                </tr>
                            </tbody>
                        </table>
                    </section>

                    <!-- Rekomendasi Parcel Section -->
                    <section class="col-md-12 mt-4">
                        <h4 class="text-center mb-4">Rekomendasi Parcel</h4>
                        @php
                            $recommendations = json_decode($data->barang, true);
                            $selectedItemIds = $card['selectedItems']->pluck('barang.id')->toArray();
                            $deliveryCity = json_decode($data->alamat)->kota->name;
                        @endphp

                        <div class="row">
                            @foreach ($recommendations as $index => $recommendation)
                                @php
                                    // Check if all items in this recommendation are in the selected items
                                    $isFullySelected = collect($recommendation['items'])->every(function ($item) use (
                                        $selectedItemIds,
                                    ) {
                                        return in_array($item['id'], $selectedItemIds);
                                    });

                                    // Determine background color
                                    $bgClass = $isFullySelected
                                        ? 'bg-info'
                                        : ($index == 0
                                            ? 'bg-warning'
                                            : ($index == 1
                                                ? 'bg-warning'
                                                : 'bg-warning'));
                                    
                                    $borderClass = $isFullySelected ? 'border-primary' : '';
                                @endphp

                                <div class="col-md-4 mb-4">
                                    <div class="card h-100 {{ $borderClass }}">
                                        <div class="card-header {{ $bgClass }} text-white">
                                            <h5 class="card-title mb-0" style="color: white">
                                                Rekomendasi {{ $index + 1 }}
                                                @if ($isFullySelected)
                                                    (Selected)
                                                @endif
                                            </h5>
                                            <small>Total Item: {{ count($recommendation['items']) }}</small>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <p class="font-weight-bold mb-1">Total Harga: Rp
                                                    {{ number_format($recommendation['totalPrice'], 0, ',', '.') }}</p>
                                                Selisih: Rp
                                                {{ number_format($recommendation['totalPrice'] - $data->harga, 0, ',', '.') }}
                                                {{-- <p class="mb-0">Total Berat:
                                                    {{ number_format($recommendation['totalWeight'] / 1000, 2) }} kg
                                                    ({{ $recommendation['totalWeight'] }} gram)</p> --}}
                                                <p class="font-weight-bold mb-1">Total Berat:
                                                    {{ $recommendation['totalWeight'] }} gram</p>Selisih:
                                                {{ $recommendation['totalWeight'] - $data->berat }} gram
                                            </div>
                                            <div class="table-responsive">
                                                <ul>
                                                    @foreach ($recommendation['items'] as $item)
                                                        @php
                                                            // Check if the seller's city matches the delivery city
                                                            $isCityMatch = $item['sellerCity'] === $deliveryCity;
                                                        @endphp
                                                        <img src="{{ $item['thumbnail'] }}" alt="" style="width: 200px; height: 200px; object-fit: cover; margin-right: 10px;display: none;">
                                                            <b>{{ $item['name'] }}</b> <br>Berat : {{ $item['berat'] }}g
                                                            <br>Harga : Rp {{ number_format($item['price'], 0, ',', '.') }}
                                                            <br> Toko: {{ $item['seller'] }} <br>
                                                            <span style="color: {{ $isCityMatch ? 'blue' : 'red' }}">({{ $item['sellerCity'] }})</span>
                                                            <br><br><br>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-footer" style="display: none">
                                            <button
                                                class="btn {{ $index == 0 ? 'btn-success' : ($index == 1 ? 'btn-info' : 'btn-primary') }} btn-block btn-pilih-rekomendasi"
                                                data-items='@json($recommendation['items'])'>
                                                Pilih Paket Ini
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <!-- Selected Items Section -->
                    @if (count($card['selectedItems']) > 0)
                        <section class="col-md-12 mt-4" style="display: none">
                            <h4 class="text-center mb-4">Barang Terpilih</h4>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Barang</th>
                                        <th>Berat</th>
                                        <th>Harga</th>
                                        {{-- <th>Aksi</th> --}}
                                    </tr>
                                </thead>
                                <tbody id="selected-items">
                                    @php
                                        $number = 1;
                                    @endphp
                                    @foreach ($card['selectedItems'] as $select)
                                        <tr>
                                            <td>{{ $number++ }}</td>
                                            <td>{{ $select->barang->nama_barang }}</td>
                                            <td>{{ $select->barang->thumbnail }}</td>
                                            <td>{{ number_format($select->barang->harga_user, 2) }}</td>
                                            <td>
                                                <button class="btn btn-danger btn-sm remove-item-button"
                                                    data-id="{{ $select->barang->id }}">-</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-right"><strong>Total :</strong></td>
                                        <td id="total-weight">0</td>
                                        <td id="total-price">Rp. 0</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </section>
                    @endif

                    <div class="card-footer">
                        <div class="float-right">
                            <button class="btn btn-primary btn-sm" id="save-button" data-id="{{ $data->id }}"
                                style="display: none">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        (function() {
            let selectedItems = @json($card['selectedItems']).map(item => ({
                id: item.barang.id,
                name: item.barang.nama_barang,
                berat: item.barang.berat,
                price: item.barang.harga_user
            }));

            let totalPrice = 0;
            updateSelectedItems();

            // Event listener untuk tombol pilih rekomendasi
            document.querySelectorAll('.btn-pilih-rekomendasi').forEach(button => {
                button.addEventListener('click', function() {
                    const items = JSON.parse(this.getAttribute('data-items'));

                    // Reset selected items
                    selectedItems = items.map(item => ({
                        id: item.id,
                        name: item.name,
                        berat: item.berat,
                        price: item.price
                    }));

                    updateSelectedItems();
                    alert('Paket rekomendasi berhasil dipilih!');
                });
            });

            document.querySelectorAll('.remove-item-button').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    selectedItems = selectedItems.filter(item => item.id !== id);
                    updateSelectedItems();
                });
            });

            document.getElementById('save-button').addEventListener('click', saveSelectedItems);

            function updateSelectedItems() {
                const selectedItemsContainer = document.getElementById('selected-items');
                selectedItemsContainer.innerHTML = '';
                totalPrice = 0;
                totalWeight = 0;

                selectedItems.forEach((item, index) => {
                    totalPrice += item.price;
                    totalWeight += item.berat;
                    selectedItemsContainer.innerHTML += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${item.name}</td>
                    <td>${item.berat} Gram</td>
                    <td>Rp ${item.price.toLocaleString()}</td>
                    <td>
                        <button class="btn btn-danger btn-sm remove-item-button" data-id="${item.id}" style="display: none">-</button>
                    </td>
                </tr>
            `;
                });

                // Reattach event listeners for new remove buttons
                document.querySelectorAll('.remove-item-button').forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        selectedItems = selectedItems.filter(item => item.id !== id);
                        updateSelectedItems();
                    });
                });

                document.getElementById('total-weight').innerText = totalWeight + ' Gram';
                document.getElementById('total-price').innerText = 'Rp ' + totalPrice.toLocaleString();
            }

            function saveSelectedItems() {
                const id = document.getElementById('save-button').getAttribute('data-id');
                const payload = {
                    items: selectedItems,
                    total: totalPrice
                };

                fetch(`/permintaan-parcel/save-selected-items/${id}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(payload)
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Barang berhasil disimpan');
                            // Konversi ke JSON dan tampilkan di konsol
                            const selectedItemsJson = JSON.stringify(selectedItems, null);
                            console.log(selectedItemsJson); // Tampilkan di konsol
                        } else {
                            alert('Terjadi kesalahan, coba lagi');
                        }
                    }).catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan, coba lagi');
                    });
            }
        })();
    </script>
@endsection
