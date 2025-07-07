<?php require '../config.php';
middleware();
$title = 'Penjualan';
?>
<?php $active[5] = 'active' ?>
<?php include('../templates/sidebar.php') ?>
<div class="main-panel bgMain">
    <div class="container-fluid" style="padding-top: 10px;">
        <style>
            * {
                box-sizing: border-box;
            }

            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                color: #333;
            }

            .pos-container {
                display: grid;
                grid-template-columns: 1fr 400px;
                gap: 20px;
                min-height: calc(100vh - 150px);
            }

            .left-panel {
                background: rgba(255, 255, 255, 0.95);
                border-radius: 20px;
                padding: 25px;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            }

            .right-panel {
                background: rgba(255, 255, 255, 0.95);
                border-radius: 20px;
                padding: 25px;
                box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            }

            .header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 30px;
            }

            .logo {
                font-size: 24px;
                font-weight: bold;
                color: #667eea;
            }

            .date {
                color: #666;
                font-size: 14px;
            }

            .search-bar {
                position: relative;
                margin-bottom: 30px;
            }

            .search-bar input {
                width: 100%;
                padding: 15px 50px 15px 20px;
                border: 2px solid #e0e0e0;
                border-radius: 50px;
                font-size: 16px;
                outline: none;
                transition: all 0.3s ease;
            }

            .search-bar input:focus {
                border-color: #667eea;
                box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            }

            .products-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
                gap: 20px;
            }

            .product-card {
                background: white;
                border-radius: 15px;
                padding: 20px;
                text-align: center;
                cursor: pointer;
                transition: all 0.3s ease;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
                position: relative;
                border: 1px solid #eee;
            }

            .product-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            }

            .product-image {
                width: 100%;
                height: 120px;
                object-fit: contain;
                margin-bottom: 10px;
                border-radius: 10px;
                background-color: #f8f9fa;
            }

            .product-name {
                font-weight: 600;
                margin-bottom: 8px;
                color: #333;
            }

            .product-category {
                color: #999;
                font-size: 12px;
                margin-bottom: 8px;
            }

            .product-price {
                font-weight: bold;
                color: #667eea;
                font-size: 14px;
            }

            .add-btn {
                position: absolute;
                bottom: 10px;
                right: 10px;
                width: 30px;
                height: 30px;
                color: white;
                border: none;
                border-radius: 50%;
                font-size: 18px;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.3s ease;
            }

            .add-btn:hover {
                transform: scale(1.1);
            }

            .quantity-badge {
                position: absolute;
                top: -5px;
                right: -5px;
                background: #FF6B6B;
                color: white;
                border-radius: 50%;
                width: 24px;
                height: 24px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 12px;
                font-weight: bold;
            }

            .order-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
            }

            .order-title {
                font-size: 18px;
                font-weight: bold;
            }

            .order-number {
                color: #667eea;
                font-weight: 600;
            }

            .order-items {
                max-height: 300px;
                overflow-y: auto;
                margin-bottom: 20px;
            }

            .order-item {
                display: flex;
                align-items: center;
                padding: 15px 0;
                border-bottom: 1px solid #f0f0f0;
            }

            .order-item:last-child {
                border-bottom: none;
            }

            .item-details {
                flex: 1;
            }

            .item-name {
                font-weight: 600;
                margin-bottom: 5px;
            }

            .item-price {
                color: #999;
                font-size: 14px;
            }

            .quantity-controls {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-right: 15px;
            }

            .qty-btn {
                width: 30px;
                height: 30px;
                border: 1px solid #e0e0e0;
                background: white;
                border-radius: 50%;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 16px;
                transition: all 0.3s ease;
            }

            .qty-btn:hover {
                background: #f0f0f0;
            }

            .qty-display {
                min-width: 30px;
                text-align: center;
                font-weight: 600;
            }

            .item-total {
                font-weight: bold;
                color: #333;
                min-width: 80px;
                text-align: right;
            }

            .order-summary {
                border-top: 2px solid #f0f0f0;
                padding-top: 20px;
            }

            .summary-row {
                display: flex;
                justify-content: space-between;
                margin-bottom: 10px;
            }

            .summary-row.total {
                font-weight: bold;
                font-size: 18px;
                color: #333;
                border-top: 1px solid #e0e0e0;
                padding-top: 10px;
                margin-top: 10px;
            }

            .checkout-btn {
                width: 100%;
                padding: 18px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                border: none;
                border-radius: 15px;
                font-size: 16px;
                font-weight: bold;
                cursor: pointer;
                transition: all 0.3s ease;
                margin-top: 20px;
            }

            .checkout-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            }

            .payment-section {
                margin-top: 20px;
                padding-top: 20px;
                border-top: 1px solid #eee;
            }

            .payment-input {
                margin-bottom: 15px;
            }

            .payment-input label {
                display: block;
                margin-bottom: 5px;
                font-weight: 600;
                color: #555;
            }

            .payment-input input {
                width: 100%;
                padding: 12px 15px;
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

            .change-display {
                background: #f8f9fa;
                padding: 15px;
                border-radius: 8px;
                margin-top: 15px;
                font-weight: bold;
                text-align: center;
                font-size: 18px;
                color: #333;
            }

            @media (max-width: 1024px) {
                .pos-container {
                    grid-template-columns: 1fr;
                    gap: 15px;
                }

                .right-panel {
                    order: -1;
                }

                .products-grid {
                    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
                    gap: 15px;
                }
            }

            .summary-row.total {
                border-top: none !important;
            }
        </style>

        <div class="pos-container">
            <div class="left-panel">
                <div class="header">
                    <div class="logo">Menu</div>
                    <div class="date" id="current-date"><?= date('l, j F Y') ?></div>
                </div>

                <div class="search-bar">
                    <input type="text" placeholder="Search..." id="searchInput">
                </div>

                <div class="products-grid" id="productsGrid">
                    <!-- Products will be populated by JavaScript -->
                </div>
            </div>

            <div class="right-panel">
                <div class="order-header">
                    <div class="order-title">Orders</div>
                </div>

                <div class="order-items" id="orderItems">
                    <!-- Order items will be populated by JavaScript -->
                </div>

                <div class="order-summary">
                    <div class="summary-row" style="display: none;">
                        <span>Subtotal</span>
                        <span id="subTotal">Rp. 0</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span id="grandTotal">Rp. 0</span>
                    </div>
                </div>

                <div class="payment-section">
                    <div class="payment-input">
                        <label for="paymentAmount">Jumlah Pembayaran</label>
                        <input type="number" id="paymentAmount" placeholder="Masukkan jumlah pembayaran">
                    </div>
                    <div class="change-display" id="changeDisplay">
                        Kembalian: Rp. 0
                    </div>
                    <button class="checkout-btn" id="completePayment">Simpan Transaksi</button>
                </div>
            </div>
        </div>

        <!-- Hidden form for submitting data -->
        <form id="kirim" action="./penjualan/api.php" method="POST" style="display: none;">
            <input type="hidden" name="allData" id="allData">
            <input type="hidden" name="request" value="kirimData">
        </form>
    </div>

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
            while ($row = $query->fetch_assoc()): 
                // Simple category mapping based on product name for demo
                $category = 'makanan';
                if (strpos(strtolower($row['nama_barang']), 'minum') !== false) $category = 'minuman';
                if (strpos(strtolower($row['nama_barang']), 'snack') !== false || strpos(strtolower($row['nama_barang']), 'goreng') !== false) $category = 'snack';
            ?>
            { 
                id: <?= $row['id'] ?>, 
                name: '<?= $row['nama_barang'] ?>', 
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
            updateCurrentDate();
        });

        function updateCurrentDate() {
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const today = new Date();
            document.getElementById('current-date').textContent = today.toLocaleDateString('id-ID', options);
        }

        function displayProducts() {
            const productsGrid = document.getElementById('productsGrid');
            const filteredProducts = currentCategory === 'all' 
                ? products 
                : products.filter(product => product.category === currentCategory);

            productsGrid.innerHTML = '';

            filteredProducts.forEach(product => {
                const cartItem = cart.find(item => item.id === product.id);
                const quantity = cartItem ? cartItem.quantity : 0;
                const imageUrl = processThumbnail(product.image);
                
                const productCard = document.createElement('div');
                productCard.className = 'product-card';
                productCard.innerHTML = `
                    
                    <div class="product-name">${product.name}</div>
                    <div class="product-category">Stok: ${product.stock} ${product.satuan}</div>
                    <div class="product-price">Rp. ${product.price.toLocaleString('id-ID')}</div>
                    <button class="add-btn" style="background: #667eea;" onclick="addToCart(${product.id})" ${product.stock <= 0 ? 'disabled' : ''}>
                        ${product.stock <= 0 ? '⛔' : '+'}
                    </button>
                    ${quantity > 0 ? `<div class="quantity-badge">${quantity}</div>` : ''}
                `;
                productsGrid.appendChild(productCard);
            });
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
            
            // Complete payment button
            document.getElementById('completePayment').addEventListener('click', completePayment);
            
            // Payment amount input
            document.getElementById('paymentAmount').addEventListener('input', updateChange);
        }

        function displayFilteredProducts(filteredProducts) {
            const productsGrid = document.getElementById('productsGrid');
            productsGrid.innerHTML = '';

            filteredProducts.forEach(product => {
                const cartItem = cart.find(item => item.id === product.id);
                const quantity = cartItem ? cartItem.quantity : 0;
                const imageUrl = processThumbnail(product.image);
                
                const productCard = document.createElement('div');
                productCard.className = 'product-card';
                productCard.innerHTML = `
                    
                    <div class="product-name">${product.name}</div>
                    <div class="product-category">Stok: ${product.stock} ${product.satuan}</div>
                    <div class="product-price">Rp. ${product.price.toLocaleString('id-ID')}</div>
                    <button class="add-btn" style="background: #667eea;" onclick="addToCart(${product.id})" ${product.stock <= 0 ? 'disabled' : ''}>
                        ${product.stock <= 0 ? '⛔' : '+'}
                    </button>
                    ${quantity > 0 ? `<div class="quantity-badge">${quantity}</div>` : ''}
                `;
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
            orderItems.innerHTML = '';

            cart.forEach(item => {
                const orderItem = document.createElement('div');
                orderItem.className = 'order-item';
                orderItem.innerHTML = `
                    <div class="item-details">
                        <div class="item-name">${item.name}</div>
                        <div class="item-price">Rp. ${item.price.toLocaleString('id-ID')}</div>
                    </div>
                    <div class="quantity-controls">
                        <button class="qty-btn" onclick="updateQuantity(${item.id}, -1)">-</button>
                        <div class="qty-display">${item.quantity}</div>
                        <button class="qty-btn" onclick="updateQuantity(${item.id}, 1)">+</button>
                    </div>
                    <div class="item-total">Rp. ${(item.price * item.quantity).toLocaleString('id-ID')}</div>
                `;
                orderItems.appendChild(orderItem);
            });

            updateTotals();
        }

        function updateTotals() {
            const total = cart.reduce((total, item) => total + (item.price * item.quantity), 0);
            document.getElementById('subTotal').textContent = `Rp. ${total.toLocaleString('id-ID')}`;
            document.getElementById('grandTotal').textContent = `Rp. ${total.toLocaleString('id-ID')}`;
            
            // Auto-focus payment input when items are added
            if (cart.length > 0) {
                document.getElementById('paymentAmount').focus();
            }
        }

        function updateChange() {
            const paymentAmount = parseInt(document.getElementById('paymentAmount').value) || 0;
            const total = cart.reduce((total, item) => total + (item.price * item.quantity), 0);
            const change = paymentAmount - total;
            
            document.getElementById('changeDisplay').textContent = `Kembalian: Rp. ${change.toLocaleString('id-ID')}`;
            
            // Change color based on change amount
            const changeDisplay = document.getElementById('changeDisplay');
            if (change < 0) {
                changeDisplay.style.color = '#e74c3c';
            } else {
                changeDisplay.style.color = '#27ae60';
            }
        }

        function completePayment() {
            if (cart.length === 0) {
                alert('Keranjang kosong! Silakan tambahkan produk terlebih dahulu.');
                return;
            }
            
            const paymentAmount = parseInt(document.getElementById('paymentAmount').value) || 0;
            const total = cart.reduce((total, item) => total + (item.price * item.quantity), 0);
            
            if (paymentAmount < total) {
                alert('Pembayaran kurang dari total!');
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
    </script>
</div>