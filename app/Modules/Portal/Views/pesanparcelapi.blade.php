@extends('portal_layout.templates')

@section('content')
    <style>
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
            text-align: center;
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

        .section-card {
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 2rem;
            margin-bottom: 2rem;
        }

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

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--dark-color);
            text-align: center;
        }

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

        .badge-success {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            margin: 2px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
        }

        .badge-danger {
            background-color: #dc3545;
            color: white;
            padding: 5px 10px;
            margin: 2px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
        }

        .close-icon {
            margin-left: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .filter-section .card-body {
            max-height: 150px;
            overflow-y: auto;
        }

        .category-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
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

        .recommendation-card {
            height: 100%;
            border: 2px solid transparent;
            transition: all 0.3s;
        }

        .recommendation-card:hover {
            transform: scale(1.02);
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

        .item-detail {
            padding: 0.5rem;
            background-color: #f8f9fa;
            border-radius: var(--radius);
            margin: 0.5rem 0;
        }

        .selected-filters-container {
            border: 1px solid #dee2e6;
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: var(--radius);
        }

        .filter-search {
            width: 100%;
            margin-bottom: 10px;
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

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 767.98px) {
            .section-card {
                padding: 1rem;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .section-title {
                font-size: 1.25rem;
            }

            .btn {
                padding: 0.5rem 1rem;
            }
        }
    </style>

    <div class="preload preload-container">
        <div class="preload-logo">
            <div class="spinner"></div>
        </div>
    </div>

    <div class="container py-5">
        <h1 class="page-title">Pesan Parcel Sesuai Keinginanmu</h1>

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
                            <option value="{{ $data->provinsiModel->id }}">{{ $data->provinsi ? $data->provinsiModel->name : 'Pilih Provinsi' }}</option>
                            @foreach ($asal['provinsi'] as $provinsi)
                                <option value="{{ $provinsi->id }}">{{ $provinsi->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="kota" class="form-label">Kota / Kabupaten</label>
                        <select name="kota" id="kota" class="form-select dynamic" data-dependent="kota">
                            <option value="{{ $data->kotaModel->id }}">{{ $data->kota ? $data->kotaModel->name : 'Pilih Kota / Kabupaten' }}</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="kecamatan" class="form-label">Kecamatan</label>
                        <select name="kecamatan" id="kecamatan" class="form-select dynamic" data-dependent="kecamatan">
                            <option value="{{ $data->kecamatanModel->id }}">{{ $data->kecamatan ? $data->kecamatanModel->name : 'Pilih Kecamatan' }}</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="kelurahan" class="form-label">Kelurahan</label>
                        <select name="kelurahan" id="kelurahan" class="form-select dynamic" data-dependent="kelurahan">
                            <option value="{{ $data->kelurahanModel->id }}">{{ $data->kelurahan ? $data->kelurahanModel->name : 'Pilih Kelurahan' }}</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="alamat" class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap pengiriman">{{ $data->alamat }}</textarea>
                    </div>
                </div>

                <!-- Parcel Details Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h2 class="section-title">Detail Parcel</h2>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <label for="desired-price" class="form-label">Harga yang Diinginkan (Rp)</label>
                        <input type="number" id="desired-price" name="harga" class="form-control" placeholder="Masukkan harga" required>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <label for="desired-weight" class="form-label">Berat yang Diinginkan (Kilogram)</label>
                        <input type="number" id="desired-weight" name="berat" class="form-control" placeholder="Masukkan berat" required step="0.01" min="0">
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <label for="total-items" class="form-label">Total Item (Opsional)</label>
                        <input type="number" id="total-items" name="total_items" class="form-control" placeholder="Jumlah item dalam parcel">
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <label for="parcel-quantity" class="form-label">Jumlah Parcel (Opsional)</label>
                        <input type="number" id="parcel-quantity" name="parcel_quantity" class="form-control" placeholder="Jumlah parcel" min="1" value="1">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal" class="form-label">Tanggal Dibutuhkan</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                    </div>
                    <input type="hidden" name="barang" id="selected-items-input" required>
                    <input type="hidden" name="user_id" value="{{ $auth->id }}">
                </div>

                <!-- Filter Categories Section -->
                <div class="filter-section">
                    <div class="row mb-4">
                        <div class="col-12">
                            <h2 class="section-title">Filter Barang</h2>
                        </div>

                        @php
                            $filteredBarang = $card['barang']->filter(function ($item) {
                                return $item->berat > 0 &&
                                    !empty($item->kategori_umum) &&
                                    !empty($item->bahan_dasar) &&
                                    !empty($item->basah_kering) &&
                                    !empty($item->produsen) &&
                                    !empty($item->rasa);
                            });

                            $uniqueCategories = $filteredBarang->pluck('kategori_umum')->filter()->unique()->sort();
                            $uniqueBahan = $filteredBarang->pluck('bahan_dasar')->filter()->unique()->sort();
                            $uniqueBasahKering = $filteredBarang->pluck('basah_kering')->filter()->unique()->sort();
                            $uniqueRasa = $filteredBarang->pluck('rasa')->filter()->unique()->sort();
                            $uniqueProdusen = $filteredBarang->pluck('produsen')->filter()->unique()->sort();
                            $uniqueNamaProduk = $filteredBarang->pluck('nama_barang')->filter()->unique()->sort();
                        @endphp

                        <!-- Desired Filters -->
                        <div class="col-md-6">
                            @foreach ([
                                'categories' => ['title' => 'Kategori yang Diinginkan', 'type' => 'kategori_umum', 'id' => 'desired-categories', 'class' => 'desired-category'],
                                'bahan' => ['title' => 'Bahan Dasar yang Diinginkan', 'type' => 'bahan_dasar', 'id' => 'desired-bahan', 'class' => 'desired-filter'],
                                'basah_kering' => ['title' => 'Basah/Kering yang Diinginkan', 'type' => 'basah_kering', 'id' => 'desired-basah-kering', 'class' => 'desired-filter'],
                                'rasa' => ['title' => 'Rasa yang Diinginkan', 'type' => 'rasa', 'id' => 'desired-rasa', 'class' => 'desired-filter'],
                                'produsen' => ['title' => 'Produsen yang Diinginkan', 'type' => 'produsen', 'id' => 'desired-produsen', 'class' => 'desired-filter'],
                                'nama_produk' => ['title' => 'Nama Produk yang Diinginkan', 'type' => 'nama_barang', 'id' => 'desired-nama-produk', 'class' => 'desired-filter']
                            ] as $key => $filter)
                                <div class="col-12 mb-3">
                                    <div class="card">
                                        <div class="card-header bg-success text-white text-center">
                                            <h6 class="mb-0">{{ $filter['title'] }}</h6>
                                        </div>
                                        <div class="card-body">
                                            <div id="{{ $filter['id'] }}" class="category-container">
                                                @foreach ($uniqueData[$key] as $item)
                                                    <div class="category-option">
                                                        <input class="form-check-input {{ $filter['class'] }}" type="checkbox"
                                                               value="{{ $item }}"
                                                               id="{{ $filter['id'] }}-{{ Str::slug($item) }}"
                                                               data-type="{{ $filter['type'] }}">
                                                        <label class="form-check-label" for="{{ $filter['id'] }}-{{ Str::slug($item) }}">{{ $item }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Unwanted Filters -->
                        <div class="col-md-6">
                            @foreach ([
                                'categories' => ['title' => 'Kategori yang Tidak Diinginkan', 'type' => 'kategori_umum', 'id' => 'unwanted-categories'],
                                'bahan' => ['title' => 'Bahan Dasar yang Tidak Diinginkan', 'type' => 'bahan_dasar', 'id' => 'unwanted-bahan'],
                                'basah_kering' => ['title' => 'Basah/Kering yang Tidak Diinginkan', 'type' => 'basah_kering', 'id' => 'unwanted-basah-kering'],
                                'rasa' => ['title' => 'Rasa yang Tidak Diinginkan', 'type' => 'rasa', 'id' => 'unwanted-rasa'],
                                'produsen' => ['title' => 'Produsen yang Tidak Diinginkan', 'type' => 'produsen', 'id' => 'unwanted-produsen'],
                                'nama_produk' => ['title' => 'Nama Produk yang Tidak Diinginkan', 'type' => 'nama_barang', 'id' => 'unwanted-nama-produk']
                            ] as $key => $filter)
                                <div class="col-12 mb-3">
                                    <div class="card filter-card">
                                        <div class="card-header bg-danger text-white text-center">
                                            <h6 class="mb-0">{{ $filter['title'] }}</h6>
                                        </div>
                                        <div class="card-body">
                                            <div id="{{ $filter['id'] }}" class="category-container">
                                                @foreach ($uniqueData[$key] as $item)
                                                    <div class="category-option">
                                                        <input class="form-check-input unwanted-filter" type="checkbox"
                                                               value="{{ $item }}"
                                                               id="{{ $filter['id'] }}-{{ Str::slug($item) }}"
                                                               data-type="{{ $filter['type'] }}">
                                                        <label class="form-check-label" for="{{ $filter['id'] }}-{{ Str::slug($item) }}">{{ $item }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="selected-filters-container mb-3">
                        <h6 class="font-weight-bold">Filter yang Dipilih:</h6>
                        <div id="selected-filters-display" class="d-flex flex-wrap"></div>
                    </div>

                    <div class="text-center mb-5">
                        <button type="button" id="process-button" class="btn btn-primary btn-lg">
                            <i class="fas fa-magic me-2"></i>Proses
                        </button>
                    </div>
                </div>

                <!-- Recommendations Section -->
                <div class="row recommendations-container" id="barang-list"></div>

                <div class="text-center">
                    <button type="submit" id="save-recommendations" class="btn btn-primary mt-2 mb-4" style="width: 100px;">PESAN</button>
                </div>
            </form>
        </div>

        <!-- Selected Items Table -->
        <div class="section-card" id="selected-items-table" style="display: none">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nama Produk</th>
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

    <script>
        $(document).ready(function () {
            $('.preload').fadeOut(500);
            let globalRecommendations = [];
            let parcelId;
            const barangData = @json($card['barang']);

            function updateSelectedFilters() {
                const $display = $('#selected-filters-display').empty();
                $('.desired-filter:checked, .desired-category:checked').each(function () {
                    const value = $(this).val();
                    const type = $(this).data('type');
                    const label = $(this).next('label').text().trim();
                    $display.append(`
                        <span class="badge-success">
                            ${label} <span class="close-icon" data-value="${value}" data-type="${type}">×</span>
                        </span>
                    `);
                });
                $('.unwanted-filter:checked').each(function () {
                    const value = $(this).val();
                    const type = $(this).data('type');
                    const label = $(this).next('label').text().trim();
                    $display.append(`
                        <span class="badge-danger">
                            ${label} <span class="close-icon" data-value="${value}" data-type="${type}">×</span>
                        </span>
                    `);
                });
                $('.close-icon').on('click', function () {
                    const { value, type } = $(this).data();
                    $(`input[data-type="${type}"][value="${value}"]`).prop('checked', false);
                    updateSelectedFilters();
                });
            }

            $('.desired-filter, .desired-category, .unwanted-filter').on('change', updateSelectedFilters);

            $('.desired-category, .desired-filter').on('change', function () {
                if (this.checked) {
                    const { type, value } = this.dataset;
                    $(`.unwanted-filter[data-type="${type}"][value="${value}"]`).prop('checked', false);
                    updateSelectedFilters();
                }
            });

            $('.unwanted-filter').on('change', function () {
                if (this.checked) {
                    const { type, value } = this.dataset;
                    const selector = type === 'kategori_umum' ? `.desired-category[value="${value}"]` : `.desired-filter[data-type="${type}"][value="${value}"]`;
                    $(selector).prop('checked', false);
                    updateSelectedFilters();
                }
            });

            const filterSections = [
                '#desired-categories', '#desired-bahan', '#desired-basah-kering', '#desired-rasa',
                '#desired-produsen', '#desired-nama-produk', '#unwanted-categories', '#unwanted-bahan',
                '#unwanted-basah-kering', '#unwanted-rasa', '#unwanted-produsen', '#unwanted-nama-produk'
            ];

            filterSections.forEach(sectionId => {
                const $section = $(sectionId);
                if ($section.length) {
                    const $parentCard = $section.closest('.card-body');
                    const $searchBox = $('<input type="text" placeholder="Cari..." class="form-control form-control-sm mb-2 filter-search">');
                    $searchBox.on('input', function () {
                        const searchValue = this.value.toLowerCase();
                        $section.find('.category-option').each(function () {
                            const label = $(this).find('label').text().toLowerCase();
                            $(this).toggle(label.includes(searchValue));
                        });
                    });
                    $parentCard.prepend($searchBox);
                }
            });

            $('#process-button').on('click', async function() {
    const $button = $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Memproses...');
    const budget = parseFloat($('#desired-price').val()) || 0;
    const weight_capacityKg = parseFloat($('#desired-weight').val()) || 0;
    const weight_capacity = weight_capacityKg * 1000;
    const desired_total_items = parseInt($('#total-items').val()) || null;
    const parcel_quantity = parseInt($('#parcel-quantity').val()) || 1;

    const preferred_categories = $('.desired-category:checked').map(function() {
        return $(this).val();
    }).get();

    const desired_filters = {
        kategori_umum: preferred_categories,
        bahan_dasar: $('.desired-filter[data-type="bahan_dasar"]:checked').map(function() { return $(this).val(); }).get(),
        basah_kering: $('.desired-filter[data-type="basah_kering"]:checked').map(function() { return $(this).val(); }).get(),
        rasa: $('.desired-filter[data-type="rasa"]:checked').map(function() { return $(this).val(); }).get(),
        produsen: $('.desired-filter[data-type="produsen"]:checked').map(function() { return $(this).val(); }).get(),
        nama_barang: $('.desired-filter[data-type="nama_barang"]:checked').map(function() { return $(this).val(); }).get(),
    };

    const unwanted_filters = {
        kategori_umum: $('.unwanted-filter[data-type="kategori_umum"]:checked').map(function() { return $(this).val(); }).get(),
        bahan_dasar: $('.unwanted-filter[data-type="bahan_dasar"]:checked').map(function() { return $(this).val(); }).get(),
        basah_kering: $('.unwanted-filter[data-type="basah_kering"]:checked').map(function() { return $(this).val(); }).get(),
        rasa: $('.unwanted-filter[data-type="rasa"]:checked').map(function() { return $(this).val(); }).get(),
        produsen: $('.unwanted-filter[data-type="produsen"]:checked').map(function() { return $(this).val(); }).get(),
        nama_barang: $('.unwanted-filter[data-type="nama_barang"]:checked').map(function() { return $(this).val(); }).get()
    };

    if (budget <= 0 || weight_capacity <= 0) {
        alert('Harga dan berat harus diisi dengan nilai positif.');
        $button.prop('disabled', false).html('<i class="fas fa-magic me-2"></i>Proses');
        return;
    }

    if (!Object.values(desired_filters).some(arr => arr.length > 0)) {
        alert('Pilih setidaknya satu filter yang diinginkan.');
        $button.prop('disabled', false).html('<i class="fas fa-magic me-2"></i>Proses');
        return;
    }

    const locationDetails = {
        provinsi: { id: $('#provinsi').val(), name: $('#provinsi option:selected').text() },
        kota: { id: $('#kota').val(), name: $('#kota option:selected').text() },
        kecamatan: { id: $('#kecamatan').val(), name: $('#kecamatan option:selected').text() },
        kelurahan: { id: $('#kelurahan').val(), name: $('#kelurahan option:selected').text() },
        alamat_lengkap: $('#alamat').val()
    };

    const payload = {
        budget,
        weight_capacity,
        desired_total_items,
        preferred_categories,
        category_weight: 0.15,
        desired_filters,
        unwanted_filters,
        location: locationDetails
    };

    try {
        const response = await $.ajax({
            url: 'http://127.0.0.1:5001/api/recommend',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(payload)
        });

        if (response.status === 'success') {
            const formattedRecommendations = response.recommendations.map(rec => ({
                items: rec.items.map(item => ({
                    id: item.id,
                    name: item.name,
                    price: item.price,
                    berat: item.weight,
                    seller: item.user?.nama || 'Unknown',
                    sellerCity: item.user?.detail?.kotaModel?.name || 'Unknown',
                    thumbnail: item.thumbnail || '',
                    category: item.category,
                    bahan_dasar: item.bahan_dasar || 'Unknown',
                    basah_kering: item.basah_kering || 'Unknown',
                    rasa: item.rasa || 'Unknown',
                    produsen: item.store || 'Unknown',
                    isPriority: item.is_priority || false,
                    matchesUserFilters: {
                        kategori_umum: desired_filters.kategori_umum.includes(item.category),
                        bahan_dasar: desired_filters.bahan_dasar.includes(item.bahan_dasar),
                        basah_kering: desired_filters.basah_kering.includes(item.basah_kering),
                        rasa: desired_filters.rasa.includes(item.rasa),
                        produsen: desired_filters.produsen.includes(item.store),
                        nama_barang: desired_filters.nama_barang.includes(item.name)
                    },
                    matchesAnyUserFilter: Object.values({
                        kategori_umum: desired_filters.kategori_umum.includes(item.category),
                        bahan_dasar: desired_filters.bahan_dasar.includes(item.bahan_dasar),
                        basah_kering: desired_filters.basah_kering.includes(item.basah_kering),
                        rasa: desired_filters.rasa.includes(item.rasa),
                        produsen: desired_filters.produsen.includes(item.store),
                        nama_barang: desired_filters.nama_barang.includes(item.name)
                    }).some(Boolean)
                })),
                totalPrice: rec.summary.total_price,
                totalWeight: rec.summary.total_weight,
                isLocalSeller: rec.summary.is_local_seller || false,
                categoryCounts: rec.summary.category_counts || {},
                priorityCount: rec.summary.priority_count || 0,
                score: rec.summary.fitness_score || 0,
                userFilters: { desiredCategories: preferred_categories, desiredFilters: desired_filters, unwantedFilters: unwanted_filters, desiredPrice: budget, desiredWeight: weight_capacity, desiredTotalItems: desired_total_items }
            }));

            const formData = new FormData($('#parcel-form')[0]);
            formData.set('barang', JSON.stringify(formattedRecommendations));
            formData.set('desired_categories', JSON.stringify(preferred_categories));
            formData.set('desired_filters', JSON.stringify(desired_filters));
            formData.set('unwanted_filters', JSON.stringify(unwanted_filters));
            formData.set('berat', weight_capacity);
            formData.set('alamat', JSON.stringify(locationDetails));

            const saveResponse = await $.ajax({
                url: $('#parcel-form').attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false
            });

            if (saveResponse.success) {
                displayRecommendations(formattedRecommendations, saveResponse.parcel_id);
            } else {
                alert('Terjadi kesalahan saat menyimpan data: ' + (saveResponse.message || 'Unknown error'));
            }
        } else {
            alert(response.error || 'Gagal mendapatkan rekomendasi. Silakan coba sesuaikan filter Anda.');
        }
    } catch (error) {
        alert('Terjadi kesalahan saat menghubungi server rekomendasi: ' + (error.responseJSON?.error || error.message));
    } finally {
        $button.prop('disabled', false).html('<i class="fas fa-magic me-2"></i>Proses');
    }
});

//             function saveToCart1(items, parcelId, parcelQuantity = 1) {
//     const _token = $('input[name="_token"]').val();

//     return $.ajax({
//         url: '/p/save-to-cart-api',
//         method: 'POST',
//         headers: {
//             'X-CSRF-TOKEN': _token
//         },
//         data: JSON.stringify({
//             items: items,
//             parcel_id: parcelId,
//             parcel_quantity: parcelQuantity
//         }),
//         contentType: 'application/json'
//     });
// }

function saveToCartApi(items, parcelId, parcelQuantity = 1) {
    const _token = document.querySelector('input[name="_token"]').value;

    fetch('save-to-cart-api', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': _token
        },
        body: JSON.stringify({
            items: JSON.stringify(items), // Stringify the array
            parcel_id: parcelId,
            parcel_quantity: parcelQuantity
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

$('#save-recommendations').on('click', function(e) {
    e.preventDefault();
    
    const selectedItems = $('#selected-items-input').val();
    let itemsArray;
    try {
        itemsArray = JSON.parse(selectedItems);
        if (!Array.isArray(itemsArray) || itemsArray.length === 0) {
            alert('Pilih setidaknya satu rekomendasi sebelum memesan.');
            return;
        }
    } catch (e) {
        alert('Invalid item data format.');
        return;
    }

    const parcelQuantity = parseInt($('#parcel-quantity').val()) || 1;
    
    $(this).html('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);
    
    saveToCartApi(itemsArray, parcelId, parcelQuantity);
    // Kirim data ke endpoint untuk menyimpan barang ke parcel yang sudah dibuat
    $.ajax({
        url: '/permintaan-parcel/save-selected-items/' + parcelId,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        data: JSON.stringify({
            items: JSON.parse(selectedItems),
            parcel_quantity: parcelQuantity
        }),
        contentType: 'application/json',
        success: function(response) {
            if (response.success) {
                window.location.href = '/p/keranjang';
            } else {
                alert('Gagal menyimpan ke keranjang: ' + (response.message || 'Unknown error'));
            }
        },
        error: function(error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan ke keranjang.');
        },
        complete: function() {
            $('#save-recommendations').html('PESAN').prop('disabled', false);
        }
    });
});

function getSelectedFilters() {
    // Get desired categories
    const desiredCategories = $('.desired-category:checked').map(function() {
        return $(this).val();
    }).get();

    // Get desired filters (bahan_dasar, basah_kering, rasa, produsen, nama_barang)
    const desiredFilters = {
        bahan_dasar: $('.desired-filter[data-type="bahan_dasar"]:checked').map(function() { return $(this).val(); }).get(),
        basah_kering: $('.desired-filter[data-type="basah_kering"]:checked').map(function() { return $(this).val(); }).get(),
        rasa: $('.desired-filter[data-type="rasa"]:checked').map(function() { return $(this).val(); }).get(),
        produsen: $('.desired-filter[data-type="produsen"]:checked').map(function() { return $(this).val(); }).get(),
        nama_barang: $('.desired-filter[data-type="nama_barang"]:checked').map(function() { return $(this).val(); }).get()
    };

    // Get all unwanted filters
    const unwantedFilters = {
        kategori_umum: $('.unwanted-filter[data-type="kategori_umum"]:checked').map(function() { return $(this).val(); }).get(),
        bahan_dasar: $('.unwanted-filter[data-type="bahan_dasar"]:checked').map(function() { return $(this).val(); }).get(),
        basah_kering: $('.unwanted-filter[data-type="basah_kering"]:checked').map(function() { return $(this).val(); }).get(),
        rasa: $('.unwanted-filter[data-type="rasa"]:checked').map(function() { return $(this).val(); }).get(),
        produsen: $('.unwanted-filter[data-type="produsen"]:checked').map(function() { return $(this).val(); }).get(),
        nama_barang: $('.unwanted-filter[data-type="nama_barang"]:checked').map(function() { return $(this).val(); }).get()
    };

    return {
        desiredCategories,
        desiredFilters,
        unwantedFilters
    };
}

            // Replace the displayRecommendations function in pesanparcelapi.blade.php with this:

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
    const desiredWeightKg = parseFloat(document.getElementById('desired-weight').value);
    const desiredWeight = desiredWeightKg * 1000; // Convert to grams for internal use
    const desiredTotalItems = document.getElementById('total-items').value ? 
        parseInt(document.getElementById('total-items').value) : null;
    
    const { desiredCategories, desiredFilters, unwantedFilters } = getSelectedFilters();

    // Show only top 3 recommendations with clear ranking
    const maxDisplay = Math.min(10, sortedRecommendations.length);
    
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
                            <hr>
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

        const parcelHtml = `
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Rekomendasi Parcel #${rankNum}</h5>
                        
                    </div>
                    <div class="card-body">
                        
                        <h7>Total Harga: Rp ${rec.totalPrice.toLocaleString()} (Rp ${desiredPrice.toLocaleString()})</h7><br>
                        <h7>Total Berat: ${rec.totalWeight.toLocaleString()} g (${desiredWeightKg.toFixed(2)} kg)</h7>
                        
                        ${referenceInfo}
                        <hr>
                        <h7>Total Item: ${totalItems} ${desiredTotalItems ? `/ ${desiredTotalItems} diinginkan` : ''}</h7><br>
                        <h6>Isi Parcel:</h6>
                        ${categoryBreakdownHtml}
                        <button class="btn btn-primary select-recommendation" data-index="${i}">
                            Pilih Parcel Ini
                        </button>
                    </div>
                </div>
            </div>
        `;

        container.innerHTML += parcelHtml;
    }


    // Add event listeners for parcel selection
    $('.select-recommendation').on('click', function() {
        const index = $(this).data('index');
        $('.recommendation-card').removeClass('selected');
        $(this).closest('.recommendation-card').addClass('selected');
        updateSelectedItemsTable(globalRecommendations[index]);
        $('#selected-items-input').val(JSON.stringify(globalRecommendations[index].items));
        return false;
    });

    // Log the sorted recommendations for debugging
    console.log('Rekomendasi Parcel (Diurutkan):', JSON.stringify(sortedRecommendations.slice(0, maxDisplay), null, 2));
}

            function updateSelectedItemsTable(recommendation) {
    const $tbody = $('#selected-items').empty();
    let totalBerat = 0;
    let totalPrice = 0;

    recommendation.items.forEach(item => {
        totalBerat += item.berat;
        totalPrice += item.price;
        $tbody.append(`
            <tr>
                <td>${item.name}</td>
                <td>${item.berat}g</td>
                <td>Rp ${item.price.toLocaleString('id-ID')}</td>
                <td>${item.seller}</td>
                <td><button class="btn btn-danger btn-sm remove-item" data-id="${item.id}"><i class="fas fa-trash"></i></button></td>
            </tr>
        `);
    });

    $('#total-berat').text(`${totalBerat}g`);
    $('#total-price').text(`Rp ${totalPrice.toLocaleString('id-ID')}`);
    $('#selected-items-table').show();

    $('.remove-item').on('click', function() {
        const itemId = $(this).data('id');
        const recommendationIndex = $('.recommendation-card.selected').data('index');
        if (recommendationIndex !== undefined) {
            globalRecommendations[recommendationIndex].items = globalRecommendations[recommendationIndex].items.filter(item => item.id !== itemId);
            updateSelectedItemsTable(globalRecommendations[recommendationIndex]);
            $('#selected-items-input').val(JSON.stringify(globalRecommendations[recommendationIndex].items));
        }
    });
}

$('#parcel-form').on('submit', async function(e) {
    e.preventDefault();
    const selectedItems = $('#selected-items-input').val();
    if (!selectedItems || JSON.parse(selectedItems).length === 0) {
        alert('Pilih setidaknya satu rekomendasi sebelum memesan.');
        return;
    }

    try {
        const formData = new FormData(this);
        formData.set('barang', selectedItems);
        formData.set('desired_categories', JSON.stringify($('.desired-category:checked').map(function() { return $(this).val(); }).get()));
        formData.set('desired_filters', JSON.stringify({
            kategori_umum: $('.desired-category:checked').map(function() { return $(this).val(); }).get(),
            bahan_dasar: $('.desired-filter[data-type="bahan_dasar"]:checked').map(function() { return $(this).val(); }).get(),
            basah_kering: $('.desired-filter[data-type="basah_kering"]:checked').map(function() { return $(this).val(); }).get(),
            rasa: $('.desired-filter[data-type="rasa"]:checked').map(function() { return $(this).val(); }).get(),
            produsen: $('.desired-filter[data-type="produsen"]:checked').map(function() { return $(this).val(); }).get(),
            nama_barang: $('.desired-filter[data-type="nama_barang"]:checked').map(function() { return $(this).val(); }).get(),
        }));
        formData.set('unwanted_filters', JSON.stringify({
            kategori_umum: $('.unwanted-filter[data-type="kategori_umum"]:checked').map(function() { return $(this).val(); }).get(),
            bahan_dasar: $('.unwanted-filter[data-type="bahan_dasar"]:checked').map(function() { return $(this).val(); }).get(),
            basah_kering: $('.unwanted-filter[data-type="basah_kering"]:checked').map(function() { return $(this).val(); }).get(),
            rasa: $('.unwanted-filter[data-type="rasa"]:checked').map(function() { return $(this).val(); }).get(),
            produsen: $('.unwanted-filter[data-type="produsen"]:checked').map(function() { return $(this).val(); }).get(),
            nama_barang: $('.unwanted-filter[data-type="nama_barang"]:checked').map(function() { return $(this).val(); }).get(),
        }));
        formData.set('alamat', JSON.stringify({
            provinsi: { id: $('#provinsi').val(), name: $('#provinsi option:selected').text() },
            kota: { id: $('#kota').val(), name: $('#kota option:selected').text() },
            kecamatan: { id: $('#kecamatan').val(), name: $('#kecamatan option:selected').text() },
            kelurahan: { id: $('#kelurahan').val(), name: $('#kelurahan option:selected').text() },
            alamat_lengkap: $('#alamat').val()
        }));

        const response = await $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false
        });

        if (response.success) {
            // alert('Pesanan berhasil dibuat!');
            // window.location.href = '/order-confirmation/' + response.parcel_id;
        } else {
            alert('Terjadi kesalahan saat membuat pesanan: ' + (response.message || 'Unknown error'));
        }
    } catch (error) {
        alert('Terjadi kesalahan saat mengirim pesanan: ' + (error.responseJSON?.error || error.message));
    }
});


            $('#provinsi').on('change', function () {
                const provinsiId = $(this).val();
                if (provinsiId) {
                    $.get(`/api/kota/${provinsiId}`, function (data) {
                        $('#kota').empty().append('<option value="">Pilih Kota / Kabupaten</option>');
                        data.kota.forEach(kota => {
                            $('#kota').append(`<option value="${kota.id}">${kota.name}</option>`);
                        });
                        $('#kecamatanFilter').empty().append('<option value="">Pilih Kecamatan</option>');
                        $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
                    });
                }
            });

            $('#kota').on('change', function () {
                const kotaId = $(this).val();
                if (kotaId) {
                    $.get(`/api/kecamatan/${kotaId}`, function (data) {
                        $('#kecamatan').empty().append('<option value="">Pilih Kecamatan</option>');
                        data.kecamatan.forEach(kecamatan => {
                            $('#kecamatan').append(`<option value="${kecamatan.id}">"${kecamatan.name}</option>`);
                        });
                        $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
                    });
                }
            });

            $('#kecamatan').on('change', function () {
                const kecamatanId = $(this).val();
                if (kecamatanId) {
                    $.get(`/api/kelurahan/${kecamatanId}`, function (data) {
                        $('#kelurahan').empty().append('<option value="">Pilih Kelurahan</option>');
                        data.kelurahan.forEach(kelurahan => {
                            $('#kelurahan').append(`<option value="${kelurahan.id}">${kelurahan.name}</option>`);
                        });
                    });
                }
            });
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