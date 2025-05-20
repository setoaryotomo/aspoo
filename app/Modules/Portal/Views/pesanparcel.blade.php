@extends('portal_layout.templates')
@section('content')
    <style>
        /* Add this to your style section */
#random-filter-button {
    background-color: #6c757d;
    border-color: #6c757d;
}

#random-filter-button:hover {
    background-color: #5a6268;
    border-color: #545b62;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}
        .barang-item {
            display: none;
        }

        .visible {
            display: block;
        }

        /* Base styles */
        :root {
            --primary-color: #3490dc;
            --success-color: #38c172;
            --danger-color: #e3342f;
            --dark-color: #343a40;
            --light-color: #f8f9fa;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --radius: 8px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f8fa;
        }

        .page-title {
            color: var(--dark-color);
            font-weight: 600;
            margin-bottom: 2rem;
            position: relative;
            padding-bottom: 10px;
        }

        .page-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: var(--primary-color);
        }

        /* Card styles */
        .card {
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 1.5rem;
            border: none;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            border-bottom: none;
            padding: 1rem 1.5rem;
            font-weight: 600;
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        /* Form elements */
        .form-control,
        .form-select {
            border-radius: var(--radius);
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 144, 220, 0.25);
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #4a5568;
        }

        /* Section styling */
        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--dark-color);
            text-align: center;
        }

        .section-card {
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        /* Button styling */
        .btn {
            border-radius: var(--radius);
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
        }

        .btn-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }

        .btn-primary:hover,
        .btn-success:hover,
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        /* Chip styling */
        .chip {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50px;
            margin: 0.25rem;
            font-size: 0.875rem;
            transition: all 0.3s;
        }

        .chip:hover {
            background-color: #2779bd;
        }

        .chip .close-icon {
            margin-left: 0.5rem;
            cursor: pointer;
            font-weight: bold;
            font-size: 1rem;
        }

        /* Filter section */
        .filter-section {
            margin-bottom: 2rem;
        }

        .filter-card {
            height: 100%;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }

        .category-option {
            margin: 0.5rem 0;
            display: flex;
            align-items: center;
        }

        .category-option label {
            margin-left: 0.5rem;
            cursor: pointer;
        }

        .category-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        /* Product card */
        .product-card {
            height: 100%;
        }

        .product-card .card-body {
            display: flex;
            flex-direction: column;
        }

        .product-info {
            flex-grow: 1;
        }

        .product-price {
            font-weight: bold;
            font-size: 1.25rem;
            color: var(--primary-color);
            margin: 0.5rem 0;
        }

        /* Recommendations */
        .recommendation-card {
            height: 100%;
            border: 2px solid transparent;
            transition: all 0.3s;
        }

        .recommendation-card.selected {
            border-color: var(--success-color);
        }

        .recommendation-details {
            padding: 0.5rem;
            background-color: #f8f9fa;
            border-radius: var(--radius);
            margin-bottom: 1rem;
        }

        .category-breakdown {
            border-left: 3px solid var(--primary-color);
            padding-left: 1rem;
            margin-bottom: 1rem;
        }

        .category-title {
            font-weight: 600;
        }

        .category-title.priority {
            color: var(--success-color);
        }

        .item-detail {
            padding: 0.5rem;
            background-color: #f8f9fa;
            border-radius: var(--radius);
            margin: 0.5rem 0;
        }

        /* Loading spinner */
        /* .spinner-border {
                            display: inline-block;
                            width: 1rem;
                            height: 1rem;
                            border: 0.2em solid currentColor;
                            border-right-color: transparent;
                            border-radius: 50%;
                            animation: spinner-border .75s linear infinite;
                        } */

        /* @keyframes spinner-border {
                            to {
                                transform: rotate(360deg);
                            }
                        } */

        /* Preloader */
        .preload-wrapper {
            position: relative;
        }

        .preload {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.9);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* .spinner {
                            width: 40px;
                            height: 40px;
                            border: 4px solid #f3f3f3;
                            border-top: 4px solid var(--primary-color);
                            border-radius: 50%;
                            animation: spin 1s linear infinite;
                        } */

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Responsive adjustments */
        @media (max-width: 767.98px) {
            .section-card {
                padding: 1rem;
            }

            .card-img-top {
                height: 150px;
            }

            .btn {
                padding: 0.5rem 1rem;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .section-title {
                font-size: 1.25rem;
            }

            .filter-section .card-body {
                max-height: 150px;
            }
        }
    </style>

    <body class="preload-wrapper">
        <div class="preload preload-container">
            <div class="preload-logo">
                <div class="spinner"></div>
            </div>
        </div>

        <div class="container py-5">
            <h1 class="page-title text-center">Pesan Parcel Sesuai Keinginanmu</h1>

            <div class="section-card">
                <form id="parcel-form" action="{{ route('parcel.store') }}" method="POST">
                    @csrf

                    <!-- Shipping Address Section -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h2 class="section-title">Alamat Pengiriman</h2>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="provinsi" class="form-label">Provinsi</label>
                            <select name="provinsi" id="provinsi" class="form-select" data-dependent="provinsi">
                                <option value="{{ $data->provinsiModel->id }}">
                                    {{ $data->provinsi ? $data->provinsiModel->name : 'Pilih Provinsi' }}
                                </option>
                                @foreach ($asal['provinsi'] as $provinsi)
                                    <option value="{{ $provinsi->id }}">{{ $provinsi->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="kota" class="form-label">Kota / Kabupaten</label>
                            <select name="kota" id="kota" class="form-select dynamic" data-dependent="kota">
                                <option value="{{ $data->kotaModel->id }}">
                                    {{ $data->kota ? $data->kotaModel->name : 'Pilih Kota / Kabupaten' }}
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <select name="kecamatan" id="kecamatan" class="form-select dynamic" data-dependent="kecamatan">
                                <option value="{{ $data->kecamatanModel->id }}">
                                    {{ $data->kecamatan ? $data->kecamatanModel->name : 'Pilih Kecamatan' }}
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="kelurahan" class="form-label">Kelurahan</label>
                            <select name="kelurahan" id="kelurahan" class="form-select dynamic" data-dependent="kelurahan">
                                <option value="{{ $data->kelurahanModel->id }}">
                                    {{ $data->kelurahan ? $data->kelurahanModel->name : 'Pilih Kelurahan' }}
                                </option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="alamat" class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control" id="alamat" rows="3" placeholder="Masukkan alamat lengkap pengiriman">{{ $data->alamat }}</textarea>

                            {{-- <input class="mt-3" type="text" id="location" placeholder="Enter a location">
                            <input class="mt-3" type="text" id="lat" placeholder="latitude">
                            <input class="mt-3" type="text" id="long" placeholder="longitude">
                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                            <script type="text/javascript" src="https://maps.gomaps.pro/maps/api/js?key=AlzaSyT4U4D7FruDUx-6EOb7UcmM8HzlbHTeyEr&libraries=places"></script>
                            <script>
                              $(document).ready(function(){
                                var autocomplete;
                                var id = 'location';
                                
                                autocomplete = new google.maps.places.Autocomplete(
                                  document.getElementById(id),
                                  {
                                    types: ['geocode'],
                                  }
                                )
                              
                                google.maps.event.addListener(autocomplete,'place_changed',function(){
                                    var place = autocomplete.getPlace();
                                    jQuery("#lat").val(place.geometry.location.lat());
                                    jQuery("#long").val(place.geometry.location.lng());
                                })
                              });
                            </script> --}}

                        </div>

                    </div>

                    <!-- Parcel Details Section -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h2 class="section-title">Detail Parcel</h2>
                        </div>

                        <div class="col-md-6 col-lg-3 mb-3">
                            <label for="desired-price" class="form-label">Harga yang Diinginkan (Rp)</label>
                            <input type="number" id="desired-price" name="harga" class="form-control"
                                placeholder="Masukkan harga" required>
                        </div>

                        <div class="col-md-6 col-lg-3 mb-3">
                            <label for="desired-weight" class="form-label">Berat yang Diinginkan (Gram)</label>
                            <input type="number" id="desired-weight" name="berat" class="form-control"
                                placeholder="Masukkan berat" required>
                        </div>

                        <div class="col-md-6 col-lg-3 mb-3">
                            <label for="total-items" class="form-label">Total Item (Opsional)</label>
                            <input type="number" id="total-items" name="total_items" class="form-control"
                                placeholder="Jumlah item dalam parcel">
                        </div>

                        <div class="col-md-6 col-lg-3 mb-3">
                            <label for="parcel-quantity" class="form-label">Jumlah Parcel (Opsional)</label>
                            <input type="number" id="parcel-quantity" name="parcel_quantity" class="form-control"
                                placeholder="Jumlah parcel" min="1" value="1">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tanggal" class="form-label">Tanggal Dibutuhkan</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                        </div>

                        <input type="text" name="barang" class="form-control" placeholder="Masukkan barang" required
                            style="display: none">
                        <input type="text" name="alamat" class="form-control" placeholder="Masukkan alamat" required
                            style="display: none">
                        <input type="hidden" name="user_id" value="{{ $auth->id }}">


                    </div>
                    <!-- Di dalam form Anda, sebelum tag penutup form -->
                    

                    @foreach ($parcel as $index => $parcel)
                        @if (!$parcel->parcel_children->isEmpty())
                            {{-- <div class="content-container" style="display: none"> --}}
                            <div class="content-container d-none" data-load-later>
                                @php
                                    $number = 1;
                                @endphp
                                {{-- <h2>Parcel {{ $index + 1 }}</h2> --}}
                                <p>Id Parcel : {{ $parcel->id }}</p>
                                <p>Review Pelayanan : {{ $parcel->review_pelayanan }}</p>
                                <p>{{ $parcel->created_at }}</p>
                                @foreach ($parcel->parcel_children as $child)
                                    <div class="product-details">
                                        <div class="product-name">nama barang : {{ $child->barang->nama_barang }}</div>
                                        <div class="product-review">review : {{ $parcel->review_komposisi }}</div>
                                        <div class="product-id">id barang : {{ $child->barang->id }}</div>
                                        <div class="product-kategori">kategori barang :
                                            {{ $child->barang->kategori_umum }}</div>
                                        <p>Harga: {{ $child->barang->harga_umum }}</p>
                                        <p>Berat: {{ $child->barang->berat }}</p>
                                    </div>
                                @endforeach
                                {{-- <a href="{{ url('p/status/') }}" class="caption-link">Lihat Status Transaksi</a> --}}
                            </div>
                            <br>
                        @endif
                    @endforeach


                    <!-- Filter Categories Section -->
                    <div class="filter-section">
                        <div class="row mb-4">
                            <div class="col-12">
                                <h2 class="section-title">Filter Barang</h2>
                            </div>

                            @php
                                // Hindari multiple pluck() calls
                                $filteredBarang = $card['barang']->filter(function ($item) {
                                    return $item->berat > 0 &&
                                        !empty($item->kategori_umum) &&
                                        !empty($item->bahan_dasar) &&
                                        !empty($item->basah_kering) &&
                                        !empty($item->produsen) &&
                                        !empty($item->rasa);
                                        // !empty($item->nama_barang);
                                });

                                $uniqueCategories = $filteredBarang->pluck('kategori_umum')->filter()->unique()->sort();
                                $uniqueBahan = $filteredBarang->pluck('bahan_dasar')->filter()->unique()->sort();
                                $uniqueBasahKering = $filteredBarang->pluck('basah_kering')->filter()->unique()->sort();
                                $uniqueRasa = $filteredBarang->pluck('rasa')->filter()->unique()->sort();
                                $uniqueProdusen = $filteredBarang->pluck('produsen')->filter()->unique()->sort();
                                $uniqueNamaProduk = $filteredBarang->pluck('nama_barang')->filter()->unique()->sort();
                            @endphp

                            <!-- Left Column - Desired Filters -->
                            <div class="col-md-6">
                                <!-- Desired Categories -->
                                <div class="col-12 mb-3">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            <h6 class="mb-0 text-white text-center">Kategori yang Diinginkan</h6>
                                        </div>
                                        <div class="card-body" style="max-height: 150px; overflow-y: auto;">
                                            <div id="desired-categories" class="category-container">
                                                @foreach($uniqueData['categories'] as $kategori)
                                                    <div class="me-3 ml-3 category-option">
                                                        <input class="form-check-input desired-category" type="checkbox"
                                                            value="{{ $kategori }}"
                                                            id="desired-{{ Str::slug($kategori) }}"
                                                            data-type="kategori_umum">
                                                        <label class="form-check-label"
                                                            for="desired-{{ Str::slug($kategori) }}">
                                                            {{ $kategori }} ({{ $counts['categories'][$kategori] ?? 0 }})
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Desired Bahan Dasar -->
                                <div class="col-12 mb-3">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            <h6 class="mb-0 text-white text-center">Bahan Dasar yang Diinginkan</h6>
                                        </div>
                                        <div class="card-body" style="max-height: 150px; overflow-y: auto;">
                                            <div id="desired-bahan" class="category-container">
                                                @foreach($uniqueData['bahan'] as $bahan)
                                                    <div class="me-3 ml-3 category-option">
                                                        <input class="form-check-input desired-filter" type="checkbox"
                                                            value="{{ $bahan }}"
                                                            id="desired-bahan-{{ Str::slug($bahan) }}"
                                                            data-type="bahan_dasar">
                                                        <label class="form-check-label"
                                                            for="desired-bahan-{{ Str::slug($bahan) }}">
                                                            {{ $bahan }} ({{ $counts['bahan'][$bahan] ?? 0 }})
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Desired Basah/Kering -->
                                <div class="col-12 mb-3">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            <h6 class="mb-0 text-white text-center">Basah/Kering yang Diinginkan</h6>
                                        </div>
                                        <div class="card-body" style="max-height: 150px; overflow-y: auto;">
                                            <div id="desired-basah-kering" class="category-container">
                                               
                                                @foreach($uniqueData['basah_kering'] as $basahKering)
                                                    <div class="me-3 ml-3 category-option">
                                                        <input class="form-check-input desired-filter" type="checkbox"
                                                            value="{{ $basahKering }}"
                                                            id="desired-basah-kering-{{ Str::slug($basahKering) }}"
                                                            data-type="basah_kering">
                                                        <label class="form-check-label"
                                                            for="desired-basah-kering-{{ Str::slug($basahKering) }}">
                                                            {{ $basahKering }} ({{ $counts['basah_kering'][$basahKering] ?? 0 }})
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Desired Rasa -->
                                <div class="col-12 mb-3">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            <h6 class="mb-0 text-white text-center">Rasa yang Diinginkan</h6>
                                        </div>
                                        <div class="card-body" style="max-height: 150px; overflow-y: auto;">
                                            <div id="desired-rasa" class="category-container">
                                                @foreach($uniqueData['rasa'] as $rasa)
                                                    <div class="me-3 ml-3 category-option">
                                                        <input class="form-check-input desired-filter" type="checkbox"
                                                            value="{{ $rasa }}"
                                                            id="desired-rasa-{{ Str::slug($rasa) }}" data-type="rasa">
                                                        <label class="form-check-label"
                                                            for="desired-rasa-{{ Str::slug($rasa) }}">
                                                            {{ $rasa }} ({{ $counts['rasa'][$rasa] ?? 0 }})
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Desired Produsen -->
                                <div class="col-12 mb-3">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            <h6 class="mb-0 text-white text-center">Produsen yang Diinginkan</h6>
                                        </div>
                                        <div class="card-body" style="max-height: 150px; overflow-y: auto;">
                                            <div id="desired-produsen" class="category-container">
                                                @foreach($uniqueData['produsen'] as $produsen)
                                                    <div class="me-3 ml-3 category-option">
                                                        <input class="form-check-input desired-filter" type="checkbox"
                                                            value="{{ $produsen }}"
                                                            id="desired-produsen-{{ Str::slug($produsen) }}"
                                                            data-type="produsen">
                                                        <label class="form-check-label"
                                                            for="desired-produsen-{{ Str::slug($produsen) }}">
                                                            {{ $produsen }} ({{ $counts['produsen'][$produsen] ?? 0 }})
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Desired Nama Produk -->
                                <div class="col-12 mb-3">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            <h6 class="mb-0 text-white text-center">Nama Produk yang Diinginkan</h6>
                                        </div>
                                        <div class="card-body" style="max-height: 150px; overflow-y: auto;">
                                            <div id="desired-nama-produk" class="category-container">
                                                @foreach($uniqueData['nama_produk'] as $namaProduk)
                                                    <div class="me-3 ml-3 category-option">
                                                        <input class="form-check-input desired-filter" type="checkbox"
                                                            value="{{ $namaProduk }}"
                                                            id="desired-nama-produk-{{ Str::slug($namaProduk) }}"
                                                            data-type="nama_barang">
                                                        <label class="form-check-label"
                                                            for="desired-nama-produk-{{ Str::slug($namaProduk) }}">
                                                            {{ $namaProduk }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Unwanted Filters -->
                            <div class="col-md-6">
                                <!-- Unwanted Categories -->
                                <div class="col-12 mb-3">
                                    <div class="card filter-card">
                                        <div class="card-header bg-danger text-white">
                                            <h6 class="mb-0 text-white text-center">Kategori yang Tidak Diinginkan</h6>
                                        </div>
                                        <div class="card-body" style="max-height: 150px; overflow-y: auto;">
                                            <div id="unwanted-categories" class="category-container">
                                                @foreach($uniqueData['categories'] as $kategori)
                                                    <div class="me-3 ml-3 category-option">
                                                        <input class="form-check-input unwanted-filter" type="checkbox"
                                                            value="{{ $kategori }}"
                                                            id="unwanted-category-{{ Str::slug($kategori) }}"
                                                            data-type="kategori_umum">
                                                        <label class="form-check-label"
                                                            for="unwanted-category-{{ Str::slug($kategori) }}">
                                                            {{ $kategori }} ({{ $counts['categories'][$kategori] ?? 0 }})
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Unwanted Material -->
                                <div class="col-12 mb-3">
                                    <div class="card filter-card">
                                        <div class="card-header bg-danger text-white">
                                            <h6 class="mb-0 text-white text-center">Bahan Dasar yang Tidak Diinginkan</h6>
                                        </div>
                                        <div class="card-body" style="max-height: 150px; overflow-y: auto;">
                                            <div id="unwanted-bahan" class="category-container">
                                                @foreach($uniqueData['bahan'] as $bahan)
                                                    <div class="me-3 ml-3 category-option">
                                                        <input class="form-check-input unwanted-filter" type="checkbox"
                                                            value="{{ $bahan }}"
                                                            id="unwanted-bahan-{{ Str::slug($bahan) }}"
                                                            data-type="bahan_dasar">
                                                        <label class="form-check-label"
                                                            for="unwanted-bahan-{{ Str::slug($bahan) }}">
                                                            {{ $bahan }} ({{ $counts['bahan'][$bahan] ?? 0 }})
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Unwanted Wet/Dry -->
                                <div class="col-12 mb-3">
                                    <div class="card filter-card">
                                        <div class="card-header bg-danger text-white">
                                            <h6 class="mb-0 text-white text-center">Basah/Kering yang Tidak Diinginkan</h6>
                                        </div>
                                        <div class="card-body" style="max-height: 150px; overflow-y: auto;">
                                            <div id="unwanted-basah-kering" class="category-container">
                                                @foreach($uniqueData['basah_kering'] as $basahKering)
                                                    <div class="me-3 ml-3 category-option">
                                                        <input class="form-check-input unwanted-filter" type="checkbox"
                                                            value="{{ $basahKering }}"
                                                            id="unwanted-basah-kering-{{ Str::slug($basahKering) }}"
                                                            data-type="basah_kering">
                                                        <label class="form-check-label"
                                                            for="unwanted-basah-kering-{{ Str::slug($basahKering) }}">
                                                            {{ $basahKering }} ({{ $counts['basah_kering'][$basahKering] ?? 0 }})
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Unwanted Flavors -->
                                <div class="col-12 mb-3">
                                    <div class="card filter-card">
                                        <div class="card-header bg-danger text-white">
                                            <h6 class="mb-0 text-white text-center">Rasa yang Tidak Diinginkan</h6>
                                        </div>
                                        <div class="card-body" style="max-height: 150px; overflow-y: auto;">
                                            <div id="unwanted-rasa" class="category-container">
                                                @foreach($uniqueData['rasa'] as $rasa)
                                                    <div class="me-3 ml-3 category-option">
                                                        <input class="form-check-input unwanted-filter" type="checkbox"
                                                            value="{{ $rasa }}"
                                                            id="unwanted-rasa-{{ Str::slug($rasa) }}" data-type="rasa">
                                                        <label class="form-check-label"
                                                            for="unwanted-rasa-{{ Str::slug($rasa) }}">
                                                            {{ $rasa }} ({{ $counts['rasa'][$rasa] ?? 0 }})
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Unwanted Produsen -->
                                <div class="col-12 mb-3">
                                    <div class="card filter-card">
                                        <div class="card-header bg-danger text-white">
                                            <h6 class="mb-0 text-white text-center">Produsen yang Tidak Diinginkan</h6>
                                        </div>
                                        <div class="card-body" style="max-height: 150px; overflow-y: auto;">
                                            <div id="unwanted-produsen" class="category-container">
                                                @foreach($uniqueData['produsen'] as $produsen)
                                                    <div class="me-3 ml-3 category-option">
                                                        <input class="form-check-input unwanted-filter" type="checkbox"
                                                            value="{{ $produsen }}"
                                                            id="unwanted-produsen-{{ Str::slug($produsen) }}"
                                                            data-type="produsen">
                                                        <label class="form-check-label"
                                                            for="unwanted-produsen-{{ Str::slug($produsen) }}">
                                                            {{ $produsen }} ({{ $counts['produsen'][$produsen] ?? 0 }})
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Unwanted Nama Produk -->
                                <div class="col-12 mb-3">
                                    <div class="card filter-card">
                                        <div class="card-header bg-danger text-white">
                                            <h6 class="mb-0 text-white text-center">Nama Produk yang Tidak Diinginkan</h6>
                                        </div>
                                        <div class="card-body" style="max-height: 150px; overflow-y: auto;">
                                            <div id="unwanted-nama-produk" class="category-container">
                                                @foreach($uniqueData['nama_produk'] as $namaProduk)
                                                    <div class="me-3 ml-3 category-option">
                                                        <input class="form-check-input unwanted-filter" type="checkbox"
                                                            value="{{ $namaProduk }}"
                                                            id="unwanted-nama-produk-{{ Str::slug($namaProduk) }}"
                                                            data-type="nama_barang">
                                                        <label class="form-check-label"
                                                            for="unwanted-nama-produk-{{ Str::slug($namaProduk) }}">
                                                            {{ $namaProduk }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="selected-filters-display" class="mb-3 text-center" style="display: none;">
                            <p id="selected-filters-text" class="text-muted"></p>
                        </div>
                        <div class="text-center mb-5">
                            {{-- <button type="button" id="random-filter-button" class="btn btn-info btn-lg me-3">
                                <i class="fas fa-random me-2"></i>Random
                            </button> --}}
                            <button id="process-button" class="btn btn-primary btn-lg">
                                <i class="fas fa-magic me-2"></i>Proses
                            </button>
                        </div>
                    </div>

                    <!-- Recommendations Section -->
            <div class="row recommendations-container" id="barang-list">
                <!-- Recommendations will appear here -->
            </div>

                    <div class="text-center">
                        <button type="submit" id="save-recommendations" class="btn btn-primary btn-block mt-2 mb-4"
                            style="width: 100px;">PESAN</button>
                    </div>

                    <!-- Hidden buttons -->
                    <button type="submit" id="submit-parcel" class="btn btn-primary btn-block"
                        style="display: none">Pesan</button>
                    <button type="submit" id="save-recommendations" class="btn btn-success btn-lg w-100"
                        style="display: none">
                        <i class="fas fa-shopping-cart me-2"></i>Pesan Parcel
                    </button>
                </form>
            </div>

            

            <!-- Selected Items Table (hidden by default) -->
            <div class="section-card" style="display: none">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Barang</th>
                            <th>Berat</th>
                            <th>Harga</th>
                            <th>Penjual</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="selected-items"></tbody>
                    <tfoot>
                        <tr>
                            <td colspan="1" class="text-end"><strong>Total:</strong></td>
                            <td id="total-berat">0</td>
                            <td id="total-price">Rp. 0</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Products List (hidden by default) -->

    </body>

    <!-- Scripts -->
    <script src="{!! asset('js/bootstrap.min.js') !!}"></script>
    <script src="{!! asset('js/jquery.min.js') !!}"></script>
    <script src="{!! asset('js/swiper-bundle.min.js') !!}"></script>
    <script src="{!! asset('js/carousel.js') !!}"></script>
    <script src="{!! asset('js/bootstrap-select.min.js') !!}"></script>
    <script src="{!! asset('js/lazysize.min.js') !!}"></script>
    <script src="{!! asset('js/bootstrap-select.min.js') !!}"></script>
    <script src="{!! asset('js/count-down.js') !!}"></script>
    <script src="{!! asset('js/wow.min.js') !!}"></script>
    <script src="{!! asset('js/multiple-modal.js') !!}"></script>
    <script src="{!! asset('js/shop.js') !!}"></script>
    <script src="{!! asset('js/nouislider.min.js') !!}"></script>
    <script src="{!! asset('js/main.js') !!}"></script>
    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        //     document.querySelectorAll('.barang-item').forEach(item => {
        //         item.style.display = 'none'; // Sembunyikan semua barang
        //     });
        // });

        // document.getElementById('search-bar').addEventListener('input', function() {
        //     const keyword = this.value.toLowerCase();
        //     document.querySelectorAll('.barang-item').forEach(item => {
        //         const itemName = item.getAttribute('data-name').toLowerCase();
        //         item.style.display = itemName.includes(keyword) ? '' : 'none';


        //     });
        // });
        // Modified global variables

        async function getAvailableItems() {
            try {
                // Endpoint sesuai dengan route yang ada di Laravel
                const apiUrl = '/p/api/barang';
                console.log('Fetching items from:', apiUrl); // Debugging

                const response = await fetch(apiUrl);

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();
                console.log('API Response:', result); // Debugging

                // Validasi struktur response
                if (!result || !result.success || !Array.isArray(result.data)) {
                    console.error('Invalid API response structure:', result);
                    throw new Error('Invalid API response structure');
                }

                // Transformasi data ke format yang diharapkan
                return result.data.map(item => {
                    // Pastikan semua field memiliki nilai default jika null/undefined
                    return {
                        id: item.id,
                        name: item.nama_barang || 'Unknown',
                        price: parseFloat(item.harga_user) || 0,
                        berat: parseFloat(item.berat) || 0,
                        seller: item.user?.nama || 'Unknown',
                        sellerCity: item.user?.detail?.kotaModel?.name || 'Unknown',
                        thumbnail: item.thumbnail_readable || '',
                        category: item.kategori_umum || 'Unknown',
                        bahan_dasar: item.bahan_dasar || 'Unknown',
                        basah_kering: item.basah_kering || 'Unknown',
                        rasa: item.rasa || 'Unknown',
                        produsen: item.produsen || 'Unknown'
                    };
                });

            } catch (error) {
                console.error('Error in getAvailableItems:', error);
                // Return array kosong sebagai fallback
                return [];
            }
        }
        
        let selectedItems = [];
        let recommendedParcels = [];
        const MAX_RECOMMENDATIONS = 3;
        const MAX_COMBINATION_SIZE = 10;
        const PRICE_THRESHOLD = 0.1;
        const WEIGHT_THRESHOLD = 0.1;

        // Function to shuffle array randomly
        function shuffleArray(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
            return array;
        }

        // Function to get all filter selections 
        function getSelectedFilters() {
            // Get desired categories
            const desiredCategories = Array.from(document.querySelectorAll('#desired-categories input:checked')).map(cb =>
                cb.value);

            // Get desired filters (bahan_dasar, basah_kering, rasa, produsen, nama_barang)
            const desiredFilters = {
                bahan_dasar: Array.from(document.querySelectorAll('#desired-bahan input:checked')).map(cb => cb.value),
                basah_kering: Array.from(document.querySelectorAll('#desired-basah-kering input:checked')).map(cb => cb
                    .value),
                rasa: Array.from(document.querySelectorAll('#desired-rasa input:checked')).map(cb => cb.value),
                produsen: Array.from(document.querySelectorAll('#desired-produsen input:checked')).map(cb => cb.value),
                nama_barang: Array.from(document.querySelectorAll('#desired-nama-produk input:checked')).map(cb => cb
                    .value)
            };

            // Get all unwanted filters
            const unwantedFilters = {
                kategori_umum: Array.from(document.querySelectorAll('#unwanted-categories input:checked')).map(cb => cb
                    .value),
                bahan_dasar: Array.from(document.querySelectorAll('#unwanted-bahan input:checked')).map(cb => cb.value),
                basah_kering: Array.from(document.querySelectorAll('#unwanted-basah-kering input:checked')).map(cb => cb
                    .value),
                rasa: Array.from(document.querySelectorAll('#unwanted-rasa input:checked')).map(cb => cb.value),
                produsen: Array.from(document.querySelectorAll('#unwanted-produsen input:checked')).map(cb => cb.value),
                nama_barang: Array.from(document.querySelectorAll('#unwanted-nama-produk input:checked')).map(cb => cb
                    .value)
            };

            return {
                desiredCategories,
                desiredFilters,
                unwantedFilters
            };
        }

        function filterItems(items, desiredCategories, desiredFilters, unwantedFilters) {
    // Filter keluar SEMUA item dengan atribut yang tidak diinginkan terlebih dahulu
    let filteredItems = items.filter(item =>
        !unwantedFilters.kategori_umum.includes(item.category) &&
        !unwantedFilters.bahan_dasar.includes(item.bahan_dasar) &&
        !unwantedFilters.basah_kering.includes(item.basah_kering) &&
        !unwantedFilters.rasa.includes(item.rasa) &&
        !unwantedFilters.produsen.includes(item.produsen) &&
        !unwantedFilters.nama_barang.includes(item.name)
    );

    // Buat daftar item yang "harus disertakan" berdasarkan filter produsen dan nama produk
    // tapi hanya dari item yang sudah lolos filter "tidak diinginkan"
    let mustIncludeItems = new Set();
    let mustIncludeItemObjects = [];
    
    // Tandai semua item yang cocok dengan nama_barang atau produsen yang dipilih
    // if (desiredFilters.nama_barang.length > 0 || desiredFilters.produsen.length > 0) {
    //     filteredItems.forEach(item => {
    //         if (desiredFilters.nama_barang.includes(item.name) || 
    //             desiredFilters.produsen.includes(item.produsen)) {
    //             mustIncludeItems.add(item.id);
    //             mustIncludeItemObjects.push(item);
    //         }
    //     });
    // }
    
    // Jika kita memiliki item yang "harus disertakan" dari nama produk atau produsen
    if (mustIncludeItems.size > 0) {
        // Pisahkan item yang "harus disertakan" dan item lainnya
        let otherItems = filteredItems.filter(item => !mustIncludeItems.has(item.id));
        
        // Terapkan filter tambahan untuk item lain (bahan_dasar, basah_kering, rasa)
        // tapi hanya jika filter tersebut dipilih
        if (desiredFilters.bahan_dasar.length > 0) {
            otherItems = otherItems.filter(item => 
                desiredFilters.bahan_dasar.includes(item.bahan_dasar)
            );
        }
        if (desiredFilters.produsen.length > 0) {
            otherItems = otherItems.filter(item => 
                desiredFilters.produsen.includes(item.produsen)
            );
        }
        if (desiredFilters.nama_barang.length > 0) {
            otherItems = otherItems.filter(item => 
                desiredFilters.nama_barang.includes(item.nama_barang)
            );
        }
        
        if (desiredFilters.basah_kering.length > 0) {
            otherItems = otherItems.filter(item => 
                desiredFilters.basah_kering.includes(item.basah_kering)
            );
        }
        
        if (desiredFilters.rasa.length > 0) {
            otherItems = otherItems.filter(item => 
                desiredFilters.rasa.includes(item.rasa)
            );
        }
        
        // Gabungkan item yang harus disertakan dengan item lainnya
        filteredItems = [...mustIncludeItemObjects, ...otherItems];
    } else {
        // Jika tidak ada item "harus disertakan", terapkan filter normal untuk semua filter
        let desiredFilteredItems = filteredItems;
        
        // Filter untuk atribut yang diinginkan (sama seperti sebelumnya)
        if (desiredFilters.bahan_dasar.length > 0) {
            desiredFilteredItems = desiredFilteredItems.filter(item =>
                desiredFilters.bahan_dasar.includes(item.bahan_dasar)
            );
        }

        if (desiredFilters.basah_kering.length > 0) {
            desiredFilteredItems = desiredFilteredItems.filter(item =>
                desiredFilters.basah_kering.includes(item.basah_kering)
            );
        }

        if (desiredFilters.rasa.length > 0) {
            desiredFilteredItems = desiredFilteredItems.filter(item =>
                desiredFilters.rasa.includes(item.rasa)
            );
        }
        if (desiredFilters.produsen.length > 0) {
            desiredFilteredItems = desiredFilteredItems.filter(item =>
                desiredFilters.produsen.includes(item.produsen)
            );
        }
        if (desiredFilters.nama_barang.length > 0) {
            desiredFilteredItems = desiredFilteredItems.filter(item =>
                desiredFilters.nama_barang.includes(item.nama_barang)
            );
        }

        // PENTING: Kita tidak menggunakan produsen dan nama_barang di sini
        // karena sudah ditangani di atas
        
        // Jika ada filter yang dipilih dan kita mendapatkan hasil, gunakan itu
        // Jika tidak, gunakan item yang difilter sebelumnya
        if ((desiredFilters.bahan_dasar.length > 0 ||
                desiredFilters.basah_kering.length > 0 ||
                desiredFilters.produsen.length > 0 ||
                desiredFilters.nama_barang.length > 0 ||
                desiredFilters.rasa.length > 0) &&
            desiredFilteredItems.length > 0) {
            filteredItems = desiredFilteredItems;
        }
    }

    // Tambahkan logika prioritas kategori seperti sebelumnya
    if (desiredCategories.length > 0) {
        const priorityItems = filteredItems.filter(item => desiredCategories.includes(item.category));
        const regularItems = filteredItems.filter(item => !desiredCategories.includes(item.category));

        priorityItems.forEach(item => item.isPriority = true);
        regularItems.forEach(item => item.isPriority = false);

        filteredItems = [...priorityItems, ...regularItems];
    }

    return filteredItems;
}

        // Function to prevent selection of the same item in both desired and unwanted lists
        document.addEventListener('DOMContentLoaded', function() {
            // Add event listeners to all desired checkboxes
            document.querySelectorAll('.desired-category, .desired-filter').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        // Get the data type and value
                        const type = this.getAttribute('data-type');
                        const value = this.value;

                        // Find the corresponding unwanted checkbox and uncheck it
                        const unwantedCheckbox = document.querySelector(
                            `.unwanted-filter[data-type="${type}"][value="${value}"]`);
                        if (unwantedCheckbox) {
                            unwantedCheckbox.checked = false;
                        }
                    }
                });
            });

            // Add event listeners to all unwanted checkboxes
            document.querySelectorAll('.unwanted-filter').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        // Get the data type and value
                        const type = this.getAttribute('data-type');
                        const value = this.value;

                        // Find the corresponding desired checkbox and uncheck it
                        let desiredSelector = '';
                        if (type === 'kategori_umum') {
                            desiredSelector = `.desired-category[value="${value}"]`;
                        } else {
                            desiredSelector =
                                `.desired-filter[data-type="${type}"][value="${value}"]`;
                        }

                        const desiredCheckbox = document.querySelector(desiredSelector);
                        if (desiredCheckbox) {
                            desiredCheckbox.checked = false;
                        }
                    }
                });
            });

            // Add search boxes for each filter category
            const filterSections = [
                '#desired-categories', '#desired-bahan', '#desired-basah-kering', '#desired-rasa',
                '#desired-produsen', '#desired-nama-produk', '#unwanted-categories', '#unwanted-bahan',
                '#unwanted-basah-kering', '#unwanted-rasa', '#unwanted-produsen', '#unwanted-nama-produk'
            ];

            filterSections.forEach(sectionId => {
                const section = document.querySelector(sectionId);
                if (section) {
                    const parentCard = section.closest('.card-body');
                    const searchBox = document.createElement('input');
                    searchBox.type = 'text';
                    searchBox.placeholder = 'Cari...';
                    searchBox.className = 'form-control form-control-sm mb-2 filter-search';
                    searchBox.addEventListener('input', function() {
                        const searchValue = this.value.toLowerCase();
                        section.querySelectorAll('.category-option').forEach(option => {
                            const label = option.querySelector('label').textContent
                                .toLowerCase();
                            if (label.includes(searchValue)) {
                                option.style.display = '';
                            } else {
                                option.style.display = 'none';
                            }
                        });
                    });

                    // Insert search box before the category-container
                    parentCard.insertBefore(searchBox, section);
                }
            });
        });

        // Function to find similar past parcels based on user's desired categories
        function findSimilarPastParcels(desiredCategories) {
            // Get all past parcels from the DOM
            const pastParcels = [];

            // Loop through all parcel containers in the DOM
            document.querySelectorAll('.content-container').forEach(parcelContainer => {
                // Extract parcel ID
                const parcelIdText = parcelContainer.querySelector('p:nth-child(1)').textContent;
                const parcelId = parcelIdText.replace('Id Parcel : ', '').trim();

                // Extract review ratings
                const reviewPelayananText = parcelContainer.querySelector('p:nth-child(2)').textContent;
                const reviewPelayanan = parseInt(reviewPelayananText.replace('Review Pelayanan : ', '').trim());

                // Find the review_komposisi - select the first one which should apply to all items
                const reviewKomposisiElement = parcelContainer.querySelector('.product-review');
                const reviewKomposisi = reviewKomposisiElement ?
                    parseInt(reviewKomposisiElement.textContent.replace('review : ', '').trim()) : 0;

                // Extract items and their categories
                const items = [];
                const categories = new Set();

                parcelContainer.querySelectorAll('.product-details').forEach(productDetail => {
                    const nameText = productDetail.querySelector('.product-name').textContent;
                    const name = nameText.replace('nama barang : ', '').trim();

                    const categoryText = productDetail.querySelector('.product-kategori').textContent;
                    const category = categoryText.replace('kategori barang : ', '').trim().toLowerCase();

                    // Extract price and weight
                    const priceText = productDetail.querySelector('p:nth-child(5)').textContent;
                    const price = parseFloat(priceText.replace('Harga: ', '').trim());

                    const weightText = productDetail.querySelector('p:nth-child(6)').textContent;
                    const weight = parseFloat(weightText.replace('Berat: ', '').trim());

                    // Add item to the list
                    items.push({
                        name: name,
                        category: category,
                        price: price,
                        berat: weight
                    });

                    // Add category to the set
                    categories.add(category);
                });

                // Add the parcel data
                pastParcels.push({
                    id: parcelId,
                    reviewPelayanan: reviewPelayanan,
                    reviewKomposisi: reviewKomposisi,
                    items: items,
                    categories: Array.from(categories)
                });
            });

            // Filter parcels by minimum review score (4 or higher)
            const highlyRatedParcels = pastParcels.filter(parcel =>
                parcel.reviewPelayanan >= 4 && parcel.reviewKomposisi >= 4);

            // Calculate similarity score for each parcel
            const similarParcels = highlyRatedParcels.map(parcel => {
                // Count how many of the user's desired categories are in this parcel
                const matchingCategories = desiredCategories.filter(category =>
                    parcel.categories.includes(category.toLowerCase()));

                // Calculate similarity score (percentage of desired categories that match)
                const similarityScore = desiredCategories.length > 0 ?
                    matchingCategories.length / desiredCategories.length : 0;

                return {
                    ...parcel,
                    similarityScore: similarityScore,
                    matchingCategories: matchingCategories
                };
            });

            // Sort by similarity score (highest first)
            return similarParcels.sort((a, b) => b.similarityScore - a.similarityScore);
        }

        // This function will modify generateBalancedCombinations to enforce filter inclusion
