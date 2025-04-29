@extends('portal_layout.templates')
@section('content')

{{-- <body class="preload-wrapper color-primary-8 color-main-text-2" id="dashboard"> --}}
<body class="preload-wrapper">
    <!-- RTL -->
    <!-- <a href="javascript:void(0);" id="toggle-rtl" class="tf-btn animate-hover-btn btn-fill">RTL</a> -->
    <!-- /RTL  -->
    <!-- preload -->
    <div class="preload preload-container">
        <div class="preload-logo">
            <div class="spinner"></div>
        </div>
    </div>
    <!-- /preload -->
    <div id="wrapper">
        <!-- Top bar -->
        
        <!-- /Top bar -->
       
        <!-- /header -->
        <!-- slider -->
        <div class="tf-slideshow slider-effect-fade slider-grocery position-relative flat-spacing-25 pb_0">
            <div class="container">
                <div dir="ltr" class="swiper tf-sw-slideshow radius-20" data-preview="1" data-tablet="1" data-mobile="1" data-centered="false" data-space="0" data-loop="false" data-auto-play="false" data-delay="2000" data-speed="1000">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide" lazy="true">
                            <div class="wrap-slider">
                                @foreach($slider as $sliders)
                                <img class="lazyload" data-src="{{ Storage::url($sliders->foto) }}" src="{{ Storage::url($sliders->foto) }}" alt="hp-slideshow-01">
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /slider -->
        <!-- Categories -->
        <section class="flat-spacing-30 flat-control-sw">
            {{-- <div class="container">
                <div class="flat-title flex-row justify-content-between px-0">
                    <span class="title fw-6 wow fadeInUp" data-wow-delay="0s" style="font-size: 30px">Featured Categories</span>
                    <div class="box-sw-navigation">
                        <div class="sw-dots style-2 medium sw-pagination-recent justify-content-center"></div>
                    </div>
                </div>
                <div dir="ltr" class="swiper tf-sw-recent wow fadeInUp" data-preview="6" data-tablet="3" data-mobile="2" data-space-lg="30" data-space-md="30" data-space="15" data-pagination="2" data-pagination-md="3" data-pagination-lg="3">
                    <div class="swiper-wrapper">
                        @foreach($category->unique('kategori_nama') as $items)
                        <div class="swiper-slide">
                            <div class="collection-item-circle has-bg has-bg-2 hover-img">
                                <a href="shop-default.html" class="collection-image img-style">
                                    <img class="lazyload" data-src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTrEQSrRvWngQBdX7MBdzKYjG9BL3HP1ovhxA&s" alt="collection-img" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTrEQSrRvWngQBdX7MBdzKYjG9BL3HP1ovhxA&s">
                                </a>
                                <div class="collection-content text-center">
                                    <a href="shop-default.html" class="link title fw-5">{{ $items->kategori_nama }}</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        <div class="swiper-slide">
                            <div class="collection-item-circle has-bg has-bg-2 hover-img">
                                <a href="shop-default.html" class="collection-image img-style">
                                    <img class="lazyload" data-src="https://www.themesflat.co/html/ecomus/images/collections/dairy.png" alt="collection-img" src="https://www.themesflat.co/html/ecomus/images/collections/dairy.png">
                                </a>
                                <div class="collection-content text-center">
                                    <a href="shop-default.html" class="link title fw-5">Best Deals</a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="collection-item-circle has-bg has-bg-2 hover-img">
                                <a href="shop-default.html" class="collection-image img-style">
                                    <img class="lazyload" data-src="https://www.themesflat.co/html/ecomus/images/collections/package-foods.png" alt="collection-img" src="https://www.themesflat.co/html/ecomus/images/collections/package-foods.png">
                                </a>
                                <div class="collection-content text-center">
                                    <a href="shop-default.html" class="link title fw-5">Package Foods</a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="collection-item-circle has-bg has-bg-2 hover-img">
                                <a href="shop-default.html" class="collection-image img-style">
                                    <img class="lazyload" data-src="https://www.themesflat.co/html/ecomus/images/collections/beverage.png" alt="collection-img" src="https://www.themesflat.co/html/ecomus/images/collections/beverage.png">
                                </a>
                                <div class="collection-content text-center">
                                    <a href="shop-default.html" class="link title fw-5">Beverages</a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="collection-item-circle has-bg has-bg-2 hover-img">
                                <a href="shop-default.html" class="collection-image img-style">
                                    <img class="lazyload" data-src="https://www.themesflat.co/html/ecomus/images/collections/meat.png" alt="collection-img" src="https://www.themesflat.co/html/ecomus/images/collections/meat.png">
                                </a>
                                <div class="collection-content text-center">
                                    <a href="shop-default.html" class="link title fw-5">Meat</a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="collection-item-circle has-bg has-bg-2 hover-img">
                                <a href="shop-default.html" class="collection-image img-style">
                                    <img class="lazyload" data-src="https://www.themesflat.co/html/ecomus/images/collections/fruit.png" alt="collection-img" src="https://www.themesflat.co/html/ecomus/images/collections/fruit.png">
                                </a>
                                <div class="collection-content text-center">
                                    <a href="shop-default.html" class="link title fw-5">Fruit</a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="collection-item-circle has-bg has-bg-2 hover-img">
                                <a href="shop-collection-sub.html" class="collection-image img-style">
                                    <img class="lazyload" data-src="https://www.themesflat.co/html/ecomus/images/collections/package-foods.png" alt="collection-img" src="https://www.themesflat.co/html/ecomus/images/collections/package-foods.png">
                                </a>
                                <div class="collection-content text-center">
                                    <a href="shop-collection-sub.html" class="link title fw-5">Mixed food</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </section>
        <!-- /Categories -->
        <!-- Banner Collection -->
        <section class="flat-spacing-13 pt_0">
            <div class="container">
                <div dir="ltr" class="swiper tf-sw-collection" data-preview="2" data-tablet="2" data-mobile="1.2" data-space-lg="30" data-space-md="30" data-space="15" data-loop="false" data-auto-play="false">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="collection-item-v4 hover-img">
                                <a href="product-detail.html" class="collection-inner">
                                    <div class="collection-image radius-10 img-style">
                                        <img class="lazyload" data-src="https://www.themesflat.co/html/ecomus/images/collections/banner-collection-grocery.jpg" src="https://www.themesflat.co/html/ecomus/images/collections/banner-collection-grocery.jpg" alt="collection-img">
                                    </div>
                                    <div class="collection-content text-start">
                                        <div class="bottom wow fadeInUp" data-wow-delay="0s">
                                            <p class="subheading fs-14 fw-7 text-white">FREE DELIVERY</p>
                                            <h5 class="heading text-white fw-6">
                                                Organic Ingredients <br> Made Easy
                                            </h5>
                                            <button class="tf-btn style-3 btn-color-5 radius-60 animate-hover-btn">Shop
                                                now</button>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="collection-item-v4 hover-img">
                                <a href="product-detail.html" class="collection-inner">
                                    <div class="collection-image radius-10 img-style">
                                        <img class="lazyload" data-src="https://www.themesflat.co/html/ecomus/images/collections/banner-collection-grocery2.jpg" src="https://www.themesflat.co/html/ecomus/images/collections/banner-collection-grocery2.jpg" alt="collection-img">
                                    </div>
                                    <div class="collection-content text-start">
                                        <div class="bottom wow fadeInUp" data-wow-delay="0s">
                                            <p class="subheading fs-14 fw-7">SALE UP TO 30% OFF</p>
                                            <h5 class="heading fw-6">
                                                For Juice Lovers <br> Everywhere
                                            </h5>
                                            <button class="tf-btn style-3 btn-color-6 radius-60 animate-hover-btn">Shop
                                                now</button>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Banner Collection -->
        <!-- Deals -->
        
        <!-- /Deals -->
        <!-- Popular product -->
        <section class="flat-spacing-5 pt_0">
            <div class="container">
                <div class="flat-animate-tab">
                    {{-- <div class="flat-title flat-title-tab flex-row justify-content-between"> --}}
                        <span class="title text-nowrap fw-6 wow fadeInUp" style="font-size: 30px" data-wow-delay="0s">List products</span>
                    {{-- </div> --}}
                    <br><br>
                    <div class="tab-content">
                        <div class="tab-pane active show" id="meat" role="tabpanel">
                            <div class="tf-grid-layout tf-col-2 xl-col-4">
                                <!-- card product 1 -->
                                @foreach($barang as $barangs)
                                <div class="card-product style-9">
                                    <div class="card-product-wrapper">
                                        <a data-href="{{ url('/p/barang/' . $barangs->id) }}" class="product-img">
                                            
                                            <img src="{{ URL::asset($barangs->thumbnail_readable) }}" alt="{{ $barangs->nama_barang }}" class="img-fluid" style="height: 187px">
                                      
                                        </a>
                                        <div class="list-product-btn absolute-2">
                                            <a href="javascript:void(0);" class="box-icon bg_white wishlist btn-icon-action">
                                                <span class="icon icon-heart"></span>
                                                <span class="tooltip">Add to Wishlist</span>
                                                <span class="icon icon-delete"></span>
                                            </a>
                                            <a href="#compare" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft" class="box-icon bg_white compare btn-icon-action">
                                                <span class="icon icon-compare"></span>
                                                <span class="tooltip">Add to Compare</span>
                                                <span class="icon icon-check"></span>
                                            </a>
                                            <a href="#quick_view" data-bs-toggle="modal" class="box-icon bg_white quickview tf-btn-loading">
                                                <span class="icon icon-view"></span>
                                                <span class="tooltip">Quick View</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-product-info">
                                        <div class="inner-info">
                                            <a href="product-detail.html" class="title link fw-6">{{ $barangs->nama_barang }}</a>
                                            <span class="">Rp.{{ number_format($barangs->harga_user, 2) }}</span>
                                        </div>
                                        <div class="list-product-btn">
                                            <a href="#quick_add" data-bs-toggle="modal" class="box-icon quick-add tf-btn-loading">
                                                <span class="icon icon-bag"></span>
                                                <span class="tooltip">Add to cart</span>
                                            </a>
                                        </div>

                                    </div>
                                </div>
                                @endforeach
                                
                            </div>
                        </div>
                       
                    </div>
                </div>

            </div>
        </section>
        <!-- /Popular product -->
        <!-- Iconbox -->
        <section>
            <div class="container">
                <div class="bg-yellow-10 radius-20 flat-wrap-iconbox">
                    <div class="flat-title lg">
                        <p class="sub-title fw-6">WHAT IS ASPOO PARCEL?</p>
                        <span class="title fw-6 text-center">Eco-based groceries, delivered.</span>
                    </div>
                    <div class="flat-iconbox-v3 lg">
                        <div class="wrap-carousel wrap-mobile">
                            <div dir="ltr" class="swiper tf-sw-mobile" data-preview="1" data-space="15">
                                <div class="swiper-wrapper wrap-iconbox lg">
                                    <div class="swiper-slide">
                                        <div class="tf-icon-box text-center">
                                            <div class="icon">
                                                <i class="icon-plant"></i>
                                            </div>
                                            <div class="content">
                                                <div class="title">Eco-Based</div>
                                                <p>Shop everyday staples, small-batch finds, and <br> community
                                                    favorites. From meat and seafood alternatives to snacks and candy -
                                                    we’ve got your fridge, freezer and pantry covered.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="tf-icon-box text-center">
                                            <div class="icon">
                                                <i class="icon-deliciousness"></i>
                                            </div>
                                            <div class="content">
                                                <div class="title">Deliciousness</div>
                                                <p>Crafted with precision and excellence, our activewear is meticulously
                                                    engineered using premium materials to ensure unmatched comfort and
                                                    durability.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="tf-icon-box text-center">
                                            <div class="icon">
                                                <i class="icon-door"></i>
                                            </div>
                                            <div class="content">
                                                <div class="title">To your door</div>
                                                <p>Designed for every body and anyone, our activewear embraces diversity
                                                    with a wide range of sizes and shapes, celebrating the beauty of
                                                    individuality.</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="sw-dots style-2 sw-pagination-mb justify-content-center"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Iconbox -->
        <!-- text-image -->
        <section class="flat-spacing-12">
            <div class="container">
                <div class="tf-grid-layout md-col-2 tf-img-with-text img-text-3 img-text-3-style-2">
                    <div class="tf-image wow fadeInUp" data-wow-delay="0s">
                        <div class="grid-img-group">
                            <div class="box-img item-1 hover-img tf-image-wrap">
                                <div class="img-style">
                                    <img class="lazyload" data-src="https://www.themesflat.co/html/ecomus/images/collections/img-w-text-grocery1.jpg" src="https://www.themesflat.co/html/ecomus/images/collections/img-w-text-grocery1.jpg" alt="img-slider">
                                </div>
                            </div>
                            <div class="box-img item-2 hover-img tf-image-wrap">
                                <div class="img-style">
                                    <img class="lazyload" data-src="https://www.themesflat.co/html/ecomus/images/collections/img-w-text-grocery2.jpg" src="https://www.themesflat.co/html/ecomus/images/collections/img-w-text-grocery2.jpg" alt="img-slider">
                                </div>
                            </div>
                            <div class="box-img item-3 hover-img tf-image-wrap">
                                <div class="img-style">
                                    <img class="lazyload" data-src="https://www.themesflat.co/html/ecomus/images/collections/img-w-text-grocery3.jpg" src="https://www.themesflat.co/html/ecomus/images/collections/img-w-text-grocery3.jpg" alt="img-slider">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tf-content-wrap wow fadeInUp" data-wow-delay="0s">
                        <p class="subheading text-uppercase fw-7">PERFECT GIFT FOR YOU</p>
                        <h2 class="heading fade-item fade-item-1 fw-6">ASPOO Parcel</h2>
                        <p class="desc fade-item fade-item-2">Delivered every month! Perfect for your favorite or
                            anyone you want <br> to introduce to the best better-for-you foods out there.</p>
                        {{-- <a href="shop-default.html" class="tf-btn btn-fill animate-hover-btn btn-icon radius-60"><span>Shop collection</span><i class="icon icon-arrow-right"></i></a> --}}
                    </div>
                </div>
            </div>
        </section>
        <!-- /text-image -->

        <!-- footer -->
       
        <!-- /footer -->
    </div>

    <!-- gotop -->
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 286.138;">
            </path>
        </svg>
    </div>
    <!-- /gotop -->


    <!-- mobile menu -->
    
    <!-- /mobile menu -->


    <!-- Javascript -->
<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/swiper-bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/carousel.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/lazysize.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/count-down.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/wow.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/multiple-modal.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/shop.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/nouislider.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/main.js') }}"></script>



{{-- <script>
    Vue.createApp({
        data() {
            return {
                kategori_produk_list: [],
                slider_list: [],
                rekomendasi_list: [],
                currentSlideIndex: 0,
                visibleChunks: [],
            }

        },
        async created() {
            await this.fetchData()
        },
        computed: {
            chunckRekomendasi() {
                const chunkSize = 6;
                const chunks = [];
                for (let i = 0; i < this.rekomendasi_list.length; i += chunkSize) {
                    chunks.push(this.rekomendasi_list.slice(i, i + chunkSize));
                }
                return chunks;
            },
            chunckKategoriProduk() {
                const chunkSize = 6;
                const chunks = [];
                for (let i = 0; i < this.kategori_produk_list.length; i += chunkSize) {
                    chunks.push(this.kategori_produk_list.slice(i, i + chunkSize));
                }
                return chunks;
            }
        },
        methods: {
            navigasi(url) {
                navigate(url)
            },
            async fetchData() {
                const response = await httpClient.get("{!! url('p/index-data') !!}/")
                console.log(response)
                if (response.data.code == "SUCCESS") {
                    var data = response.data.result
                    this.kategori_produk_list = [
                        ...this.kategori_produk_list,
                        ...data.kategori_produk.map(el => {
                            return el
                        })
                    ];

                    this.slider_list = [
                        ...this.slider_list,
                        ...data.slider.map(el => {
                            return el
                        })
                    ]

                    this.rekomendasi_list = [
                        ...this.rekomendasi_list,
                        ...data.rekomendasi.map(el => {
                            return el
                        })
                    ]

                    console.log(this.slider_list)
                }

            },
            rupiah(amount) {
                const rupiahFormat = "Rp " + amount.toLocaleString("id-ID");
                return rupiahFormat;
            },

            prevSlide() {
                if (this.currentSlideIndex > 0) {
                    this.currentSlideIndex--;
                    this.updateVisibleChunks(); // Memanggil metode untuk memperbarui data yang ditampilkan
                }
            },
            // Perbaikan: Tambahkan pemanggilan metode untuk memperbarui data yang ditampilkan pada slide
            nextSlide() {
                if (this.currentSlideIndex < this.chunckRekomendasi.length - 1) {
                    this.currentSlideIndex++;
                    this.updateVisibleChunks(); // Memanggil metode untuk memperbarui data yang ditampilkan
                }
            },
            updateVisibleChunks() {
                // Mengambil bagian yang terlihat dari data rekomendasi sesuai dengan posisi slide
                const startIndex = this.currentSlideIndex * 6; // Menggunakan chunkSize = 6
                const endIndex = Math.min(startIndex + 6, this.rekomendasi_list.length);
                this.visibleChunks = this.rekomendasi_list.slice(startIndex, endIndex);
            }
        },

    }).mount("#dashboard")

</script> --}}
@endsection