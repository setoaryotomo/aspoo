@extends("portal_layout.templates")
@section("content")
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
    }

    @media (min-width: 576px) {
        .container {
            max-width: 540px;
        }
    }

    @media (min-width: 768px) {
        .container {
            max-width: 720px;
        }
    }

    @media (min-width: 992px) {
        .container {
            max-width: 960px;
        }
    }

    @media (min-width: 1200px) {
        .container {
            max-width: 1140px;
        }
    }

    .margin-up {
        margin-top: 30px;
    }

    .store-info {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 20px 0;
    }

    .store-logo {
        width: 100px;
        height: 100px;
        object-fit: cover;
        /* border-radius: 50%; */
        margin-bottom: 15px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .store-details {
        flex-grow: 1;
        width: 100%;
    }

    .store-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 8px;
        color: #333;
    }

    .store-activity {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 10px;
    }

    .store-follow {
        font-size: 0.9rem;
        color: #666;
    }

    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
    }

    .action-button {
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .follow-button {
        background-color: #606C5D;
        color: white;
        border: none;
    }

    .chat-button,
    .share-button {
        background-color: white;
        color: black;
        border: 2px solid black;
    }

    .info-button {
        background-color: white;
        color: black;
        border: 2px solid black;
        padding: 6px 10px;
        font-size: 1rem;
    }

    .tab-list {
        display: flex;
        justify-content: center;
        border-bottom: 1px solid #e0e0e0;
        margin-bottom: 20px;
    }

    .tab {
        padding: 10px 20px;
        cursor: pointer;
        font-weight: 600;
        color: #666;
        position: relative;
    }

    .active-tab {
        color: #2c3e50;
    }

    .active-tab::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 100%;
        height: 3px;
        background-color: #3498db;
    }

    .card-container {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        padding: 0 5px;
    }

    @media (min-width: 576px) {
        .card-container {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (min-width: 768px) {
        .card-container {
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
    }

    @media (min-width: 992px) {
        .card-container {
            grid-template-columns: repeat(5, 1fr);
        }
    }

    @media (min-width: 1200px) {
        .card-container {
            grid-template-columns: repeat(6, 1fr);
        }
    }

    .card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .card-img-top {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }

    .card-body {
        padding: 12px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .card-title {
        font-size: 0.9rem;
        font-weight: 500;
        color: #333;
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: 40px;
    }

    .harga {
        color: #171520;
        font-size: 0.95rem;
        font-weight: 700;
        margin-top: auto;
    }

    /* Responsive adjustments for store info */
    @media (min-width: 768px) {
        .store-info {
            flex-direction: row;
            text-align: left;
            align-items: flex-start;
        }

        .store-logo {
            margin-bottom: 0;
            margin-right: 20px;
        }

        .action-buttons {
            justify-content: flex-start;
        }

        .tab-list {
            justify-content: flex-start;
        }
    }

    /* Loading animation */
    .loading {
        display: flex;
        justify-content: center;
        padding: 20px;
    }

    .loading-spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<body>
    <div class="container margin-up">
        <div class="store-info">
            <a href="{{ url('/p/infotoko') }}">
                <img class="store-logo" src="https://images.vexels.com/media/users/3/223411/isolated/preview/7a8154be7b9b50412fc2cf63b636e370-store-icon-flat-store.png" alt="Store Logo">
            </a>
            <div class="store-details">
                <div class="store-title">{{ $toko->nama }}</div>
                <div class="store-activity">{{ $toko->user->detail->alamat }}</div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="tab-list">
            <div id="tab-beranda" class="tab active-tab">Produk</div>
        </div>
    </div>

    <div class="container">
        <div class="card-container">
            @foreach ($barang as $item)
            <div class="card" data-href="{{ url('/p/') }}/barang/{{ $item->id }}">
                <img class="card-img-top" src="{{ URL::asset($item->thumbnail_readable) }}" alt="{{ $item->thumbnail_readable }}" loading="lazy">
                <div class="card-body">
                    <h5 class="card-title">{{ $item->nama_barang }}</h5>
                    <p class="harga">Rp. {{ number_format($item->harga_umum - ($item->harga_umum * ($item->diskon / 100)), 0, ',', '.') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Card click handler
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('click', () => {
                window.location.href = card.dataset.href;
            });
        });

        // Responsive adjustments
        function adjustLayout() {
            const cards = document.querySelectorAll('.card');
            let maxHeight = 0;
            
            // Reset all card heights
            cards.forEach(card => {
                card.style.height = 'auto';
            });
            
            // Find the tallest card in each row
            if (window.innerWidth >= 768) {
                const containerWidth = document.querySelector('.card-container').offsetWidth;
                const cardWidth = cards[0]?.offsetWidth || 0;
                const cardsPerRow = Math.floor(containerWidth / cardWidth) || 1;
                
                for (let i = 0; i < cards.length; i += cardsPerRow) {
                    maxHeight = 0;
                    const rowCards = Array.from(cards).slice(i, i + cardsPerRow);
                    
                    rowCards.forEach(card => {
                        if (card.offsetHeight > maxHeight) {
                            maxHeight = card.offsetHeight;
                        }
                    });
                    
                    rowCards.forEach(card => {
                        card.style.height = maxHeight + 'px';
                    });
                }
            }
        }

        // Run on load and resize
        window.addEventListener('load', adjustLayout);
        window.addEventListener('resize', adjustLayout);
    </script>
    @endsection