function generateBalancedCombinations(items, maxPrice, maxWeight, desiredCategories, desiredFilters,
    unwantedFilters, desiredTotalItems) {
    // Extract shipping location from the form
    const shippingLocation = JSON.parse(document.querySelector('input[name="alamat"]').value);
    const shippingCity = shippingLocation.kota.name.toLowerCase().trim();

    // Separate items into local and non-local sellers
    const localItems = items.filter(item =>
        item.seller.toLowerCase().includes(shippingCity)
    );
    const nonLocalItems = items.filter(item =>
        !item.seller.toLowerCase().includes(shippingCity)
    );

    // Prioritize local items
    const allItems = [...localItems, ...nonLocalItems];

    // Apply filtering with enhanced filter function
    const filteredItems = filterItems(allItems, desiredCategories, desiredFilters, unwantedFilters);

    // Group items by category for better distribution
    const categoriesMap = {};
    filteredItems.forEach(item => {
        if (!categoriesMap[item.category]) {
            categoriesMap[item.category] = [];
        }
        categoriesMap[item.category].push(item);
    });

    // NEW: Group items by filter criteria for mandatory inclusion
    const filterMaps = {
        bahan_dasar: {},
        basah_kering: {},
        rasa: {},
        produsen: {},
        nama_barang: {}
    };
    
    // Populate filter maps with available items
    filteredItems.forEach(item => {
        // For each filter type, add this item to its respective value's array
        ['bahan_dasar', 'basah_kering', 'rasa', 'produsen'].forEach(filterType => {
            const value = item[filterType];
            if (value) {
                if (!filterMaps[filterType][value]) {
                    filterMaps[filterType][value] = [];
                }
                filterMaps[filterType][value].push(item);
            }
        });
        
        // Handle nama_barang separately as it's referenced as 'name' in item
        if (item.name) {
            if (!filterMaps.nama_barang[item.name]) {
                filterMaps.nama_barang[item.name] = [];
            }
            filterMaps.nama_barang[item.name].push(item);
        }
    });

    let combinations = [];

    // Try to generate combinations
    for (let attempt = 0; attempt < 30 && combinations.length < MAX_RECOMMENDATIONS; attempt++) {
        let combination = {
            items: [],
            totalPrice: 0,
            totalWeight: 0,
            isLocalSeller: false,
            categoryCounts: {},
            priorityCount: 0
        };

        // STEP 1: First include at least one item from each desired category if possible
        if (desiredCategories.length > 0) {
            for (let category of desiredCategories) {
                if (categoriesMap[category] && categoriesMap[category].length > 0) {
                    // Shuffle items in this category and try to add one
                    const categoryItems = shuffleArray([...categoriesMap[category]]);

                    for (let item of categoryItems) {
                        // Skip if this item is already in the combination
                        if (combination.items.some(selected => selected.id === item.id)) {
                            continue;
                        }
                        
                        if (combination.totalPrice + item.price <= maxPrice &&
                            combination.totalWeight + item.berat <= maxWeight) {

                            combination.items.push(item);
                            combination.totalPrice += item.price;
                            combination.totalWeight += item.berat;
                            combination.priorityCount++;

                            // Track category count
                            combination.categoryCounts[item.category] =
                                (combination.categoryCounts[item.category] || 0) + 1;

                            // Check if this is a local seller
                            if (item.seller.toLowerCase().includes(shippingCity)) {
                                combination.isLocalSeller = true;
                            }

                            break;
                        }
                    }
                }
            }
        }

        // STEP 2 (NEW): Include at least one item from each selected filter type
        const filterTypes = ['bahan_dasar', 'basah_kering', 'rasa', 'produsen', 'nama_barang'];
        
        for (const filterType of filterTypes) {
            // Skip if no filters of this type are selected
            if (!desiredFilters[filterType] || desiredFilters[filterType].length === 0) {
                continue;
            }
            
            // For each desired filter value of this type
            for (const filterValue of desiredFilters[filterType]) {
                // Check if we already have an item with this filter value
                const alreadyHasFilterValue = combination.items.some(item => {
                    const itemValue = filterType === 'nama_barang' ? item.name : item[filterType];
                    return itemValue === filterValue;
                });
                
                // If we already have an item with this filter value, skip to next
                if (alreadyHasFilterValue) {
                    continue;
                }
                
                // Get items matching this filter value
                const matchingItems = filterMaps[filterType][filterValue] || [];
                
                if (matchingItems.length > 0) {
                    // Shuffle matching items
                    const shuffledItems = shuffleArray([...matchingItems]);
                    
                    // Try to add one matching item
                    for (const item of shuffledItems) {
                        // Skip if already in combination
                        if (combination.items.some(selected => selected.id === item.id)) {
                            continue;
                        }
                        
                        // Check if adding this item would exceed price or weight
                        if (combination.totalPrice + item.price <= maxPrice &&
                            combination.totalWeight + item.berat <= maxWeight) {
                            
                            // Add the item
                            combination.items.push(item);
                            combination.totalPrice += item.price;
                            combination.totalWeight += item.berat;
                            
                            // Update category counts
                            combination.categoryCounts[item.category] =
                                (combination.categoryCounts[item.category] || 0) + 1;
                            
                            // Update priority count if needed
                            if (desiredCategories.includes(item.category)) {
                                combination.priorityCount++;
                            }
                            
                            // Update local seller flag if needed
                            if (item.seller.toLowerCase().includes(shippingCity)) {
                                combination.isLocalSeller = true;
                            }
                            
                            break;
                        }
                    }
                }
            }
        }

        // STEP 3: Add other items to fill the parcel, ensuring variety
        // Create a flattened array of all available remaining items
        let remainingItems = [...filteredItems];
        // Remove items already in the combination
        remainingItems = remainingItems.filter(item =>
            !combination.items.some(selected => selected.id === item.id)
        );
        // Shuffle remaining items
        remainingItems = shuffleArray(remainingItems);

        // Function to score an item for addition (lower is better)
        function scoreItemForAddition(item) {
            const categoryCount = combination.categoryCounts[item.category] || 0;
            const isPriorityCategory = desiredCategories.includes(item.category);

            // Base score is the current count for this category
            let score = categoryCount;

            // Reduce score (increase priority) for desired categories
            if (isPriorityCategory) {
                score -= 1;
            }

            // Boost score for preferred filter attributes
            if (desiredFilters.bahan_dasar.includes(item.bahan_dasar)) {
                score -= 0.5;
            }
            if (desiredFilters.basah_kering.includes(item.basah_kering)) {
                score -= 0.5;
            }
            if (desiredFilters.rasa.includes(item.rasa)) {
                score -= 0.5;
            }
            if (desiredFilters.produsen.includes(item.produsen)) {
                score -= 1;
            }
            if (desiredFilters.nama_barang.includes(item.name)) {
                score -= 1.5;
            }

            // Boost score for local sellers
            if (item.seller.toLowerCase().includes(shippingCity)) {
                score -= 0.5;
            }

            return score;
        }

        // Keep adding items until we reach the desired count or can't add more
        while ((!desiredTotalItems || combination.items.length < desiredTotalItems) &&
            remainingItems.length > 0) {

            // Sort items by score (prioritizing variety and desired categories)
            remainingItems.sort((a, b) => scoreItemForAddition(a) - scoreItemForAddition(b));

            let added = false;
            for (let i = 0; i < Math.min(5, remainingItems.length); i++) {
                const item = remainingItems[i];

                if (combination.totalPrice + item.price <= maxPrice &&
                    combination.totalWeight + item.berat <= maxWeight) {

                    combination.items.push(item);
                    combination.totalPrice += item.price;
                    combination.totalWeight += item.berat;

                    // Update category counts
                    combination.categoryCounts[item.category] =
                        (combination.categoryCounts[item.category] || 0) + 1;

                    // Update priority count if needed
                    if (desiredCategories.includes(item.category)) {
                        combination.priorityCount++;
                    }

                    // Update local seller flag if needed
                    if (item.seller.toLowerCase().includes(shippingCity)) {
                        combination.isLocalSeller = true;
                    }

                    // Remove this item from remaining items
                    remainingItems = remainingItems.filter(remaining => remaining.id !== item.id);

                    added = true;
                    break;
                }
            }

            // If no items could be added, break the loop
            if (!added) break;
        }

        // NEW: Verify that the combination includes at least one item for each selected filter
        const hasAllRequiredFilters = validateCombinationFilters(combination, desiredFilters);

        // Calculate score for this combination
        combination.score = calculateCombinationScore(
            combination,
            desiredCategories,
            desiredFilters,
            maxPrice,
            maxWeight,
            desiredTotalItems
        );

        // Add a bonus for local seller combinations
        if (combination.isLocalSeller) {
            combination.score *= 1.2; // 20% score boost to local seller combinations
        }

        // Validate combination
        const isValidCombination =
            hasAllRequiredFilters && // NEW: Must include all required filters
            (!desiredTotalItems || combination.items.length >= Math.max(desiredTotalItems - 1, 1)) &&
            combination.totalPrice <= maxPrice &&
            combination.totalWeight <= maxWeight &&
            combination.items.length >= Math.min(3, filteredItems.length); // At least 3 items if possible

        if (isValidCombination) {
            combinations.push(combination);
        }
    }

    // If no valid combinations found, try with more relaxed constraints
    if (combinations.length === 0) {
        return generateRelaxedCombinations(
            allItems,
            maxPrice * 1.1,
            maxWeight * 1.1,
            desiredCategories,
            desiredFilters,
            unwantedFilters,
            desiredTotalItems
        );
    }

    return combinations
        .sort((a, b) => b.score - a.score)
        .slice(0, MAX_RECOMMENDATIONS);
}

