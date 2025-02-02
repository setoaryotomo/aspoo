@extends('portal_layout.templates')
@section('content')
    <style>
        .content {
            margin: 60px;
        }

        .chip {
            display: inline-block;
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border-radius: 15px;
            margin: 2px;
        }

        .chip .close-icon {
            margin-left: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .spinner-border {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            border: 0.2em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: spinner-border .75s linear infinite;
        }

        @keyframes spinner-border {
            to {
                transform: rotate(360deg);
            }
        }

        .select-parcel {
            transition: all 0.3s ease;
        }

        .select-parcel.selected {
            border: 2px solid #28a745;
            font-weight: bold;
        }
    </style>
    <div class="title">
        <h4 class="text-center">Pesan Parcel Sesuai Keinginanmu Disini !!!</h4>
    </div>

    <div class="content text-center">
        <form id="parcel-form" action="{{ route('parcel.store') }}" method="POST">
            @csrf

            <h4 class="text-center">Alamat Pengiriman</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="provinsi" class="form-label">Provinsi</label>
                    <select name="provinsi" id="provinsi" class="form-control" data-dependent="provinsi">
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
                    <select name="kota" id="kota" class="form-control dynamic" data-dependent="kota">
                        <option value="{{ $data->kotaModel->id }}">
                            {{ $data->kota ? $data->kotaModel->name : 'Pilih Kota / Kabupaten' }}
                        </option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="kecamatan" class="form-label">Kecamatan</label>
                    <select name="kecamatan" id="kecamatan" class="form-control dynamic" data-dependent="kecamatan">
                        <option value="{{ $data->kecamatanModel->id }}">
                            {{ $data->kecamatan ? $data->kecamatanModel->name : 'Pilih Kecamatan' }}
                        </option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="kelurahan" class="form-label">Kelurahan</label>
                    <select name="kelurahan" id="kelurahan" class="form-control dynamic" data-dependent="kelurahan">
                        <option value="{{ $data->kelurahanModel->id }}">
                            {{ $data->kelurahan ? $data->kelurahanModel->name : 'Pilih Kelurahan' }}
                        </option>
                    </select>
                </div>

                <div class="col-12 mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" rows="3" placeholder="Alamat lengkap">{{ $data->alamat }}</textarea>
                </div>
            </div>

            <div class="cart-box table-responsive text-center">
                <table id="table" class="table">
                    <thead>
                        <tr>
                            <th scope="col">Harga Yang Diinginkan</th>
                            <th scope="col">Berat Yang Diinginkan</th>
                            <th scope="col">Total Item Yang Diinginkan (Optional)</th>
                            {{-- <th scope="col">Item Yang Harus Ada</th> --}}
                            <th scope="col">Tanggal Dibutuhkan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="number" id="desired-price" name="harga" class="form-control"
                                    placeholder="Masukkan harga" required></td>

                            <td><input type="number" id="desired-weight" name="berat" class="form-control"
                                    placeholder="Masukkan berat" required></td>
                            <td><input type="number" id="total-items" name="total_items" class="form-control"
                                    placeholder="Masukkan total item"></td>
                            {{-- <td><input type="number" name="harga" class="form-control" placeholder="Masukkan harga" required></td> --}}
                            {{-- <td><input type="text" name="barang" class="form-control" placeholder="Masukkan berat" required></td> --}}
                            {{-- <td><input type="text" name="barang" class="form-control" placeholder="Masukkan item" required></td> --}}
                            <td><input type="date" name="tanggal" class="form-control" required></td>
                            <input type="text" name="barang" class="form-control" placeholder="Masukkan barang" required
                                style="display: none">
                            <input type="text" name="alamat" class="form-control" placeholder="Masukkan alamat" required
                                style="display: none">
                        </tr>
                    </tbody>
                </table>
            </div>

            <input type="hidden" name="user_id" value="{{ $auth->id }}">
            <div class="payment-box float-right">
                <button type="submit" id="submit-parcel" class="btn btn-primary btn-block"
                    style="display: none">Pesan</button>
                <button type="submit" id="save-recommendations" class="btn btn-primary btn-block mt-2">PESAN</button>
            </div>

        </form>

        <br>
        <br>
        <br><br>

        <h5>Barang Tersedia</h5>
        <input type="text" id="search-bar" class="form-control" placeholder="Cari barang..."
            onkeydown="handleKeyDown(event)">
        <div class="chips-container mt-2"></div> <!-- Container untuk chips -->
        <button id="process-button" class="btn btn-success mt-2">Proses</button> <!-- Tombol Proses -->
        <br><br>


        <div class="row" id="barang-list">
            @foreach ($card['barang'] as $barang)
                @if ($barang->berat > 0)
                    <div class="col-md-3 barang-item" data-name="{{ $barang->nama_barang }}">
                        <div class="card mb-4">
                            @if (strpos($barang->thumbnail, 'https://') !== false)
                                <img src="{{ URL::asset($barang->thumbnail) }}" class="card-img-top"
                                    alt="Nama Produk 1">
                            @else
                                <img src="{{ URL::asset($barang->thumbnail_readable) }}" class="card-img-top"
                                    alt="Nama Produk 1">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $barang->nama_barang }}</h5>
                                <p class="card-text">Berat: {{ $barang->berat }} Gram</p>
                                <p class="card-text">Penjual: {{ $barang->user->nama }}</p>
                                <p class="card-text">{{ $barang->user->detail->kotaModel->name }}</p>
                                <p class="card-text">{{ number_format($barang->harga_user, 2) }}</p>
                                <button class="btn btn-primary btn-sm add-item-button" data-id="{{ $barang->id }}"
                                    data-name="{{ $barang->nama_barang }}" data-price="{{ $barang->harga_user }}"
                                    data-berat="{{ $barang->berat }}" style="display: none">+</button>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <br><br>

        {{-- <h5 class="text-center">Barang Yang Diinginkan</h5> --}}
        <table class="table" style="display: none">
            {{-- <table class="table"> --}}
            <thead>
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
                    <td colspan="1" class="text-right"><strong>Total :</strong></td>
                    <td id="total-berat">0</td>
                    {{-- <td colspan="" class="text-right"><strong>Total Harga:</strong></td> --}}
                    <td id="total-price">Rp. 0</td>
                </tr>
            </tfoot>
        </table>

        <br>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.barang-item').forEach(item => {
                item.style.display = 'none'; // Sembunyikan semua barang
            });
        });
        document.getElementById('search-bar').addEventListener('input', function() {
            const keyword = this.value.toLowerCase();
            document.querySelectorAll('.barang-item').forEach(item => {
                const itemName = item.getAttribute('data-name').toLowerCase();
                item.style.display = itemName.includes(keyword) ? '' : 'none';


            });
        });
        // Global variables
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

        // Function to get all items matching keywords
        function getAllMatchingItems(items, keywords) {
            return items.filter(item =>
                keywords.some(keyword => item.name.toLowerCase().includes(keyword.toLowerCase()))
            );
        }

        // Function to group items by keyword
        function groupItemsByKeyword(items, keywords) {
            const groups = {};
            keywords.forEach(keyword => {
                groups[keyword] = items.filter(item =>
                    item.name.toLowerCase().includes(keyword.toLowerCase())
                );
            });
            return groups;
        }


        // Modified function to generate random combinations
        // Modify the generateRandomCombinations function to prioritize local sellers

        function generateRandomCombinations(items, maxPrice, maxWeight, keywords, desiredTotalItems) {
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

            // Prioritize local items first
            const itemGroups = groupItemsByKeyword(localItems.length > 0 ? localItems : items, keywords);
            let combinations = [];
            let usedItems = new Set();

            // Try to generate combinations
            for (let attempt = 0; attempt < 20 && combinations.length < MAX_RECOMMENDATIONS; attempt++) {
                let combination = {
                    items: [],
                    totalPrice: 0,
                    totalWeight: 0,
                    isLocalSeller: false // New flag to track if combination uses local sellers
                };

                // First, try to include at least one item for each keyword
                for (let keyword of keywords) {
                    let availableItems = itemGroups[keyword].filter(item => !usedItems.has(item.id));

                    // If no unused items available, reset used items for this keyword
                    if (availableItems.length === 0) {
                        availableItems = itemGroups[keyword];
                    }

                    // Shuffle available items
                    availableItems = shuffleArray([...availableItems]);

                    // Try to add an item for this keyword
                    for (let item of availableItems) {
                        if (combination.totalPrice + item.price <= maxPrice &&
                            combination.totalWeight + item.berat <= maxWeight) {
                            combination.items.push(item);
                            combination.totalPrice += item.price;
                            combination.totalWeight += item.berat;

                            // Check if this is a local seller
                            if (item.seller.toLowerCase().includes(shippingCity)) {
                                combination.isLocalSeller = true;
                            }

                            usedItems.add(item.id);
                            break;
                        }
                    }
                }

                // If we couldn't add items for all keywords, skip this combination
                if (combination.items.length < keywords.length) {
                    continue;
                }

                // Get remaining available items that match any keyword
                let remainingItems = getAllMatchingItems(
                    combination.isLocalSeller ? localItems : items,
                    keywords
                ).filter(item => !combination.items.some(selected => selected.id === item.id));

                // Shuffle remaining items
                remainingItems = shuffleArray(remainingItems);

                // If desiredTotalItems is specified, try to reach that number
                // Otherwise, add items until we can't add more within constraints
                while ((!desiredTotalItems || combination.items.length < desiredTotalItems) &&
                    remainingItems.length > 0) {
                    let added = false;
                    for (let item of remainingItems) {
                        if (combination.totalPrice + item.price <= maxPrice &&
                            combination.totalWeight + item.berat <= maxWeight &&
                            !combination.items.some(selected => selected.id === item.id)) {
                            combination.items.push(item);
                            combination.totalPrice += item.price;
                            combination.totalWeight += item.berat;

                            // Update local seller flag if needed
                            if (item.seller.toLowerCase().includes(shippingCity)) {
                                combination.isLocalSeller = true;
                            }

                            added = true;
                            break;
                        }
                    }

                    // If no more items can be added, break the loop
                    if (!added) break;
                }

                // Modify score calculation to heavily favor local seller combinations
                combination.score = calculateCombinationScore(combination, keywords, maxPrice, maxWeight,
                    desiredTotalItems);

                // Add a bonus for local seller combinations
                if (combination.isLocalSeller) {
                    combination.score *= 1.5; // Give 50% score boost to local seller combinations
                }

                // Validate combination - if desiredTotalItems is specified, check against it
                const isValidCombination = (!desiredTotalItems || combination.items.length === desiredTotalItems) &&
                    combination.totalPrice <= maxPrice &&
                    combination.totalWeight <= maxWeight;

                if (isValidCombination) {
                    combinations.push(combination);
                }
            }

            // If no combinations found with local sellers, fall back to all items
            if (combinations.length === 0) {
                // Rerun the generation with all items
                return generateRandomCombinations(items, maxPrice, maxWeight, keywords, desiredTotalItems);
            }

            return combinations
                .sort((a, b) => b.score - a.score)
                .slice(0, MAX_RECOMMENDATIONS);
        }


        // Modified function to calculate combination score
        function calculateCombinationScore(combination, keywords, maxPrice, maxWeight, desiredTotalItems) {
            const priceRatio = combination.totalPrice / maxPrice;
            const weightRatio = combination.totalWeight / maxWeight;

            // Count how many keywords are represented
            const keywordCoverage = keywords.filter(keyword =>
                combination.items.some(item =>
                    item.name.toLowerCase().includes(keyword.toLowerCase())
                )
            ).length / keywords.length;

            // Calculate variety score (how many different items)
            const varietyScore = Math.min(combination.items.length / (keywords.length * 2), 1);

            // Only include itemCountPenalty if desiredTotalItems is specified
            let score = (keywordCoverage * 0.35) +
                (varietyScore * 0.25) +
                ((1 - priceRatio) * 0.2) +
                ((1 - weightRatio) * 0.2);

            // Add item count penalty only if desiredTotalItems is specified
            if (desiredTotalItems) {
                const itemCountPenalty = 1 - Math.abs(combination.items.length - desiredTotalItems) / (desiredTotalItems *
                    2);
                score = (score * 0.9) + (itemCountPenalty * 0.1);
            }

            return score;
        }



        // Modified getBestRecommendations function
        function getBestRecommendations(items, maxPrice, maxWeight, keywords) {
            // Validasi input
            if (!keywords.length) {
                throw new Error("Mohon masukkan kata kunci pencarian");
            }

            // Get desired total items
            const desiredTotalItems = parseInt(document.getElementById('total-items').value);

            // Cek apakah ada item yang cocok untuk setiap kata kunci
            const itemGroups = groupItemsByKeyword(items, keywords);
            const missingKeywords = keywords.filter(keyword => !itemGroups[keyword].length);
            if (missingKeywords.length > 0) {
                throw new Error(`Tidak ditemukan produk untuk: ${missingKeywords.join(', ')}`);
            }

            // Generate random combinations
            const combinations = generateRandomCombinations(items, maxPrice, maxWeight, keywords, desiredTotalItems);

            // Jika tidak ada rekomendasi, longgarkan batasan
            if (combinations.length === 0) {
                // Coba generate kombinasi dengan rentang total item yang lebih luas
                const itemCountVariations = [-2, -1, 0, 1, 2];
                for (let itemCountOffset of itemCountVariations) {
                    const relaxedCombinations = generateRandomCombinations(
                        items,
                        maxPrice * 1.2, // Izinkan overflow harga yang lebih besar
                        maxWeight * 1.2, // Izinkan overflow berat yang lebih besar
                        keywords,
                        desiredTotalItems + itemCountOffset
                    );

                    if (relaxedCombinations.length > 0) {
                        return relaxedCombinations.slice(0, MAX_RECOMMENDATIONS);
                    }
                }

                // Jika masih tidak ada kombinasi, lemparkan error
                throw new Error("Tidak dapat menemukan kombinasi yang sesuai. Coba ubah kriteria pencarian.");
            }

            // Urutkan kombinasi berdasarkan skor dan kembalikan top rekomendasi
            return combinations
                .sort((a, b) => b.score - a.score)
                .slice(0, MAX_RECOMMENDATIONS);
        }

        // Modified display recommendations function
        let globalRecommendations = []; // Store recommendations globally

        let parcelId; // Variabel untuk menyimpan parcel_id

        function displayRecommendations(recommendations, id) {
            parcelId = id; // Simpan parcel_id yang diterima dari proses
            globalRecommendations = recommendations;
            const container = document.getElementById('barang-list');
            container.innerHTML = '';

            const desiredPrice = parseFloat(document.getElementById('desired-price').value);
            const desiredWeight = parseFloat(document.getElementById('desired-weight').value);
            const desiredTotalItems = document.getElementById('total-items').value ?
                parseInt(document.getElementById('total-items').value) : null;

            recommendations.forEach((rec, index) => {
                const itemsByKeyword = {};
                rec.items.forEach(item => {
                    const matchingKeywords = getChipsKeywords().filter(keyword =>
                        item.name.toLowerCase().includes(keyword.toLowerCase())
                    );
                    matchingKeywords.forEach(keyword => {
                        if (!itemsByKeyword[keyword]) {
                            itemsByKeyword[keyword] = [];
                        }
                        itemsByKeyword[keyword].push(item);
                    });
                });

                const priceDifference = rec.totalPrice - desiredPrice;
                const weightDifference = rec.totalWeight - desiredWeight;
                const totalItems = rec.items.length;

                const parcelHtml = `
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Rekomendasi Parcel ${index + 1}</h5>
                </div>
                <div class="card-body">
                    <h6>Total Item: ${totalItems}</h6>
                    <h6>Total Harga: Rp ${rec.totalPrice.toLocaleString()} | Selisih Harga: Rp ${priceDifference.toLocaleString()}</h6>
                    <h6>Total Berat: ${rec.totalWeight} Gram | Selisih Berat: ${weightDifference} Gram</h6>
                    <hr>
                    <h6>Isi Parcel:</h6>
                    ${Object.entries(itemsByKeyword).map(([keyword, items]) => `
                                                <div class="mb-2">
                                                    <strong>Item: ${keyword}</strong><br>
                                                    ${items.map(item => `
                                                        <div class="d-flex align-items-center mb-2">
                                                            <img src="${item.thumbnail}" alt="${item.name}" style="width: 200px; height: 200px; object-fit: cover; margin-right: 10px;display: none;">
                                                            <div>
                                                                <b>${item.name}</b> <br>
                                                                ${item.berat}g - Rp ${item.price.toLocaleString()} <br>
                                                                Penjual: ${item.seller} <br>
                                                                (${item.sellerCity})
                                                            </div>
                                                        </div>
                                                    `).join('')}
                                                </div>
                                            `).join('')}
                    <button class="btn btn-primary select-parcel" data-index="${index}">Pilih Parcel Ini</button>
                </div>
            </div>
        </div>
    `;

                container.innerHTML += parcelHtml;
            });

            // Add event listeners for parcel selection
            // Modify the event listeners for parcel selection
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

            // Display JSON of recommendations
            console.log('Rekomendasi Parcel:', JSON.stringify(recommendations, null, 2));
            // alert('Rekomendasi Parcel:\n' + JSON.stringify(recommendations, null, 2));
        }

        // Modified process button event listener
        document.getElementById("process-button").addEventListener("click", function() {
            const desiredPrice = parseFloat(document.getElementById('desired-price').value);
            const desiredWeight = parseFloat(document.getElementById('desired-weight').value);
            const desiredTotalItems = document.getElementById('total-items').value ?
                parseInt(document.getElementById('total-items').value) : null;
            const keywords = getChipsKeywords();

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

            if (keywords.length === 0) {
                alert("Silakan buat minimal satu chip pencarian terlebih dahulu");
                return;
            }

            // Show loading state
            this.disabled = true;
            this.innerHTML =
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';

            // Get all available items
            const availableItems = Array.from(document.querySelectorAll('.barang-item')).map(item => {
                const button = item.querySelector('.add-item-button');
                const sellerElement = item.querySelector('.card-text:nth-child(3)');
                const cityElement = item.querySelector('.card-text:nth-child(4)');
                const thumbnailElement = item.querySelector('.card-img-top');

                const seller = sellerElement ? sellerElement.textContent.replace('Penjual: ', '').trim() :
                    'Unknown Seller';
                const sellerCity = cityElement ? cityElement.textContent.trim() : 'Unknown City';

                // Get the correct thumbnail URL
                const thumbnailSrc = thumbnailElement.src;

                return {
                    id: button.getAttribute('data-id'),
                    name: button.getAttribute('data-name'),
                    price: parseFloat(button.getAttribute('data-price')),
                    berat: parseFloat(button.getAttribute('data-berat')),
                    seller: seller,
                    sellerCity: sellerCity,
                    thumbnail: thumbnailSrc
                };
            });

            // Use setTimeout to prevent UI blocking
            setTimeout(() => {
                try {
                    const recommendations = getBestRecommendations(availableItems, desiredPrice,
                        desiredWeight, keywords);
                    displayRecommendations(recommendations);

                    // Get the form data
                    const form = document.getElementById('parcel-form');
                    const formData = new FormData(form);

                    // Add the recommendations JSON to the form data
                    formData.set('barang', JSON.stringify(recommendations));

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
                                const parcelId = data
                                    .parcel_id; // Assuming the server returns parcel_id

                                // Pass both recommendations and parcel ID to displayRecommendations
                                displayRecommendations(recommendations, parcelId);

                                // alert('Data berhasil disimpan!');


                            } else {
                                // alert('Gagal menyimpan data: ' + (data.message || 'Unknown error'));
                                alert('Terjadi Kesalahan: ' + (data.message || 'Unknown error'));
                            }
                        })
                    // .catch(error => {
                    //     console.error('Error:', error);
                    //     alert('Terjadi kesalahan saat menyimpan data');
                    // });

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

            // Mengonversi selectedItems ke JSON
            const selectedItemsJson = JSON.stringify(selectedItems);

            // Mengirim data ke server
            fetch(`/permintaan-parcel/save-selected-items/${parcelId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Pastikan CSRF token ada
                    },
                    body: JSON.stringify({
                        items: selectedItems
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // window.location.href = data.redirect;
                        // window.location.href = '{{ route('paymentparcel') }}';

                        // alert('Rekomendasi parcel berhasil disimpan!');
                        alert('Success');
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
