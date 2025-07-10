<?php require '../config.php';
middleware();
$title = 'Penjualan';
?>
<?php $active[5] = 'active' ?>
<?php include('../templates/sidebar.php') ?>
<div class="main-panel">
    <!-- <div class="container-fluid" style="padding-top: 10px;"> -->
        <style>
            /* Replace the existing CSS styles with these updated ones */

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                min-height: 100vh;
                padding: 20px;
            }

            .pos-container {
                display: grid;
                grid-template-columns: 1fr 400px;
                gap: 20px;
                max-width: 1400px;
                margin: 0 auto;
                height: calc(100vh - 40px);
            }

            .left-panel {
                background: white;
                border-radius: 20px;
                padding: 25px;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
                display: flex;
                flex-direction: column;
                overflow: hidden;
                /* Prevent overflow */
            }

            .right-panel {
                background: white;
                border-radius: 20px;
                padding: 25px;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
                display: flex;
                flex-direction: column;
            }

            .header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
                padding-bottom: 15px;
                border-bottom: 2px solid #f0f0f0;
            }

            .promo-banner {
                background: linear-gradient(45deg, #ff6b6b, #ee5a24);
                color: white;
                padding: 10px 20px;
                border-radius: 10px;
                text-align: center;
                margin-bottom: 20px;
                font-weight: 600;
            }

            .categories {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
                gap: 10px;
                margin-bottom: 20px;
            }

            .category-btn {
                padding: 10px 15px;
                border: 2px solid #e0e0e0;
                background: white;
                border-radius: 10px;
                cursor: pointer;
                text-align: center;
                font-size: 12px;
                font-weight: 600;
                transition: all 0.3s ease;
                color: #666;
            }

            .category-btn.active {
                background: #4CAF50;
                color: white;
                border-color: #4CAF50;
            }

            .category-btn:hover {
                background: #f0f0f0;
                transform: translateY(-2px);
            }

            .category-btn.active:hover {
                background: #45a049;
            }

            .products-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
                gap: 10px;
                flex: 1;
                overflow-y: auto;
                overflow-x: hidden;
                /* Prevent horizontal overflow */
                padding-right: 5px;
                /* Add small padding for scrollbar */
            }

            /* Add scrollbar styling for better UX */
            .products-grid::-webkit-scrollbar {
                width: 6px;
            }

            .products-grid::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 10px;
            }

            .products-grid::-webkit-scrollbar-thumb {
                background: #c1c1c1;
                border-radius: 10px;
            }

            .products-grid::-webkit-scrollbar-thumb:hover {
                background: #a8a8a8;
            }

            .product-card {
                background: white;
                border: 2px solid #e0e0e0;
                border-radius: 15px;
                padding: 15px;
                text-align: center;
                cursor: pointer;
                transition: all 0.3s ease;
                position: relative;
                height: 140px;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                min-width: 0;
                /* Prevent flex items from overflowing */
            }

            .product-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
                border-color: #667eea;
            }

            .product-card.out-of-stock {
                opacity: 0.5;
                cursor: not-allowed;
            }

            .product-name {
                font-size: 11px;
                font-weight: 600;
                color: #333;
                word-wrap: break-word;
                /* Handle long product names */
            }

            .product-price {
                font-weight: bold;
                color: #667eea;
                font-size: 12px;
            }

            .product-stock {
                font-size: 9px;
                color: #999;
                margin-top: 2px;
            }

            .quantity-badge {
                position: absolute;
                top: -5px;
                right: -5px;
                background: #FF6B6B;
                color: white;
                border-radius: 50%;
                width: 20px;
                height: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 10px;
                font-weight: bold;
            }

            .order-section {
                flex: 1;
                display: flex;
                flex-direction: column;
            }

            .order-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 15px;
            }

            .order-title {
                font-size: 18px;
                font-weight: bold;
            }

            .order-items {
                flex: 1;
                overflow-y: auto;
                margin-bottom: 15px;
                max-height: 200px;
            }

            .order-item {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 0;
                border-bottom: 1px solid #f0f0f0;
            }

            .order-item:last-child {
                border-bottom: none;
            }

            .item-info {
                flex: 1;
            }

            .item-name {
                font-size: 14px;
                font-weight: 600;
                margin-bottom: 2px;
            }

            .item-price {
                font-size: 12px;
                color: #666;
            }

            .item-quantity {
                display: flex;
                align-items: center;
                gap: 8px;
                margin: 0 10px;
            }

            .qty-btn {
                width: 25px;
                height: 25px;
                border: 1px solid #ddd;
                background: white;
                border-radius: 50%;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 14px;
                transition: all 0.3s ease;
            }

            .qty-btn:hover {
                background: #f0f0f0;
            }

            .qty-display {
                font-weight: 600;
                min-width: 20px;
                text-align: center;
                font-size: 14px;
            }

            .item-total {
                font-weight: bold;
                font-size: 14px;
                min-width: 60px;
                text-align: right;
            }

            .order-summary {
                border-top: 2px solid #f0f0f0;
                padding-top: 15px;
                margin-bottom: 15px;
            }

            .summary-row {
                display: flex;
                justify-content: space-between;
                margin-bottom: 8px;
                font-size: 14px;
            }

            .summary-row.total {
                font-weight: bold;
                font-size: 18px;
                color: #333;
                padding-top: 8px;
                margin-top: 8px;
            }

            .payment-section {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 10px;
                margin-bottom: 15px;
            }

            .payment-input {
                display: flex;
                flex-direction: column;
            }

            .payment-input label {
                font-size: 12px;
                font-weight: 600;
                margin-bottom: 5px;
                color: #555;
            }

            .payment-input input {
                padding: 12px;
                border: 2px solid #e0e0e0;
                border-radius: 8px;
                font-size: 16px;
                outline: none;
                transition: all 0.3s ease;
            }

            .payment-input input:focus {
                border-color: #667eea;
                box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            }

            .empty-cart {
                text-align: center;
                padding: 40px 20px;
                color: #999;
            }

            .empty-cart-icon {
                font-size: 48px;
                margin-bottom: 10px;
            }

            .search-bar {
                position: relative;
                margin-bottom: 20px;
            }

            .search-bar input {
                width: 100%;
                padding: 12px 20px;
                border: 2px solid #e0e0e0;
                border-radius: 50px;
                font-size: 14px;
                outline: none;
                transition: all 0.3s ease;
            }

            .search-bar input:focus {
                border-color: #667eea;
                box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            }

            .action-buttons {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 10px;
                margin-top: 15px;
            }

            .action-btn {
                padding: 10px;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                font-size: 12px;
                font-weight: bold;
                transition: all 0.3s ease;
            }

            .action-btn.cancel {
                background: #6c757d;
                color: white;
            }

            .action-btn.complete {
                background: #28a745;
                color: white;
            }

            .action-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            }

            /* Responsive design improvements */
            @media (max-width: 1024px) {
                .pos-container {
                    grid-template-columns: 1fr;
                    gap: 15px;
                }

                .right-panel {
                    order: -1;
                }

                .products-grid {
                    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
                }
            }

            @media (max-width: 768px) {
                .pos-container {
                    padding: 10px;
                }

                .left-panel,
                .right-panel {
                    padding: 20px;
                }

                .products-grid {
                    grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
                    gap: 8px;
                }

                .product-card {
                    height: 120px;
                    padding: 10px;
                }

                .product-name {
                    font-size: 10px;
                }

                .product-price {
                    font-size: 11px;
                }
            }
        </style>

        <div class="pos-container">
            <div class="left-panel">
                <div class="search-bar">
                    <input type="text" placeholder="Cari produk..." id="searchInput">
                </div>

                <div class="products-grid" id="productsGrid">
                    <!-- Products will be populated by JavaScript -->
                </div>
            </div>

            <div class="right-panel">
                <div class="order-section">
                    <div class="order-header">
                        <div class="order-title">Pesanan</div>
                    </div>

                    <div class="order-items" id="orderItems">
                        <div class="empty-cart">
                            <div>Tidak ada item dalam keranjang</div>
                        </div>
                    </div>

                    <div class="order-summary">
                        <span>Total:</span>
                        <span id="grandTotal">Rp 0</span>
                    </div>

                    <div class="payment-section">
                        <div class="payment-input" style="width: 170px;">
                            <label>Jumlah Bayar</label>
                            <input type="number" id="paymentAmount" placeholder="Rp 0">
                        </div>
                        <div class="payment-input" style="width: 170px;">
                            <label>Kembalian</label>
                            <input type="text" id="changeAmount" placeholder="Rp 0" readonly>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <button class="action-btn cancel" onclick="cancelOrder()">Batal</button>
                        <button class="action-btn complete" onclick="completePayment('cash')">Simpan</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hidden form for submitting data -->
        <form id="kirim" action="./penjualan/api.php" method="POST" style="display: none;">
            <input type="hidden" name="allData" id="allData">
            <input type="hidden" name="request" value="kirimData">
        </form>
    <!-- </div> -->

    <?php include('../templates/footer.php') ?>
    <script>
        // Function to process thumbnail URL
        function processThumbnail(thumbnail) {
            // If thumbnail is already a full URL
            if (thumbnail.startsWith('http') && !thumbnail.includes('drive.google.com')) {
                return thumbnail;
            }

            // If thumbnail is a Google Drive link
            if (thumbnail.includes('drive.google.com')) {
                // Extract file ID from Google Drive URL
                const pattern = /\/d\/([^\/]+)/;
                const matches = thumbnail.match(pattern);

                if (matches && matches[1]) {
                    const fileId = matches[1];
                    return `https://drive.google.com/thumbnail?id=${fileId}&sz=w500&v=1`;
                }

                return thumbnail;
            }

            // Default: assume it's a local storage path
            return `storage/${thumbnail}`;
        }

        // Sample product data - this will be replaced with your PHP data
        const products = [
            <?php
            $userId = $_SESSION['data']['id'];
            $query = $conn->query("SELECT * FROM barang WHERE created_by_user_id = '$userId'");
            while ($row = $query->fetch_assoc()) :
                // Simple category mapping based on product name for demo
                $category = 'makanan';
                if (strpos(strtolower($row['nama_barang']), 'minum') !== false) $category = 'minuman';
                if (strpos(strtolower($row['nama_barang']), 'snack') !== false || strpos(strtolower($row['nama_barang']), 'goreng') !== false) $category = 'snack';
            ?> {
                    id: <?= $row['id'] ?>,
                    name: '<?= addslashes($row['nama_barang']) ?>',
                    category: '<?= $category ?>',
                    price: <?= $row['harga_umum'] ?>,
                    image: '<?= $row['thumbnail'] ?>',
                    stock: <?= $row['stock_global'] ?>,
                    satuan: '<?= $conn->query("SELECT satuan.satuan_nama FROM satuan WHERE id ='" . $row['satuan_id'] . "'")->fetch_assoc()['satuan_nama'] ?>'
                },
            <?php endwhile; ?>
        ];

        let cart = [];
        let currentCategory = 'all';

        // Initialize the application
        document.addEventListener('DOMContentLoaded', function() {
            displayProducts();
            setupEventListeners();
        });

        function displayProducts() {
            const productsGrid = document.getElementById('productsGrid');
            const filteredProducts = currentCategory === 'all' ?
                products :
                products.filter(product => product.category === currentCategory);

            productsGrid.innerHTML = '';

            filteredProducts.forEach(product => {
                const cartItem = cart.find(item => item.id === product.id);
                const quantity = cartItem ? cartItem.quantity : 0;

                const productCard = document.createElement('div');
                productCard.className = `product-card ${product.stock <= 0 ? 'out-of-stock' : ''}`;
                productCard.innerHTML = `
                    <div class="product-name">${product.name}</div>
                    <div class="product-price">Rp ${product.price.toLocaleString('id-ID')}</div>
                    <div class="product-stock">Stok: ${product.stock}</div>
                    ${quantity > 0 ? `<div class="quantity-badge">${quantity}</div>` : ''}
                `;

                if (product.stock > 0) {
                    productCard.onclick = () => addToCart(product.id);
                }

                productsGrid.appendChild(productCard);
            });
        }

        function filterCategory(category) {
            currentCategory = category;

            // Update active button
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');

            displayProducts();
        }

        function setupEventListeners() {
            // Search functionality
            document.getElementById('searchInput').addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const filteredProducts = products.filter(product =>
                    product.name.toLowerCase().includes(searchTerm)
                );
                displayFilteredProducts(filteredProducts);
            });

            // Payment amount input listener
            document.getElementById('paymentAmount').addEventListener('input', function() {
                updateChange();
            });
        }

        function displayFilteredProducts(filteredProducts) {
            const productsGrid = document.getElementById('productsGrid');
            productsGrid.innerHTML = '';

            filteredProducts.forEach(product => {
                const cartItem = cart.find(item => item.id === product.id);
                const quantity = cartItem ? cartItem.quantity : 0;

                const productCard = document.createElement('div');
                productCard.className = `product-card ${product.stock <= 0 ? 'out-of-stock' : ''}`;
                productCard.innerHTML = `
                    <div class="product-name">${product.name}</div>
                    <div class="product-price">Rp ${product.price.toLocaleString('id-ID')}</div>
                    <div class="product-stock">Stok: ${product.stock}</div>
                    ${quantity > 0 ? `<div class="quantity-badge">${quantity}</div>` : ''}
                `;

                if (product.stock > 0) {
                    productCard.onclick = () => addToCart(product.id);
                }

                productsGrid.appendChild(productCard);
            });
        }

        function addToCart(productId) {
            const product = products.find(p => p.id === productId);
            const existingItem = cart.find(item => item.id === productId);

            if (existingItem) {
                if (existingItem.quantity >= product.stock) {
                    alert('Stok tidak mencukupi!');
                    return;
                }
                existingItem.quantity += 1;
            } else {
                if (product.stock <= 0) {
                    alert('Stok habis!');
                    return;
                }
                cart.push({
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    quantity: 1,
                    satuan: product.satuan
                });
            }

            displayProducts();
            updateOrderDisplay();
        }

        function updateQuantity(productId, change) {
            const item = cart.find(item => item.id === productId);
            if (item) {
                item.quantity += change;
                if (item.quantity <= 0) {
                    cart = cart.filter(cartItem => cartItem.id !== productId);
                }
            }
            displayProducts();
            updateOrderDisplay();
        }

        function updateOrderDisplay() {
            const orderItems = document.getElementById('orderItems');

            if (cart.length === 0) {
                orderItems.innerHTML = `
                    <div class="empty-cart">
                        <div>Tidak ada item dalam keranjang</div>
                    </div>
                `;
            } else {
                orderItems.innerHTML = '';
                cart.forEach(item => {
                    const orderItem = document.createElement('div');
                    orderItem.className = 'order-item';
                    orderItem.innerHTML = `
                        <div class="item-info">
                            <div class="item-name">${item.name}</div>
                            
                        </div>
                        <div class="item-quantity">
                            <button class="qty-btn" onclick="updateQuantity(${item.id}, -1)">-</button>
                            <div class="qty-display">${item.quantity}</div>
                            <button class="qty-btn" onclick="updateQuantity(${item.id}, 1)">+</button>
                        </div>
                        <div class="item-total">Rp ${(item.price * item.quantity).toLocaleString('id-ID')}</div>
                    `;
                    orderItems.appendChild(orderItem);
                });
            }

            updateTotals();
        }

        function updateTotals() {
            const total = cart.reduce((total, item) => total + (item.price * item.quantity), 0);
            document.getElementById('grandTotal').textContent = `Rp ${total.toLocaleString('id-ID')}`;
            updateChange();
        }

        function updateChange() {
            const paymentAmount = parseFloat(document.getElementById('paymentAmount').value) || 0;
            const total = parseFloat(document.getElementById('grandTotal').textContent.replace(/[^0-9]/g, '')) || 0;
            const change = paymentAmount - total;

            const changeInput = document.getElementById('changeAmount');
            changeInput.value = `Rp ${change.toLocaleString('id-ID')}`;

            // Update change display color
            if (change < 0) {
                changeInput.style.color = '#f44336';
            } else {
                changeInput.style.color = '#27ae60';
            }
        }

        function completePayment(method) {
            if (cart.length === 0) {
                alert('Keranjang kosong! Silakan tambahkan produk terlebih dahulu.');
                return;
            }

            const paymentAmount = parseFloat(document.getElementById('paymentAmount').value) || 0;
            const total = parseFloat(document.getElementById('grandTotal').textContent.replace(/[^0-9]/g, '')) || 0;

            if (paymentAmount < total) {
                alert('Jumlah pembayaran kurang dari total!');
                return;
            }

            // Prepare data for submission
            const dataPenjualan = {
                id_pelanggan: 0, // Default to regular customer
                total: total,
                bayar: paymentAmount,
                kembali: paymentAmount - total
            };

            const arrData = cart.map(item => ({
                id: item.id,
                nama_barang: item.name,
                harga_umum: item.price,
                jumlah_data: item.quantity,
                subtotal: item.price * item.quantity,
                satuan_nama: item.satuan
            }));

            const retr = {
                request: "kirimData",
                penjualan: dataPenjualan,
                obat: arrData,
            };

            // Submit the form
            document.getElementById('allData').value = JSON.stringify(retr);
            document.getElementById('kirim').submit();
        }

        function cancelOrder() {
            if (cart.length === 0) {
                alert('Tidak ada pesanan untuk dibatalkan!');
                return;
            }

            if (confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')) {
                cart = [];
                document.getElementById('paymentAmount').value = '';
                document.getElementById('changeAmount').value = 'Rp 0';

                displayProducts();
                updateOrderDisplay();
            }
        }
    </script>
</div>