// NEW FUNCTION: Validate that combination includes at least one item from each selected filter
function validateCombinationFilters(combination, desiredFilters) {
    // Check each filter type
    for (const filterType of ['bahan_dasar', 'basah_kering', 'rasa', 'produsen', 'nama_barang']) {
        // Skip if no filters of this type are selected
        if (!desiredFilters[filterType] || desiredFilters[filterType].length === 0) {
            continue;
        }
        
        // For each desired filter value of this type
        for (const filterValue of desiredFilters[filterType]) {
            // Check if we have at least one item with this filter value
            const hasFilterValue = combination.items.some(item => {
                const itemValue = filterType === 'nama_barang' ? item.name : item[filterType];
                return itemValue === filterValue;
            });
            
            // If missing any required filter value, return false
            if (!hasFilterValue) {
                return false;
            }
        }
    }
    
    // All required filters are present
    return true;
}

        // Also update the relaxed combination function to respect filter requirements
function generateRelaxedCombinations(items, maxPrice, maxWeight, desiredCategories, desiredFilters, unwantedFilters,
    desiredTotalItems) {
    // Apply filtering with more relaxed conditions
    const filteredItems = items.filter(item =>
        // Remove only items with unwanted attributes
        !unwantedFilters.kategori_umum.includes(item.category) &&
        !unwantedFilters.bahan_dasar.includes(item.bahan_dasar) &&
        !unwantedFilters.basah_kering.includes(item.basah_kering) &&
        !unwantedFilters.rasa.includes(item.rasa) &&
        !unwantedFilters.produsen.includes(item.produsen) &&
        !unwantedFilters.nama_barang.includes(item.name)
    );

    // Extract shipping location from the form for local seller prioritization
    const shippingLocation = JSON.parse(document.querySelector('input[name="alamat"]').value);
    const shippingCity = shippingLocation.kota.name.toLowerCase().trim();

    // NEW: Group items by filter criteria for mandatory inclusion
    const filterMaps = {
        bahan_dasar: {},
        basah_kering: {},
        rasa: {},
        produsen: {},
        nama_barang: {}
    };
    
    // Populate filter maps with available items
    filteredItems.forEach(item => {
        // For each filter type, add this item to its respective value's array
        ['bahan_dasar', 'basah_kering', 'rasa', 'produsen'].forEach(filterType => {
            const value = item[filterType];
            if (value) {
                if (!filterMaps[filterType][value]) {
                    filterMaps[filterType][value] = [];
                }
                filterMaps[filterType][value].push(item);
            }
        });
        
        // Handle nama_barang separately
        if (item.name) {
            if (!filterMaps.nama_barang[item.name]) {
                filterMaps.nama_barang[item.name] = [];
            }
            filterMaps.nama_barang[item.name].push(item);
        }
    });

    let combinations = [];

    for (let attempt = 0; attempt < 20 && combinations.length < MAX_RECOMMENDATIONS; attempt++) {
        let combination = {
            items: [],
            totalPrice: 0,
            totalWeight: 0,
            categoryCounts: {},
            isLocalSeller: false,
            priorityCount: 0
        };

        // NEW STEP: First include at least one item from each selected filter type
        const filterTypes = ['bahan_dasar', 'basah_kering', 'rasa', 'produsen', 'nama_barang'];
        
        for (const filterType of filterTypes) {
            // Skip if no filters of this type are selected
            if (!desiredFilters[filterType] || desiredFilters[filterType].length === 0) {
                continue;
            }
            
            // For each desired filter value of this type
            for (const filterValue of desiredFilters[filterType]) {
                // Get items matching this filter value
                const matchingItems = filterMaps[filterType][filterValue] || [];
                
                if (matchingItems.length > 0) {
                    // Shuffle matching items
                    const shuffledItems = shuffleArray([...matchingItems]);
                    
                    // Try to add one matching item
                    for (const item of shuffledItems) {
                        // Skip if already in combination
                        if (combination.items.some(selected => selected.id === item.id)) {
                            continue;
                        }
                        
                        // Check if adding this item would exceed price or weight
                        if (combination.totalPrice + item.price <= maxPrice &&
                            combination.totalWeight + item.berat <= maxWeight) {
                            
                            // Add the item
                            combination.items.push(item);
                            combination.totalPrice += item.price;
                            combination.totalWeight += item.berat;
                            
                            // Update category counts
                            combination.categoryCounts[item.category] =
                                (combination.categoryCounts[item.category] || 0) + 1;
                            
                            // Update priority count if needed
                            if (desiredCategories.includes(item.category)) {
                                combination.priorityCount++;
                            }
                            
                            // Update local seller flag if needed
                            if (item.seller.toLowerCase().includes(shippingCity)) {
                                combination.isLocalSeller = true;
                            }
                            
                            break;
                        }
                    }
                }
            }
        }

        // After adding mandatory items, add other items
        // Shuffle items
        const remainingItems = shuffleArray([...filteredItems]).filter(item => 
            !combination.items.some(selected => selected.id === item.id)
        );

        // Add items until constraints are met
        for (let item of remainingItems) {
            if (combination.totalPrice + item.price <= maxPrice &&
                combination.totalWeight + item.berat <= maxWeight &&
                !combination.items.some(selected => selected.id === item.id)) {

                combination.items.push(item);
                combination.totalPrice += item.price;
                combination.totalWeight += item.berat;

                // Track category count
                combination.categoryCounts[item.category] =
                    (combination.categoryCounts[item.category] || 0) + 1;

                // Track priority categories
                if (desiredCategories.includes(item.category)) {
                    combination.priorityCount++;
                }

                // Update local seller flag if needed
                if (item.seller.toLowerCase().includes(shippingCity)) {
                    combination.isLocalSeller = true;
                }

                // If we've reached desired count, stop adding
                if (desiredTotalItems && combination.items.length >= desiredTotalItems) {
                    break;
                }
            }
        }

        // NEW: Verify that the combination includes at least one item for each selected filter
        const hasAllRequiredFilters = validateCombinationFilters(combination, desiredFilters);

        // Add the combination if it has at least 2 items and contains all required filters
        if (combination.items.length >= 2 && hasAllRequiredFilters) {
            // Calculate score with enhanced scoring that considers desired filters
            combination.score = calculateRelaxedCombinationScore(
                combination,
                desiredCategories,
                desiredFilters,
                maxPrice,
                maxWeight,
                desiredTotalItems
            );

            // Add bonus for local seller combinations
            if (combination.isLocalSeller) {
                combination.score *= 1.1; // 10% score boost to local seller combinations
            }

            combinations.push(combination);
        }
    }

    return combinations
        .sort((a, b) => b.score - a.score)
        .slice(0, MAX_RECOMMENDATIONS);
}
        // Updated relaxed combination scoring function with similar principles
