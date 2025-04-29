@extends('portal_layout.templates')
@section('content')
    <style>
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
        .form-control, .form-select {
            border-radius: var(--radius);
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus, .form-select:focus {
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

        .btn-primary:hover, .btn-success:hover, .btn-danger:hover {
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
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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

                        <input type="text" name="barang" class="form-control" placeholder="Masukkan barang"
                            required style="display: none">
                        <input type="text" name="alamat" class="form-control" placeholder="Masukkan alamat"
                            required style="display: none">
                        <input type="hidden" name="user_id" value="{{ $auth->id }}">
                        
                        
                    </div>
                    <!-- Di dalam form Anda, sebelum tag penutup form -->
                    <div class="text-center">
                        <button type="submit" id="save-recommendations" class="btn btn-primary btn-block mt-2 mb-4" style="width: 100px;">PESAN</button>
                    </div>

                    @foreach ($parcel as $index => $parcel)
                    @if (!$parcel->parcel_children->isEmpty())
                        <div class="content-container" style="display: none">
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
                                    <div class="product-kategori">kategori barang : {{ $child->barang->kategori_umum }}</div>
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
                                <h2 class="section-title">Filter Kategori Barang</h2>
                            </div>
                            
                            <!-- Desired Categories -->
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-header bg-success text-white">
                                        <h5 class="mb-0 text-white">Kategori yang Diinginkan</h5>
                                    </div>
                                    <div class="card-body" style="max-height: 200px; overflow-y: auto;">
                                        <div id="desired-categories" class="category-container">
                                            @php
                                                $uniqueCategories = $card['barang']
                                                    ->filter(function($item) {
                                                        return $item->berat > 0 && 
                                                                $item->kategori_umum != '' && 
                                                                $item->bahan_dasar != '' && 
                                                                $item->basah_kering != '' && 
                                                                $item->rasa != '';
                                                    })
                                                    ->pluck('kategori_umum')
                                                    ->unique()
                                                    ->sort()
                                                    ->values();
                                            @endphp

                                            @foreach ($uniqueCategories as $kategori)
                                                <div class="me-3 ml-3 category-option">
                                                    <input class="form-check-input desired-category" type="checkbox"
                                                        value="{{ $kategori }}" id="desired-{{ Str::slug($kategori) }}">
                                                    <label class="form-check-label" for="desired-{{ Str::slug($kategori) }}">
                                                        {{ $kategori }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <!-- Unwanted Material -->
                                    <div class="col-12 mb-3">
                                        <div class="card filter-card">
                                            <div class="card-header bg-danger text-white">
                                                <h5 class="mb-0 text-white">Bahan Dasar yang Tidak Diinginkan</h5>
                                            </div>
                                            <div class="card-body" style="max-height: 150px; overflow-y: auto;">
                                                <div id="unwanted-bahan" class="category-container">
                                                    @php
                                                        $uniqueBahan = $card['barang']
                                                            ->filter(function($item) {
                                                                return $item->berat > 0 && 
                                                                    $item->kategori_umum != '' && 
                                                                    $item->bahan_dasar != '' && 
                                                                    $item->basah_kering != '' && 
                                                                    $item->rasa != '';
                                                            })
                                                            ->pluck('bahan_dasar')
                                                            ->unique()
                                                            ->sort()
                                                            ->values();
                                                    @endphp

                                                    @foreach ($uniqueBahan as $bahan)
                                                        <div class="me-3 ml-3 category-option">
                                                            <input class="form-check-input unwanted-filter" type="checkbox"
                                                                value="{{ $bahan }}" id="unwanted-bahan-{{ Str::slug($bahan) }}" data-type="bahan_dasar">
                                                            <label class="form-check-label" for="unwanted-bahan-{{ Str::slug($bahan) }}">
                                                                {{ $bahan }}
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
                                                <h5 class="mb-0 text-white">Basah/Kering yang Tidak Diinginkan</h5>
                                            </div>
                                            <div class="card-body" style="max-height: 150px; overflow-y: auto;">
                                                <div id="unwanted-basah-kering" class="category-container">
                                                    @php
                                                        $uniqueBasahKering = $card['barang']
                                                            ->filter(function($item) {
                                                                return $item->berat > 0 && 
                                                                    $item->kategori_umum != '' && 
                                                                    $item->bahan_dasar != '' && 
                                                                    $item->basah_kering != '' && 
                                                                    $item->rasa != '';
                                                            })
                                                            ->pluck('basah_kering')
                                                            ->unique()
                                                            ->sort()
                                                            ->values();
                                                    @endphp

                                                    @foreach ($uniqueBasahKering as $basahKering)
                                                        <div class="me-3 ml-3 category-option">
                                                            <input class="form-check-input unwanted-filter" type="checkbox"
                                                                value="{{ $basahKering }}" id="unwanted-basah-kering-{{ Str::slug($basahKering) }}" data-type="basah_kering">
                                                            <label class="form-check-label" for="unwanted-basah-kering-{{ Str::slug($basahKering) }}">
                                                                {{ $basahKering }}
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
                                                <h5 class="mb-0 text-white">Rasa yang Tidak Diinginkan</h5>
                                            </div>
                                            <div class="card-body" style="max-height: 150px; overflow-y: auto;">
                                                <div id="unwanted-rasa" class="category-container">
                                                    @php
                                                        $uniqueRasa = $card['barang']
                                                            ->filter(function($item) {
                                                                return $item->berat > 0 && 
                                                                    $item->kategori_umum != '' && 
                                                                    $item->bahan_dasar != '' && 
                                                                    $item->basah_kering != '' && 
                                                                    $item->rasa != '';
                                                            })
                                                            ->pluck('rasa')
                                                            ->unique()
                                                            ->sort()
                                                            ->values();
                                                    @endphp

                                                    @foreach ($uniqueRasa as $rasa)
                                                        <div class="me-3 ml-3 category-option">
                                                            <input class="form-check-input unwanted-filter" type="checkbox"
                                                                value="{{ $rasa }}" id="unwanted-rasa-{{ Str::slug($rasa) }}" data-type="rasa">
                                                            <label class="form-check-label" for="unwanted-rasa-{{ Str::slug($rasa) }}">
                                                                {{ $rasa }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mb-5">
                            <button id="process-button" class="btn btn-primary btn-lg">
                                <i class="fas fa-magic me-2"></i>Proses
                            </button>
                        </div>
                    </div>

                    <!-- Hidden buttons -->
                    <button type="submit" id="submit-parcel" class="btn btn-primary btn-block"
                        style="display: none">Pesan</button>
                    <button type="submit" id="save-recommendations" class="btn btn-success btn-lg w-100" style="display: none">
                        <i class="fas fa-shopping-cart me-2"></i>Pesan Parcel
                    </button>
                </form>
            </div>

            <!-- Recommendations Section -->
            <div class="row recommendations-container" id="barang-list">
                <!-- Recommendations will appear here -->
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
        <div class="container">
            <div class="row d-none">
                @foreach ($card['barang'] as $barang)
                    @if ($barang->berat > 0 && $barang->kategori_umum != '' && $barang->bahan_dasar !='' && $barang->basah_kering !='' && $barang->rasa !='')
                        <div class="col-md-3 barang-item" data-name="{{ $barang->nama_barang }}"
                            data-category="{{ $barang->kategori_umum }}">
                            <div class="card product-card">
                                <img src="{{ URL::asset($barang->thumbnail_readable) }}" class="card-img-top"
                                    alt="{{ $barang->nama_barang }}">
                                <div class="card-body">
                                    <div class="product-info">
                                        <h5 class="card-title">{{ $barang->nama_barang }}</h5>
                                        <p class="card-text mb-1">Kategori: {{ $barang->kategori_umum }}</p>
                                        <p class="card-text mb-1">Bahan Dasar: {{ $barang->bahan_dasar }}</p>
                                        <p class="card-text mb-1">Basah Kering: {{ $barang->basah_kering }}</p>
                                        <p class="card-text mb-1">Rasa: {{ $barang->rasa }}</p>
                                        <p class="card-text mb-1">Berat: {{ $barang->berat }} Gram</p>
                                        <p class="card-text mb-1">Penjual: {{ $barang->user->nama }}</p>
                                        <p class="card-text mb-1">{{ $barang->user->detail->kotaModel->name }}</p>
                                    </div>
                                    <div class="product-price">Rp {{ number_format($barang->harga_user, 0, ',', '.') }}</div>
                                    <button class="btn btn-primary btn-sm add-item-button" data-id="{{ $barang->id }}"
                                        data-name="{{ $barang->nama_barang }}" data-price="{{ $barang->harga_user }}"
                                        data-berat="{{ $barang->berat }}" style="display: none">+</button>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.barang-item').forEach(item => {
                item.style.display = 'none'; // Sembunyikan semua barang
            });
        });
        // document.getElementById('search-bar').addEventListener('input', function() {
        //     const keyword = this.value.toLowerCase();
        //     document.querySelectorAll('.barang-item').forEach(item => {
        //         const itemName = item.getAttribute('data-name').toLowerCase();
        //         item.style.display = itemName.includes(keyword) ? '' : 'none';


        //     });
        // });
        // Modified global variables
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

        // Function to get desired categories and unwanted filters
function getSelectedFilters() {
    const desiredCategories = Array.from(document.querySelectorAll('#desired-categories input:checked')).map(cb =>
        cb.value);
    
    // Get all unwanted filters
    const unwantedFilters = {
        bahan_dasar: Array.from(document.querySelectorAll('#unwanted-bahan input:checked')).map(cb => cb.value),
        basah_kering: Array.from(document.querySelectorAll('#unwanted-basah-kering input:checked')).map(cb => cb.value),
        rasa: Array.from(document.querySelectorAll('#unwanted-rasa input:checked')).map(cb => cb.value)
    };
    
    return {
        desiredCategories,
        unwantedFilters
    };
}

        // Function to filter items based on categories and unwanted attributes
function filterItems(items, desiredCategories, unwantedFilters) {
    // Filter out items with unwanted attributes
    let filteredItems = items.filter(item => 
        !unwantedFilters.bahan_dasar.includes(item.bahan_dasar) &&
        !unwantedFilters.basah_kering.includes(item.basah_kering) &&
        !unwantedFilters.rasa.includes(item.rasa)
    );

    // If there are desired categories, prioritize them but don't exclude others
    if (desiredCategories.length > 0) {
        // Separate items into priority and regular
        const priorityItems = filteredItems.filter(item => desiredCategories.includes(item.category));
        const regularItems = filteredItems.filter(item => !desiredCategories.includes(item.category));

        // Tag priority items
        priorityItems.forEach(item => item.isPriority = true);
        regularItems.forEach(item => item.isPriority = false);

        // Combine them back together
        filteredItems = [...priorityItems, ...regularItems];
    }

    return filteredItems;
}

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

        // Modified function to generate balanced combinations
function generateBalancedCombinations(items, maxPrice, maxWeight, desiredCategories, unwantedFilters, desiredTotalItems) {
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

    // Apply filtering
    const filteredItems = filterItems(allItems, desiredCategories, unwantedFilters);

    // Group items by category for better distribution
    const categoriesMap = {};
    filteredItems.forEach(item => {
        if (!categoriesMap[item.category]) {
            categoriesMap[item.category] = [];
        }
        categoriesMap[item.category].push(item);
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

        // Step 1: First include at least one item from each desired category if possible
        if (desiredCategories.length > 0) {
            for (let category of desiredCategories) {
                if (categoriesMap[category] && categoriesMap[category].length > 0) {
                    // Shuffle items in this category and try to add one
                    const categoryItems = shuffleArray([...categoriesMap[category]]);

                    for (let item of categoryItems) {
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

                // Step 2: Add other items, ensuring variety
                // Create a flattened array of all available items
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
                    let score = categoryCount * 2;

                    // Reduce score (increase priority) for desired categories
                    if (isPriorityCategory) {
                        score -= 1;
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

                // Calculate score for this combination
                combination.score = calculateCombinationScore(
                    combination,
                    desiredCategories,
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
                    unwantedCategories,
                    desiredTotalItems
                );
            }

            return combinations
                .sort((a, b) => b.score - a.score)
                .slice(0, MAX_RECOMMENDATIONS);
        }

        // Function to generate combinations with relaxed constraints
        function generateRelaxedCombinations(items, maxPrice, maxWeight, desiredCategories, unwantedCategories,
            desiredTotalItems) {
            // Only exclude unwanted categories, don't require desired ones
            const filteredItems = items.filter(item => !unwantedCategories.includes(item.category));

            let combinations = [];

            for (let attempt = 0; attempt < 20 && combinations.length < MAX_RECOMMENDATIONS; attempt++) {
                let combination = {
                    items: [],
                    totalPrice: 0,
                    totalWeight: 0,
                    categoryCounts: {}
                };

                // Shuffle items
                const shuffledItems = shuffleArray([...filteredItems]);

                // Add items until constraints are met
                for (let item of shuffledItems) {
                    if (combination.totalPrice + item.price <= maxPrice &&
                        combination.totalWeight + item.berat <= maxWeight &&
                        !combination.items.some(selected => selected.id === item.id)) {

                        combination.items.push(item);
                        combination.totalPrice += item.price;
                        combination.totalWeight += item.berat;

                        // Track category count
                        combination.categoryCounts[item.category] =
                            (combination.categoryCounts[item.category] || 0) + 1;

                        // If we've reached desired count, stop adding
                        if (desiredTotalItems && combination.items.length >= desiredTotalItems) {
                            break;
                        }
                    }
                }

                // Add the combination if it has at least 2 items
                if (combination.items.length >= 2) {
                    // Calculate basic score
                    combination.score = (maxPrice - combination.totalPrice) / maxPrice * 0.4 +
                        (maxWeight - combination.totalWeight) / maxWeight * 0.4 +
                        Object.keys(combination.categoryCounts).length / 5 * 0.2;

                    combinations.push(combination);
                }
            }

            return combinations
                .sort((a, b) => b.score - a.score)
                .slice(0, MAX_RECOMMENDATIONS);
        }

        // Modified function to calculate combination score
        function calculateCombinationScore(combination, desiredCategories, maxPrice, maxWeight, desiredTotalItems) {
            const priceRatio = combination.totalPrice / maxPrice;
            const weightRatio = combination.totalWeight / maxWeight;

            // Calculate desired category coverage (percent of desired categories included)
            const desiredCategoryCoverage = desiredCategories.length > 0 ?
                desiredCategories.filter(category =>
                    combination.items.some(item => item.category === category)
                ).length / desiredCategories.length : 1;

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

            // Calculate final score
            const score = (desiredCategoryCoverage * 0.25) +
                (varietyScore * 0.2) +
                ((1 - priceRatio) * 0.15) +
                ((1 - weightRatio) * 0.15) +
                (priorityRatio * 0.15) +
                (itemCountScore * 0.1);

            return score;
        }

        // Modified function to get best recommendations
function getBestRecommendations(items, maxPrice, maxWeight) {
    // Get selected categories and unwanted filters
    const {
        desiredCategories,
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
        rasa: item.rasa || 'Unknown'
    }));

    // Generate combinations
    let combinations = generateBalancedCombinations(
        processedItems,
        maxPrice,
        maxWeight,
        desiredCategories,
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
                    // Try to find exact item by category
                    const matchingItems = processedItems.filter(item => 
                        item.category.toLowerCase() === parcelItem.category.toLowerCase() &&
                        !unwantedFilters.bahan_dasar.includes(item.bahan_dasar) &&
                        !unwantedFilters.basah_kering.includes(item.basah_kering) &&
                        !unwantedFilters.rasa.includes(item.rasa)
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
                            }, desiredCategories, maxPrice, maxWeight, desiredTotalItems) * 1.25, // 25% boost
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

        // Modified display recommendations function
function displayRecommendations(recommendations, id) {
    parcelId = id; // Store parcel_id
    globalRecommendations = recommendations;
    const container = document.getElementById('barang-list');
    container.innerHTML = '';

    const desiredPrice = parseFloat(document.getElementById('desired-price').value);
    const desiredWeight = parseFloat(document.getElementById('desired-weight').value);
    const desiredTotalItems = document.getElementById('total-items').value ?
        parseInt(document.getElementById('total-items').value) : null;
    const {
        desiredCategories
    } = getSelectedFilters();

    recommendations.forEach((rec, index) => {
        // Group items by category
        const itemsByCategory = {};
        rec.items.forEach(item => {
            if (!itemsByCategory[item.category]) {
                itemsByCategory[item.category] = [];
            }
            itemsByCategory[item.category].push(item);
        });

        const priceDifference = rec.totalPrice - desiredPrice;
        const weightDifference = rec.totalWeight - desiredWeight;
        const totalItems = rec.items.length;

        // Generate category breakdown html
        let categoryBreakdownHtml = '';
        Object.entries(itemsByCategory).forEach(([category, items]) => {
            const isPriorityCategory = desiredCategories.includes(category);
            const categoryLabel = isPriorityCategory ?
                `<strong class="text-success">${category} (Diinginkan)</strong>` :
                `<strong>${category}</strong>`;

            categoryBreakdownHtml += `
                <div class="mb-3">
                    <h6>${categoryLabel}</h6>
                    ${items.map(item => `
                        <div class="mb-1">
                            <b>${item.name}</b> <br>
                            ${item.berat}g - Rp ${item.price.toLocaleString()} <br>
                            Kategori : ${item.category} <br>
                            Bahan Dasar : ${item.bahan_dasar} <br>
                            Basah Kering : ${item.basah_kering} <br>
                            Rasa : ${item.rasa} <br>
                            Penjual: ${item.seller} <br>
                            (${item.sellerCity})
                        </div>
                    `).join('')}
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

        const parcelHtml = `
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Rekomendasi Parcel ${index + 1}</h5>
                    </div>
                    <div class="card-body">
                        <h6>Total Item: ${totalItems} ${desiredTotalItems ? `/ ${desiredTotalItems} diinginkan` : ''}</h6>
                        <h6>Total Harga: Rp ${rec.totalPrice.toLocaleString()} | Selisih Harga: Rp ${priceDifference.toLocaleString()}</h6>
                        <h6>Total Berat: ${rec.totalWeight} Gram | Selisih Berat: ${weightDifference} Gram</h6>
                        ${referenceInfo}
                        <hr>
                        <h6>Isi Parcel:</h6>
                        ${categoryBreakdownHtml}
                        <button class="btn btn-primary select-parcel" data-index="${index}">Pilih Parcel Ini</button>
                    </div>
                </div>
            </div>
        `;

        container.innerHTML += parcelHtml;
    });

    // Add event listeners for parcel selection
    document.querySelectorAll('.select-parcel').forEach(button => {
        button.addEventListener('click', function() {
            // Reset all buttons to original state
            document.querySelectorAll('.select-parcel').forEach(btn => {
                btn.innerHTML = 'Pilih Parcel Ini';
                btn.classList.remove('btn-success', 'selected');
                btn.classList.add('btn-primary');
            });

            // Change the clicked button's style
            this.innerHTML = 'Selected';
            this.classList.remove('btn-primary');
            this.classList.add('btn-success', 'selected');

            // Get the recommendation index
            const index = this.getAttribute('data-index');
            selectedItems = [...recommendations[index].items];
            updateSelectedItems();
        });
    });

    // Log recommendations for debugging
    console.log('Rekomendasi Parcel:', JSON.stringify(recommendations, null, 2));
}

        // Modified process button event listener
document.getElementById("process-button").addEventListener("click", function() {
    console.log("Process button clicked");

    const desiredPrice = parseFloat(document.getElementById('desired-price').value);
    const desiredWeight = parseFloat(document.getElementById('desired-weight').value);

    console.log("Desired price:", desiredPrice);
    console.log("Desired weight:", desiredWeight);
    
    const {
        desiredCategories,
        unwantedFilters
    } = getSelectedFilters();

    // Create location JSON object
    const locationDetails = {
        provinsi: {
            id: document.getElementById('provinsi').value,
            name: document.getElementById('provinsi').options[document.getElementById('provinsi')
                .selectedIndex].text
        },
        kota: {
            id: document.getElementById('kota').value,
            name: document.getElementById('kota').options[document.getElementById('kota').selectedIndex]
                .text
        },
        kecamatan: {
            id: document.getElementById('kecamatan').value,
            name: document.getElementById('kecamatan').options[document.getElementById('kecamatan')
                .selectedIndex].text
        },
        kelurahan: {
            id: document.getElementById('kelurahan').value,
            name: document.getElementById('kelurahan').options[document.getElementById('kelurahan')
                .selectedIndex].text
        },
        alamat_lengkap: document.getElementById('alamat').value
    };

    // Set the location JSON to the hidden alamat input
    document.querySelector('input[name="alamat"]').value = JSON.stringify(locationDetails);

    // Form validation
    if (!desiredPrice || !desiredWeight) {
        alert("Masukkan harga dan berat yang diinginkan");
        return;
    }

    // Show loading state
    this.disabled = true;
    this.innerHTML =
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';

    // Get all available items
    const availableItems = Array.from(document.querySelectorAll('.barang-item')).map(item => {
        const button = item.querySelector('.add-item-button');
        const categoryElement = item.querySelector('.card-text:nth-child(2)');
        const sellerElement = item.querySelector('.card-text:nth-child(7)');
        const cityElement = item.querySelector('.card-text:nth-child(8)');
        const bahanElement = item.querySelector('.card-text:nth-child(3)');
        const basahKeringElement = item.querySelector('.card-text:nth-child(4)');
        const rasaElement = item.querySelector('.card-text:nth-child(5)');
        const thumbnailElement = item.querySelector('.card-img-top');

        const seller = sellerElement ? sellerElement.textContent.replace('Penjual: ', '').trim() :
            'Unknown Seller';
        const sellerCity = cityElement ? cityElement.textContent.trim() : 'Unknown City';
        const category = categoryElement ? categoryElement.textContent.replace('Kategori: ', '')
            .trim() : 'Unknown Category';
        const bahan_dasar = bahanElement ? bahanElement.textContent.replace('Bahan Dasar: ', '')
            .trim() : 'Unknown';
        const basah_kering = basahKeringElement ? basahKeringElement.textContent.replace('Basah Kering: ', '')
            .trim() : 'Unknown';
        const rasa = rasaElement ? rasaElement.textContent.replace('Rasa: ', '')
            .trim() : 'Unknown';

        // Get the correct thumbnail URL
        const thumbnailSrc = thumbnailElement.src;

        return {
            id: button.getAttribute('data-id'),
            name: button.getAttribute('data-name'),
            price: parseFloat(button.getAttribute('data-price')),
            berat: parseFloat(button.getAttribute('data-berat')),
            seller: seller,
            sellerCity: sellerCity,
            thumbnail: thumbnailSrc,
            category: category,
            bahan_dasar: bahan_dasar,
            basah_kering: basah_kering,
            rasa: rasa
        };
    });

    // Use setTimeout to prevent UI blocking
    setTimeout(() => {
        try {
            const recommendations = getBestRecommendations(availableItems, desiredPrice,
                desiredWeight);
            displayRecommendations(recommendations);

            // Get the form data
            const form = document.getElementById('parcel-form');
            const formData = new FormData(form);

            // Add the recommendations JSON to the form data
            formData.set('barang', JSON.stringify(recommendations));

            // Add category and filter preferences to the form data
            formData.set('desired_categories', JSON.stringify(desiredCategories));
            formData.set('unwanted_filters', JSON.stringify(unwantedFilters));

            // Send AJAX request to save the data
            const _token = document.querySelector('input[name="_token"]').value;

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': _token,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Capture the parcel ID from the server response
                        const parcelId = data.parcel_id;

                        // Pass both recommendations and parcel ID to displayRecommendations
                        displayRecommendations(recommendations, parcelId);
                    } else {
                        alert('Terjadi Kesalahan: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan data');
                });

        } catch (error) {
            console.error('Error processing recommendations:', error);
            alert(error.message || "Terjadi kesalahan saat memproses rekomendasi");
        } finally {
            // Reset button state
            this.disabled = false;
            this.innerHTML = 'Proses';
        }
    }, 100);
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
            const container = document.getElementById('selected-items');
            container.innerHTML = '';
            let totalBerat = 0;
            let totalPrice = 0;

            selectedItems.forEach((item, index) => {
                totalBerat += item.berat;
                totalPrice += item.price;
                container.innerHTML += `
            <tr>
                <td>${item.name}</td>
                <td>${item.berat} Gram</td>
                <td>${item.price.toLocaleString()}</td>
                <td>${item.seller} (${item.sellerCity})</td>
                <td><button class="btn btn-danger btn-sm remove-item-button" data-index="${index}">Hapus</button></td>
            </tr>
        `;
            });

            document.getElementById('total-berat').innerText = totalBerat + ' Gram';
            document.getElementById('total-price').innerText = 'Rp. ' + totalPrice.toLocaleString();

            // Pasang event listener untuk tombol hapus
            document.querySelectorAll('.remove-item-button').forEach(button => {
                button.addEventListener('click', function() {
                    const index = this.getAttribute('data-index');
                    selectedItems.splice(index, 1); // Hapus item dari selectedItems
                    updateSelectedItems(); // Perbarui tampilan
                });
            });
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
