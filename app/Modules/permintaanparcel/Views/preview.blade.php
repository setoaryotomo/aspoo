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
            </div>
            <div class="card-body">
                <div class="row">
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
                            @if ($data->review_komposisi)
                            <p><b>Review Komposisi : </b>{{ $data->review_komposisi }}</p>
                            @endif
                            @if ($data->review_pelayanan)
                            <p><b>Review Pelayanan : </b>{{ $data->review_pelayanan }}</p>
                            @endif
                            @if ($data->komentar)
                            <p><b>Komentar : </b>{{ $data->komentar }}</p>
                            @endif
                            <br>
                        </section>
                        <hr style="color: rgba(0, 0, 0, 0.201)">
                    </section>
                    
                    <section class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    {{-- <td>Nomor</td> --}}
                                    <td><b>Harga Yang Diinginkan</b></td>
                                    <td><b>Berat Yang Diinginkan</b></td>
                                    {{-- <td>Barang Permintaan</td> --}}
                                    <td><b>Tanggal Dibutuhkan</b></td>
                                    {{-- <td>Alamat</td> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $number = 1;
                                    $beratKg = $data->berat/1000;
                                @endphp
                                <tr>
                                    {{-- <td>{{ $number++ }}</td> --}}
                                    <td>Rp. {{ $data->harga }}</td>
                                    <td>{{ $beratKg }} Kg</td>
                                    {{-- <td>{{ $data->barang }}</td> --}}
                                    <td>{{ $data->tanggal }}</td>
                                    {{-- <td>{{ $data->alamat }}</td> --}}
                                </tr>
                            </tbody>
                        </table>
                    </section>

                    @if ($data->transaksi)
                        <section class="col-md-12 mt-4">
                            <div class="alert alert-info">
                                <p><b>Kode Transaksi Master:</b>
                                    @if ($data->transaksi->status == "")
                                    <a href="{{ url('approve-transaksi/preview/' . $data->transaksi->kode_transaksi) }}"
                                        class="text-primary font-weight-bold">
                                        {{-- class="text-primary font-weight-bold" target="_blank"> --}}
                                        {{ $data->transaksi->kode_transaksi }}
                                        <i class="fas fa-external-link-alt ml-1"></i>
                                    </a>
                                    @elseif ($data->transaksi->status == 4)
                                        {{-- class="text-primary font-weight-bold" target="_blank"> --}}
                                        {{ $data->transaksi->kode_transaksi_master }}
                                    @else
                                        {{ $data->transaksi->kode_transaksi_master }}
                                    @endif
                                </p>
                            </div>
                        </section>
                    @endif

                    <!-- Add this section after the Rekomendasi Parcel section -->
                    <section class="col-md-12 mt-4">
                        <div class="card">
                            <div class="card-body">
                                @php
                                    $recommendations = json_decode($data->barang, true);
                                    $firstRecommendation = $recommendations[0] ?? null;
                                    $userFilters = $firstRecommendation['userFilters'] ?? null;
                                @endphp

                                @if($userFilters)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 style="color: green">Filter yang diinginkan:</h6>
                                            @php
                                                $desiredCategories = $userFilters['desiredCategories'] ?? [];
                                                $desiredFilters = $userFilters['desiredFilters'] ?? [];
                                                
                                                // Check if kategori umum exists and is different from kategori
                                                $showKategoriUmum = isset($desiredFilters['kategori_umum']) && 
                                                                   array_diff($desiredFilters['kategori_umum'], $desiredCategories);
                                            @endphp
                                            
                                            <p>Kategori: {{ implode(', ', $desiredCategories) }}</p>
                                            
                                            @foreach($desiredFilters as $filterType => $filters)
                                                @if(count($filters) > 0 && $filterType !== 'kategori_umum')
                                                    <p>{{ ucfirst(str_replace('_', ' ', $filterType)) }}:
                                                        {{ implode(', ', $filters) }}
                                                    </p>
                                                @endif
                                            @endforeach
                                            
                                            @if($showKategoriUmum)
                                                <p>Kategori Umum: {{ implode(', ', $desiredFilters['kategori_umum']) }}</p>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <h6 style="color: red">Filter yang tidak diinginkan:</h6>
                                            @foreach($userFilters['unwantedFilters'] as $filterType => $filters)
                                                @if(count($filters) > 0)
                                                    <p>{{ ucfirst(str_replace('_', ' ', $filterType)) }}:
                                                        {{ implode(', ', $filters) }}
                                                    </p>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <p>No user filters available.</p>
                                @endif
                            </div>
                        </div>
                    </section>

                    <!-- Rekomendasi Parcel Section -->
<!-- Rekomendasi Parcel Section -->
<section class="col-md-12 mt-4">
    <h5 class="text-center mb-4">Rekomendasi Parcel</h5>
    @php
        $recommendations = json_decode($data->barang, true);
        
        // Urutkan rekomendasi berdasarkan jumlah item (descending) dan berat (descending)
        usort($recommendations, function($a, $b) {
            // Pertama urutkan berdasarkan jumlah item
            $itemCountCompare = count($b['items']) - count($a['items']);
            if ($itemCountCompare !== 0) {
                return $itemCountCompare;
            }
            
            // Jika jumlah item sama, urutkan berdasarkan berat (descending)
            return $b['totalWeight'] - $a['totalWeight'];
        });
        
        $selectedItemIds = $card['selectedItems']->pluck('barang.id')->toArray();
        $deliveryCity = json_decode($data->alamat)->kota->name;
        
        // Get user filters from the first recommendation
        $userFilters = $recommendations[0]['userFilters'] ?? null;
        $desiredCategories = $userFilters['desiredCategories'] ?? [];
        $desiredFilters = $userFilters['desiredFilters'] ?? [];
    @endphp

    <div class="row">
        @foreach ($recommendations as $index => $recommendation)
            @php
                // Check if all items in this recommendation are in the selected items
                $isFullySelected = collect($recommendation['items'])->every(function ($item) use ($selectedItemIds) {
                    return in_array($item['id'], $selectedItemIds);
                });

                // Determine background color
                $bgClass = $isFullySelected
                    ? 'bg-primary'
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
                        <h6 class="card-title mb-0" style="color: white">
                            @if ($isFullySelected)
                            Rekomendasi {{ $index + 1 }} <i class="fa-solid fa-check"></i>
                            @else
                            Rekomendasi {{ $index + 1 }}
                            @endif
                        </h6>
                        <small>Total Item: {{ count($recommendation['items']) }}</small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <p class="font-weight-bold mb-1">Total Harga: Rp
                                {{ number_format($recommendation['totalPrice'], 0, ',', '.') }}</p>
                            <p class="font-weight-bold mb-1">Total Berat:
                                {{ $recommendation['totalWeight']/1000 }} Kg</p>
                        </div>
                        <div class="table-responsive">
                            <ul>
                                @foreach ($recommendation['items'] as $item)
                                    @php
                                        // Check if the seller's city matches the delivery city
                                        $isCityMatch = $item['sellerCity'] === $deliveryCity;
                                        
                                        // Check if item matches any desired filters
                                        $matchesCategory = in_array($item['category'], $desiredCategories);
                                        $matchesFilters = false;
                                        $matchedFilters = [];
                                        
                                        foreach ($desiredFilters as $filterType => $filters) {
                                            if (isset($item[$filterType])) {
                                                $itemValue = is_array($item[$filterType]) ? $item[$filterType] : [$item[$filterType]];
                                                foreach ($filters as $filter) {
                                                    if (in_array($filter, $itemValue)) {
                                                        $matchesFilters = true;
                                                        $matchedFilters[$filterType] = $filter;
                                                    }
                                                }
                                            }
                                        }
                                    @endphp
                                    <div class="mb-2">
                                        @if (in_array($item['name'], $desiredFilters['nama_barang'] ?? []))
                                            <span class="text-success font-weight-bold">{{ $item['name'] }} ✓</span>
                                        @else
                                            <b>{{ $item['name'] }}</b>
                                        @endif
                                        <br>
                                        Berat: {{ $item['berat'] }}g
                                        <br>
                                        Harga: Rp {{ number_format($item['price'], 0, ',', '.') }}
                                        <br>
                                        ({{ $item['seller'] }})
                                        <br>
                                        
                                        @if ($matchesCategory)
                                            <span class="text-success font-weight-bold">Kategori: {{ $item['category'] }} ✓</span><br>
                                        @endif
                                        
                                        @foreach ($matchedFilters as $filterType => $filterValue)
                                            @php
                                                $filterLabel = ucwords(str_replace('_', ' ', $filterType));
                                            @endphp
                                            <span class="text-success font-weight-bold">{{ $filterLabel }}: {{ $filterValue }} ✓</span><br>
                                        @endforeach
                                    </div>
                                    <hr>
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