function calculateRelaxedCombinationScore(combination, desiredCategories, desiredFilters, maxPrice, maxWeight,
    desiredTotalItems) {
    const priceRatio = combination.totalPrice / maxPrice;
    const weightRatio = combination.totalWeight / maxWeight;

    // Calculate desired category coverage
    const desiredCategoryCoverage = desiredCategories.length > 0 ?
        desiredCategories.filter(category =>
            combination.items.some(item => item.category === category)
        ).length / desiredCategories.length : 1;

    // Calculate desired filter coverage
    let desiredAttributeMatches = 0;
    let totalDesiredAttributes = 0;

    // Attribute types to check (consistent with previous function)
    const filterTypes = [
        'bahan_dasar', 
        'basah_kering', 
        'rasa', 
        'produsen', 
        'kategori_umum', 
        'nama_barang'
    ];

    // Calculate matches for all attribute types
    filterTypes.forEach(type => {
        if (desiredFilters[type] && desiredFilters[type].length > 0) {
            // All filter types now have equal weight
            totalDesiredAttributes += desiredFilters[type].length;

            // Count matching items for this attribute type
            for (const value of desiredFilters[type]) {
                // Use different property access for category vs other attributes
                const matchProperty = type === 'kategori_umum' ? 'category' : 
                    type === 'nama_barang' ? 'name' : type;

                if (combination.items.some(item => item[matchProperty] === value)) {
                    desiredAttributeMatches++;
                }
            }
        }
    });

    // Calculate filter match ratio
    const filterMatchRatio = totalDesiredAttributes > 0 ?
        desiredAttributeMatches / totalDesiredAttributes : 0;

    // Calculate variety score (how many different categories)
    const uniqueCategories = new Set(combination.items.map(item => item.category)).size;
    const varietyScore = Math.min(uniqueCategories / 4, 1); // Cap at 4 categories

    // Calculate priority item ratio
    const priorityRatio = desiredCategories.length > 0 ?
        combination.priorityCount / combination.items.length : 0;

    // Calculate item count score
    let itemCountScore = 1;
    if (desiredTotalItems) {
        itemCountScore = 1 - Math.abs(combination.items.length - desiredTotalItems) / desiredTotalItems;
        itemCountScore = Math.max(0, itemCountScore);
    }

    // Calculate final score with updated, more consistent weights
    return (desiredCategoryCoverage * 0.15) +  // Category coverage
        (filterMatchRatio * 0.20) +            // Increased weight for all filter matches
        (varietyScore * 0.15) +                // Category variety
        ((1 - priceRatio) * 0.10) +            // Price optimization
        ((1 - weightRatio) * 0.10) +           // Weight optimization
        (priorityRatio * 0.15) +               // Increased priority item ratio
        (itemCountScore * 0.15);               // Increased item count scoring
}

        // Function to calculate combination score with consistent attribute scoring
function calculateCombinationScore(combination, desiredCategories, desiredFilters, maxPrice, maxWeight,
    desiredTotalItems) {
    const priceRatio = combination.totalPrice / maxPrice;
    const weightRatio = combination.totalWeight / maxWeight;

    // Calculate desired category coverage (percent of desired categories included)
    const desiredCategoryCoverage = desiredCategories.length > 0 ?
        desiredCategories.filter(category =>
            combination.items.some(item => item.category === category)
        ).length / desiredCategories.length : 1;

    // Calculate desired filter coverage (how many desired attributes are included)
    let desiredAttributeMatches = 0;
    let totalDesiredAttributes = 0;

    // Attribute types to check
    const filterTypes = [
        'bahan_dasar', 
        'basah_kering', 
        'rasa', 
        'produsen', 
        'kategori_umum', 
        'nama_barang'
    ];

    // Calculate matches for all attribute types
    filterTypes.forEach(type => {
        if (desiredFilters[type] && desiredFilters[type].length > 0) {
            // All filter types now have equal weight
            totalDesiredAttributes += desiredFilters[type].length;

            // Count matching items for this attribute type
            for (const value of desiredFilters[type]) {
                // Use different property access for category vs other attributes
                const matchProperty = type === 'kategori_umum' ? 'category' : 
                    type === 'nama_barang' ? 'name' : type;

                if (combination.items.some(item => item[matchProperty] === value)) {
                    desiredAttributeMatches++;
                }
            }
        }
    });

    // Calculate filter match ratio
    const filterMatchRatio = totalDesiredAttributes > 0 ?
        desiredAttributeMatches / totalDesiredAttributes : 0;

    // Calculate variety score (how many different categories)
    const uniqueCategories = new Set(combination.items.map(item => item.category)).size;
    const varietyScore = Math.min(uniqueCategories / 4, 1); // Cap at 4 categories

    // Calculate priority item ratio (items from desired categories)
    const priorityRatio = desiredCategories.length > 0 ?
        combination.priorityCount / combination.items.length : 0;

    // Calculate item count score (how close to desired count)
    let itemCountScore = 1;
    if (desiredTotalItems) {
        itemCountScore = 1 - Math.abs(combination.items.length - desiredTotalItems) / desiredTotalItems;
        itemCountScore = Math.max(0, itemCountScore);
    }

    // Calculate final score with updated, more consistent weights
    return (desiredCategoryCoverage * 0.15) +  // Category coverage
        (filterMatchRatio * 0.20) +            // Increased weight for all filter matches
        (varietyScore * 0.15) +                // Category variety
        ((1 - priceRatio) * 0.10) +            // Price optimization
        ((1 - weightRatio) * 0.10) +           // Weight optimization
        (priorityRatio * 0.15) +               // Increased priority item ratio
        (itemCountScore * 0.15);               // Increased item count scoring
}

        // Modified function to get best recommendations with enhanced filtering
        function getBestRecommendations(items, maxPrice, maxWeight) {
            // Get selected categories and filters
            const {
                desiredCategories,
                desiredFilters,
                unwantedFilters
            } = getSelectedFilters();

            // Find similar past parcels
            const similarParcels = findSimilarPastParcels(desiredCategories);

            // Get desired total items
            const desiredTotalItems = parseInt(document.getElementById('total-items').value);

            // Process items to include additional attributes
            const processedItems = items.map(item => ({
                ...item,
                category: item.category,
                bahan_dasar: item.bahan_dasar || 'Unknown',
                basah_kering: item.basah_kering || 'Unknown',
                rasa: item.rasa || 'Unknown',
                produsen: item.produsen || 'Unknown'
            }));

            // Generate combinations with enhanced filter handling
            let combinations = generateBalancedCombinations(
                processedItems,
                maxPrice,
                maxWeight,
                desiredCategories,
                desiredFilters,
                unwantedFilters,
                desiredTotalItems
            );

            // If we have similar parcels with high similarity, add reference compositions
            if (similarParcels.length > 0 && similarParcels[0].similarityScore > 0.5) {
                // Add up to 2 reference compositions from past similar parcels
                const topSimilarParcels = similarParcels.slice(0, 2);

                for (const similarParcel of topSimilarParcels) {
                    // Check if the similar parcel's total price and weight fit within constraints
                    const totalPrice = similarParcel.items.reduce((sum, item) => sum + item.price, 0);
                    const totalWeight = similarParcel.items.reduce((sum, item) => sum + item.berat, 0);

                    if (totalPrice <= maxPrice && totalWeight <= maxWeight) {
                        // Find corresponding items in our current inventory
                        const referenceItems = [];

                        // For each item in the similar parcel, find a matching or similar item in current inventory
                        for (const parcelItem of similarParcel.items) {
                            // Try to find exact item by category and ensure it doesn't have unwanted attributes
                            const matchingItems = processedItems.filter(item =>
                                item.category.toLowerCase() === parcelItem.category.toLowerCase() &&
                                !unwantedFilters.bahan_dasar.includes(item.bahan_dasar) &&
                                !unwantedFilters.basah_kering.includes(item.basah_kering) &&
                                !unwantedFilters.rasa.includes(item.rasa) &&
                                !unwantedFilters.produsen.includes(item.produsen) &&
                                !unwantedFilters.nama_barang.includes(item.name)
                            );

                            if (matchingItems.length > 0) {
                                // Sort by price similarity to the original item
                                matchingItems.sort((a, b) =>
                                    Math.abs(a.price - parcelItem.price) - Math.abs(b.price - parcelItem.price)
                                );

                                // Add the best match
                                referenceItems.push(matchingItems[0]);
                            }
                        }

                        // Check if we have enough items to create a reference parcel
                        if (referenceItems.length >= 3) {
                            // Calculate totals for the reference composition
                            const referenceTotalPrice = referenceItems.reduce((sum, item) => sum + item.price, 0);
                            const referenceTotalWeight = referenceItems.reduce((sum, item) => sum + item.berat, 0);

                            // Create a reference combination
                            if (referenceTotalPrice <= maxPrice && referenceTotalWeight <= maxWeight) {
                                const categoryCounts = {};
                                let priorityCount = 0;

                                referenceItems.forEach(item => {
                                    // Update category counts
                                    categoryCounts[item.category] = (categoryCounts[item.category] || 0) + 1;

                                    // Update priority count if needed
                                    if (desiredCategories.includes(item.category)) {
                                        priorityCount++;
                                    }
                                });

                                // Add the reference combination with a boost to its score
                                combinations.push({
                                    items: referenceItems,
                                    totalPrice: referenceTotalPrice,
                                    totalWeight: referenceTotalWeight,
                                    categoryCounts: categoryCounts,
                                    priorityCount: priorityCount,
                                    score: calculateCombinationScore({
                                            items: referenceItems,
                                            totalPrice: referenceTotalPrice,
                                            totalWeight: referenceTotalWeight,
                                            categoryCounts: categoryCounts,
                                            priorityCount: priorityCount
                                        }, desiredCategories, desiredFilters, maxPrice, maxWeight,
                                        desiredTotalItems) * 1.25, // 25% boost
                                    isReference: true,
                                    referenceParcelId: similarParcel.id,
                                    referenceRating: similarParcel.reviewKomposisi
                                });
                            }
                        }
                    }
                }
            }

            // If no combinations found, try with relaxed constraints
            if (combinations.length === 0) {
                throw new Error("Tidak dapat menemukan kombinasi yang sesuai. Coba ubah kriteria pencarian.");
            }

            return combinations
                .sort((a, b) => b.score - a.score)
                .slice(0, MAX_RECOMMENDATIONS);
        }

        // Modified display recommendations function
        let globalRecommendations = []; // Store recommendations globally
        let parcelId; // Variable to store parcel_id

      // Also update the display function to highlight which filters are satisfied
function displayRecommendations(recommendations, id) {
    parcelId = id;
    
    // First, sort the recommendations by item count (descending) and then by weight (descending)
    const sortedRecommendations = [...recommendations].sort((a, b) => {
        // First sort by item count (highest first)
        if (b.items.length !== a.items.length) {
            return b.items.length - a.items.length;
        }
        // Then sort by weight (heaviest first) as a tiebreaker
        return b.totalWeight - a.totalWeight;
    });
    
    // Store the sorted recommendations globally
    globalRecommendations = sortedRecommendations;
    
    const container = document.getElementById('barang-list');
    container.innerHTML = '';

    const desiredPrice = parseFloat(document.getElementById('desired-price').value);
    const desiredWeight = parseFloat(document.getElementById('desired-weight').value);
    const desiredTotalItems = document.getElementById('total-items').value ? 
        parseInt(document.getElementById('total-items').value) : null;
    
    const { desiredCategories, desiredFilters, unwantedFilters } = getSelectedFilters();

    // Show only top 3 recommendations with clear ranking
    const maxDisplay = Math.min(3, sortedRecommendations.length);
    
    for (let i = 0; i < maxDisplay; i++) {
        const rec = sortedRecommendations[i];
        const rankNum = i + 1;
        
        // Group items by category
        const itemsByCategory = {};
        rec.items.forEach(item => {
            if (!itemsByCategory[item.category]) {
                itemsByCategory[item.category] = [];
            }
            itemsByCategory[item.category].push(item);
        });

        const totalItems = rec.items.length;

        // NEW: Track which filters are satisfied
        const satisfiedFilters = {
            bahan_dasar: new Set(),
            basah_kering: new Set(),
            rasa: new Set(),
            produsen: new Set(),
            nama_barang: new Set()
        };
        
        // Populate satisfied filters
        rec.items.forEach(item => {
            if (item.bahan_dasar && desiredFilters.bahan_dasar.includes(item.bahan_dasar)) {
                satisfiedFilters.bahan_dasar.add(item.bahan_dasar);
            }
            if (item.basah_kering && desiredFilters.basah_kering.includes(item.basah_kering)) {
                satisfiedFilters.basah_kering.add(item.basah_kering);
            }
            if (item.rasa && desiredFilters.rasa.includes(item.rasa)) {
                satisfiedFilters.rasa.add(item.rasa);
            }
            if (item.produsen && desiredFilters.produsen.includes(item.produsen)) {
                satisfiedFilters.produsen.add(item.produsen);
            }
            if (item.name && desiredFilters.nama_barang.includes(item.name)) {
                satisfiedFilters.nama_barang.add(item.name);
            }
        });

        // NEW: Generate filter summary
        let filterSummaryHtml = '';
        const filterNames = {
            bahan_dasar: "Bahan Dasar",
            basah_kering: "Basah/Kering",
            rasa: "Rasa",
            produsen: "Produsen",
            nama_barang: "Nama Produk"
        };
        
        // Add filter satisfaction summary
        for (const [filterType, displayName] of Object.entries(filterNames)) {
            if (desiredFilters[filterType] && desiredFilters[filterType].length > 0) {
                const totalSelected = desiredFilters[filterType].length;
                const satisfiedCount = satisfiedFilters[filterType].size;
                
                if (satisfiedCount === totalSelected) {
                    filterSummaryHtml += `<div class="text-success"><i class="fas fa-check-circle"></i> Semua ${displayName} terpenuhi</div>`;
                } else {
                    filterSummaryHtml += `<div>${satisfiedCount}/${totalSelected} ${displayName} terpenuhi</div>`;
                }
            }
        }

        // Generate category breakdown html
        let categoryBreakdownHtml = '';
        Object.entries(itemsByCategory).forEach(([category, items]) => {
            const isPriorityCategory = desiredCategories.includes(category);
            const categoryLabel = isPriorityCategory ?
                `<strong class="text-success">${category} (Diinginkan)</strong>` :
                `<strong>${category}</strong>`;

            categoryBreakdownHtml += `
                <div class="mb-3">
                    ${items.map(item => {
                        // Check if item matches any of the desired filters
                        const matchedFilters = [];
                        
                        if (desiredFilters.bahan_dasar.includes(item.bahan_dasar)) {
                            matchedFilters.push('bahan_dasar');
                        }
                        if (desiredFilters.basah_kering.includes(item.basah_kering)) {
                            matchedFilters.push('basah_kering');
                        }
                        if (desiredFilters.rasa.includes(item.rasa)) {
                            matchedFilters.push('rasa');
                        }
                        if (desiredFilters.produsen.includes(item.produsen)) {
                            matchedFilters.push('produsen');
                        }
                        if (desiredFilters.nama_barang.includes(item.name)) {
                            matchedFilters.push('nama_barang');
                        }
                        
                        return `
                            <div class="mb-2">
                                ${desiredFilters.nama_barang.includes(item.name) ? 
                                    `<span class="text-success font-weight-bold">${item.name} &#x2713;</span>` : `<b>${item.name}</b>`} <br>
                                ${item.berat}g - Rp ${item.price.toLocaleString()} <br>
                                ${desiredCategories.includes(category) ? 
                                `<span class="text-success font-weight-bold">Kategori: ${item.category} &#x2713;</span><br>` : ''}
                                                        
                            ${desiredFilters.bahan_dasar.includes(item.bahan_dasar) ? 
                                `<span class="text-success font-weight-bold">Bahan Dasar: ${item.bahan_dasar} &#x2713;</span><br>` : ''}
                            
                            ${desiredFilters.basah_kering.includes(item.basah_kering) ? 
                                `<span class="text-success font-weight-bold">Basah Kering: ${item.basah_kering} &#x2713;</span><br>` : ''}
                            
                            ${desiredFilters.rasa.includes(item.rasa) ? 
                                `<span class="text-success font-weight-bold">Rasa: ${item.rasa} &#x2713;</span><br>` : ''}
                            
                            ${desiredFilters.produsen.includes(item.produsen) ? 
                                `<span class="text-success font-weight-bold">Produsen: ${item.produsen} &#x2713;</span><br>` : ''}
                                
                            </div>
                        `;
                    }).join('')}
                </div>
            `;
        });

        // Create additional info if this is a reference parcel
        let referenceInfo = '';
        if (rec.isReference) {
            referenceInfo = `
                <div class="alert alert-success mt-2">
                    <i class="fas fa-star mr-1"></i> Rekomendasi ini berdasarkan parcel ID #${rec.referenceParcelId} 
                    dengan rating komposisi ${rec.referenceRating}/5
                </div>
            `;
        }

        // Create ranking badge with clearer visual hierarchy
        const rankingBadge = `
            <div class="position-absolute" style="top: 10px; right: 10px;">
                <span class="badge badge-pill badge-primary" style="font-size: 1.2rem;">RANK #${rankNum}</span>
            </div>
        `;

        //${rankingBadge}
        // <!-- NEW: Filter summary -->
        // <div class="mt-2 mb-2">
        //     ${filterSummaryHtml}
        // </div>
        
        const parcelHtml = `
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Rekomendasi Parcel #${rankNum}</h5>
                        
                    </div>
                    <div class="card-body">
                        <h7>Total Item: ${totalItems} ${desiredTotalItems ? `/ ${desiredTotalItems} diinginkan` : ''}</h7><br>
                        <h7>Total Harga: Rp ${rec.totalPrice.toLocaleString()} (Rp ${desiredPrice.toLocaleString()})</h7><br>
                        <h7>Total Berat: ${rec.totalWeight} Gram (${desiredWeight} Gram)</h7>
                        
                        ${referenceInfo}
                        <hr>
                        <h6>Isi Parcel:</h6>
                        ${categoryBreakdownHtml}
                        <button class="btn btn-primary select-parcel" data-index="${i}">
                            Pilih Parcel Ini
                        </button>
                    </div>
                </div>
            </div>
        `;

        container.innerHTML += parcelHtml;
    }


    // Add event listeners for parcel selection
    document.querySelectorAll('.select-parcel').forEach(button => {
        button.addEventListener('click', function() {
            // Reset all buttons to original state
            document.querySelectorAll('.select-parcel').forEach((btn, idx) => {
                const rankNum = idx + 1;
                btn.innerHTML = rankNum === 1 ? 'Pilih Parcel Ini' : 'Pilih Parcel Ini';
                btn.classList.remove('btn-success', 'selected');
                btn.classList.add(rankNum === 1 ? 'btn-primary' : 'btn-primary');
            });

            // Change the clicked button's style
            this.innerHTML = 'Selected';
            this.classList.remove('btn-primary');
            this.classList.add('btn-success', 'selected');

            // Get the recommendation index
            const index = this.getAttribute('data-index');
            selectedItems = [...sortedRecommendations[index].items];
            updateSelectedItems();
        });
    });

    // Log the sorted recommendations for debugging
    console.log('Rekomendasi Parcel (Diurutkan):', JSON.stringify(sortedRecommendations.slice(0, maxDisplay), null, 2));
}

document.getElementById("process-button").addEventListener("click", async function() {
    console.log("Process button clicked");

    const desiredPrice = parseFloat(document.getElementById('desired-price').value);
    const desiredWeight = parseFloat(document.getElementById('desired-weight').value);

    if (!desiredPrice || !desiredWeight) {
        alert("Masukkan harga dan berat yang diinginkan");
        return;
    }

    // Show loading state
    this.disabled = true;
    this.innerHTML =
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';

    try {
        // Get items from API instead of DOM
        const availableItems = await getAvailableItems();

        // Get filter selections
        const {
            desiredCategories,
            desiredFilters,
            unwantedFilters
        } = getSelectedFilters();

        // Get selected kota ID
        const kotaId = document.getElementById('kota').value;

        // Fetch kota data including rajaongkir info
        const kotaResponse = await fetch(`/api/kota/${kotaId}`);
        const kotaData = await kotaResponse.json();

        // Create location JSON object with rajaongkir data
        const locationDetails = {
            provinsi: {
                id: document.getElementById('provinsi').value,
                name: document.getElementById('provinsi').options[document.getElementById(
                    'provinsi').selectedIndex].text
            },
            kota: {
                id: document.getElementById('kota').value,
                name: document.getElementById('kota').options[document.getElementById('kota')
                    .selectedIndex].text,
                kota_rajaongkir: kotaData.rajaongkir_city,
                postal_rajaongkir: kotaData.rajaongkir_postal
            },
            kecamatan: {
                id: document.getElementById('kecamatan').value,
                name: document.getElementById('kecamatan').options[document.getElementById(
                    'kecamatan').selectedIndex].text
            },
            kelurahan: {
                id: document.getElementById('kelurahan').value,
                name: document.getElementById('kelurahan').options[document.getElementById(
                    'kelurahan').selectedIndex].text
            },
            alamat_lengkap: document.getElementById('alamat').value
        };

        document.querySelector('input[name="alamat"]').value = JSON.stringify(locationDetails);

        const recommendations = getBestRecommendations(availableItems, desiredPrice, desiredWeight);
        
        // Add selected filters to each recommendation for storage/retrieval
        recommendations.forEach(rec => {
            // Add the user's filter selections to each recommendation
            rec.userFilters = {
                desiredCategories: desiredCategories,
                desiredFilters: desiredFilters,
                unwantedFilters: unwantedFilters,
                desiredPrice: desiredPrice,
                desiredWeight: desiredWeight,
                desiredTotalItems: document.getElementById('total-items').value ? 
                    parseInt(document.getElementById('total-items').value) : null
            };
            
            // Mark items that match filters
            rec.items.forEach(item => {
                item.matchesUserFilters = {
                    category: desiredCategories.includes(item.category),
                    bahan_dasar: desiredFilters.bahan_dasar.includes(item.bahan_dasar),
                    basah_kering: desiredFilters.basah_kering.includes(item.basah_kering),
                    rasa: desiredFilters.rasa.includes(item.rasa),
                    produsen: desiredFilters.produsen.includes(item.produsen),
                    nama_barang: desiredFilters.nama_barang.includes(item.name)
                };
                
                // Add a summary flag if any filter matches
                item.matchesAnyUserFilter = Object.values(item.matchesUserFilters).some(val => val === true);
            });
        });

        // Get form data
        const form = document.getElementById('parcel-form');
        const formData = new FormData(form);
        formData.set('barang', JSON.stringify(recommendations));
        formData.set('desired_categories', JSON.stringify(desiredCategories));
        formData.set('desired_filters', JSON.stringify(desiredFilters));
        formData.set('unwanted_filters', JSON.stringify(unwantedFilters));

        const _token = document.querySelector('input[name="_token"]').value;

        // Save to server
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': _token,
                'Accept': 'application/json'
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            displayRecommendations(recommendations, data.parcel_id);
        } else {
            alert('Terjadi Kesalahan: ' + (data.message || 'Unknown error'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert(error.message || "Terjadi kesalahan saat memproses rekomendasi");
    } finally {
        this.disabled = false;
        this.innerHTML = 'Proses';
    }
});



        // Function to prevent selection of the same category in both desired and unwanted lists
        document.addEventListener('DOMContentLoaded', function() {
            // Add event listeners to desired category checkboxes
            document.querySelectorAll('.desired-category').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        // Get the category value
                        const category = this.value;
                        // Find the corresponding unwanted checkbox and uncheck it
                        const unwantedCheckbox = document.querySelector(
                            `.unwanted-filter[value="${category}"]`);
                        if (unwantedCheckbox) {
                            unwantedCheckbox.checked = false;
                        }
                    }
                });
            });

            // Add event listeners to unwanted category checkboxes
            document.querySelectorAll('.unwanted-filter').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        // Get the category value
                        const category = this.value;
                        // Find the corresponding desired checkbox and uncheck it
                        const desiredCheckbox = document.querySelector(
                            `.desired-category[value="${category}"]`);
                        if (desiredCheckbox) {
                            desiredCheckbox.checked = false;
                        }
                    }
                });
            });
        });

        function saveToCart(items) {
            const _token = document.querySelector('input[name="_token"]').value;

            fetch('save-to-cart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': _token
                    },
                    body: JSON.stringify({
                        items: items
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // alert('Barang berhasil ditambahkan ke keranjang!');
                    } else {
                        alert('Gagal menambahkan barang ke keranjang: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan ke keranjang.');
                });
        }

        // Keep the existing functions for chips
        function createChip(name) {
            const chipContainer = document.querySelector(".chips-container");
            const chip = document.createElement("div");
            chip.classList.add("chip");
            chip.textContent = name;

            const closeIcon = document.createElement("span");
            closeIcon.classList.add("close-icon");
            closeIcon.textContent = " x";
            closeIcon.onclick = function() {
                chip.remove();
            };

            chip.appendChild(closeIcon);
            chipContainer.appendChild(chip);
        }

        function getChipsKeywords() {
            const chips = document.querySelectorAll(".chip");
            return Array.from(chips).map(chip =>
                chip.textContent.replace(" x", "").toLowerCase().trim()
            );
        }

        // Modified handleKeyDown function
        function handleKeyDown(event) {
            if (event.key === ",") {
                event.preventDefault();
                const searchBar = event.target;
                const terms = searchBar.value.split(",");

                terms.forEach(term => {
                    const trimmedTerm = term.trim();
                    if (trimmedTerm) {
                        createChip(trimmedTerm);
                    }
                });

                searchBar.value = "";
            }
        }

        // Keep the existing updateSelectedItems function
        function updateSelectedItems() {
    // Get the current selections from the UI
    const selectedIndex = document.querySelector('.select-parcel.selected')?.getAttribute('data-index');
    if (selectedIndex !== undefined && globalRecommendations[selectedIndex]) {
        // Get the selected recommendation with all its data including user filters
        const selectedRecommendation = globalRecommendations[selectedIndex];
        
        // Update selected items 
        selectedItems = [...selectedRecommendation.items];
        
        // Persist the selection to the server
        const _token = document.querySelector('input[name="_token"]').value;
        
        fetch(`/p/api/parcel/${parcelId}/select`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': _token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                selected_items: selectedItems,
                user_filters: selectedRecommendation.userFilters || {
                    desiredCategories: [],
                    desiredFilters: {
                        bahan_dasar: [],
                        basah_kering: [],
                        rasa: [],
                        produsen: [],
                        nama_barang: []
                    },
                    unwantedFilters: {
                        kategori_umum: [],
                        bahan_dasar: [],
                        basah_kering: [],
                        rasa: [], 
                        produsen: [],
                        nama_barang: []
                    }
                }
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Selection saved successfully');
            } else {
                console.error('Error saving selection:', data.message);
            }
        })
        .catch(error => {
            console.error('Error saving selection:', error);
        });
    }
}

        document.querySelectorAll('.remove-item-button').forEach(button => {
            button.addEventListener('click', function() {
                const index = this.getAttribute('data-index');
                const removedItem = selectedItems.splice(index, 1)[0];
                updateSelectedItems();

                // Tampilkan kembali item yang dihapus di daftar barang tersedia
                // document.querySelector(`.barang-item .add-item-button[data-id="${removedItem.id}"]`)
                //     .closest('.barang-item').style.display = '';
            });
        });

        document.getElementById('submit-parcel').addEventListener('click', function() {
            if (selectedItems.length === 0) {
                alert('Pilih setidaknya satu barang untuk dipesan.');
                return;
            }

            // Konversi ke JSON dan tampilkan di konsol
            const selectedItemsJson = JSON.stringify(selectedItems, null);
            console.log(selectedItemsJson); // Tampilkan di konsol

            // Tampilkan JSON ke dalam halaman
            // alert(selectedItemsJson);

            // Submit form jika diperlukan
            // document.getElementById('parcel-form').submit();

        });

        document.getElementById('save-recommendations').addEventListener('click', function() {
            if (selectedItems.length === 0) {
                alert('Pilih setidaknya satu barang untuk disimpan.');
                return;
            }

            // Get the parcel quantity
            const parcelQuantity = parseInt(document.getElementById('parcel-quantity').value) || 1;

            // Simpan ke keranjang dengan parcel_id dan quantity
            saveToCart(selectedItems, parcelId, parcelQuantity);

            // Mengonversi selectedItems ke JSON
            const selectedItemsJson = JSON.stringify(selectedItems);

            // Mengirim data ke server
            fetch(`/permintaan-parcel/save-selected-items/${parcelId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        items: selectedItems,
                        parcel_quantity: parcelQuantity // Add parcel quantity to this request too
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = 'keranjang';
                    } else {
                        alert('Terjadi kesalahan saat menyimpan rekomendasi: ' + (data.error ||
                            'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan rekomendasi.');
                });
        });

        function saveToCart(items, parcelId, parcelQuantity = 1) {
            const _token = document.querySelector('input[name="_token"]').value;

            fetch('save-to-cart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': _token
                    },
                    body: JSON.stringify({
                        items: items,
                        parcel_id: parcelId, // Kirim parcel_id ke backend
                        parcel_quantity: parcelQuantity // Send parcel quantity to backend
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // alert('Barang berhasil ditambahkan ke keranjang!');
                    } else {
                        alert('Gagal menambahkan barang ke keranjang: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan ke keranjang.');
                });
        }
    </script>

    <script>
    document.getElementById('random-filter-button').addEventListener('click', function() {
    // Clear all existing selections first
    document.querySelectorAll('.desired-category, .desired-filter, .unwanted-filter').forEach(checkbox => {
        checkbox.checked = false;
    });

    // Get all filter sections
    const filterSections = [
        '#desired-categories', '#desired-bahan', '#desired-basah-kering', '#desired-rasa',
        '#desired-produsen', '#desired-nama-produk', '#unwanted-categories', '#unwanted-bahan',
        '#unwanted-basah-kering', '#unwanted-rasa', '#unwanted-produsen', '#unwanted-nama-produk'
    ];

    // For each filter section, randomly select some options
    filterSections.forEach(sectionId => {
        const section = document.querySelector(sectionId);
        if (section) {
            const checkboxes = section.querySelectorAll('input[type="checkbox"]');
            if (checkboxes.length > 0) {
                // Determine how many to select (1-3 for desired, 0-2 for unwanted)
                const isDesired = sectionId.includes('desired');
                const maxToSelect = isDesired ? 3 : 2;
                const numToSelect = Math.floor(Math.random() * maxToSelect) + (isDesired ? 1 : 0);

                // Shuffle and select
                const shuffled = Array.from(checkboxes).sort(() => 0.5 - Math.random());
                shuffled.slice(0, numToSelect).forEach(checkbox => {
                    checkbox.checked = true;
                });
            }
        }
    });

    // Collect selected filters for display
    const desiredCategories = Array.from(document.querySelectorAll('#desired-categories input:checked')).map(cb => cb.value);
    const desiredBahan = Array.from(document.querySelectorAll('#desired-bahan input:checked')).map(cb => cb.value);
    const desiredBasahKering = Array.from(document.querySelectorAll('#desired-basah-kering input:checked')).map(cb => cb.value);
    const desiredRasa = Array.from(document.querySelectorAll('#desired-rasa input:checked')).map(cb => cb.value);
    const desiredProdusen = Array.from(document.querySelectorAll('#desired-produsen input:checked')).map(cb => cb.value);
    const desiredNamaProduk = Array.from(document.querySelectorAll('#desired-nama-produk input:checked')).map(cb => cb.value);
    const unwantedCategories = Array.from(document.querySelectorAll('#unwanted-categories input:checked')).map(cb => cb.value);
    const unwantedBahan = Array.from(document.querySelectorAll('#unwanted-bahan input:checked')).map(cb => cb.value);
    const unwantedBasahKering = Array.from(document.querySelectorAll('#unwanted-basah-kering input:checked')).map(cb => cb.value);
    const unwantedRasa = Array.from(document.querySelectorAll('#unwanted-rasa input:checked')).map(cb => cb.value);
    const unwantedProdusen = Array.from(document.querySelectorAll('#unwanted-produsen input:checked')).map(cb => cb.value);
    const unwantedNamaProduk = Array.from(document.querySelectorAll('#unwanted-nama-produk input:checked')).map(cb => cb.value);

    // Build the filter text
    let filterText = '';
    if (desiredCategories.length > 0) {
        filterText += `Kategori yang Diinginkan: ${desiredCategories.join(', ')}<br>`;
    }
    if (desiredBahan.length > 0) {
        filterText += `Bahan Dasar yang Diinginkan: ${desiredBahan.join(', ')}<br>`;
    }
    if (desiredBasahKering.length > 0) {
        filterText += `Basah/Kering yang Diinginkan: ${desiredBasahKering.join(', ')}<br>`;
    }
    if (desiredRasa.length > 0) {
        filterText += `Rasa yang Diinginkan: ${desiredRasa.join(', ')}<br>`;
    }
    if (desiredProdusen.length > 0) {
        filterText += `Produsen yang Diinginkan: ${desiredProdusen.join(', ')}<br>`;
    }
    if (desiredNamaProduk.length > 0) {
        filterText += `Nama Produk yang Diinginkan: ${desiredNamaProduk.join(', ')}<br>`;
    }
    if (unwantedCategories.length > 0) {
        filterText += `Kategori yang Tidak Diinginkan: ${unwantedCategories.join(', ')}<br>`;
    }
    if (unwantedBahan.length > 0) {
        filterText += `Bahan Dasar yang Tidak Diinginkan: ${unwantedBahan.join(', ')}<br>`;
    }
    if (unwantedBasahKering.length > 0) {
        filterText += `Basah/Kering yang Tidak Diinginkan: ${unwantedBasahKering.join(', ')}<br>`;
    }
    if (unwantedRasa.length > 0) {
        filterText += `Rasa yang Tidak Diinginkan: ${unwantedRasa.join(', ')}<br>`;
    }
    if (unwantedProdusen.length > 0) {
        filterText += `Produsen yang Tidak Diinginkan: ${unwantedProdusen.join(', ')}<br>`;
    }
    if (unwantedNamaProduk.length > 0) {
        filterText += `Nama Produk yang Tidak Diinginkan: ${unwantedNamaProduk.join(', ')}<br>`;
    }

    // Display the filter text
    const filterDisplay = document.getElementById('selected-filters-display');
    const filterTextElement = document.getElementById('selected-filters-text');
    if (filterText) {
        filterTextElement.innerHTML = filterText;
        filterDisplay.style.display = 'block';
    } else {
        filterDisplay.style.display = 'none';
    }

    // Show a notification
    alert('Filter acak telah dipilih! Klik "Proses" untuk melihat rekomendasi.');
});
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#provinsi').change(function() {
                if ($(this).val() != '') {
                    var select = $(this).attr("id");
                    var value = $(this).val();
                    var dependent = $(this).data('dependent');
                    var _token = $('input[name="_token"]').val();
                    var provinsiValue = $('#provinsi option:selected').val();

                    $.ajax({
                        url: "{{ route('getkota.fetch') }}",
                        method: "POST",
                        data: {
                            select: select,
                            value: value,
                            provinsi: provinsiValue,
                            _token: _token,
                            dependent: dependent
                        },
                        success: function(result) {
                            $('#kota').html(result);
                        }
                    });
                }
            });

            $('#kota').change(function() {
                if ($(this).val() != '') {
                    var select = $(this).attr("id");
                    var value = $(this).val();
                    var dependent = $(this).data('dependent');
                    var _token = $('input[name="_token"]').val();
                    var kotaValue = $('#kota option:selected').val();

                    $.ajax({
                        url: "{{ route('getkecamatan.fetch') }}",
                        method: "POST",
                        data: {
                            select: select,
                            value: value,
                            kota: kotaValue,
                            _token: _token,
                            dependent: dependent
                        },
                        success: function(result) {
                            $('#kecamatan').html(result);
                        }
                    });
                }
            });

            $('#kecamatan').change(function() {
                if ($(this).val() != '') {
                    var select = $(this).attr("id");
                    var value = $(this).val();
                    var dependent = $(this).data('dependent');
                    var _token = $('input[name="_token"]').val();
                    var kecamatanValue = $('#kecamatan option:selected').val();

                    $.ajax({
                        url: "{{ route('getkelurahan.fetch') }}",
                        method: "POST",
                        data: {
                            select: select,
                            value: value,
                            kecamatan: kecamatanValue,
                            _token: _token,
                            dependent: dependent
                        },
                        success: function(result) {
                            $('#kelurahan').html(result);
                        }
                    });
                }
            });
        });
    </script>
@endsection