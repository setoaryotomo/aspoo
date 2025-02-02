@extends('portal_layout.templates')
@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
    }

    .card {
        min-height: 250px;
        max-height: 250px;
        cursor: pointer;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .button-container {
        margin-top: 10px;
    }

    .prev-button,
    .next-button {
        position: absolute;
        top: 50%;
        font-size: 24px;
        background: none;
        border: none;
        cursor: pointer;
    }

    .prev-button {
        left: 50px;
    }

    .next-button {
        right: 50px;
    }

    .space {
        width: 150px;
    }

    .category-title {
        font-size: 18px;
        margin-top: 20px;
    }

    .product-card h5 {
        text-align: center;
    }

    .product-card {
        border: 1px solid #e0e0e0;
        padding: 10px;
        margin-top: 20px;
        border-radius: 5px;
        position: relative;
        min-height: 200px;
    }

    .product-card img {
        max-width: 100%;
        display: block;
        margin: 0 auto;
    }

    .product-card .cart-icon {
        position: absolute;
        bottom: 10px;
        left: 10px;
        font-size: 18px;
        cursor: pointer;
        margin-top: 10px;
    }

    .section-divider {
        border-top: 2px solid #e0e0e0;
        margin-top: 10px;
        margin-bottom: 30px;
    }

    .section-heading {
        color: #000;
        font-family: Poppins;
        font-size: 30px;
        font-style: normal;
        font-weight: 600;
        line-height: 24px;
        margin-top: 20px;
        /* 48% */
    }

    .carouselRekomendasi {
        overflow-x: auto;
    }

    .carouselslide {
        margin-top: 30px;
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: auto;
        padding: 0;
        margin: 0;
        color: #000;
    }

    .product-card h4 {
        color: var(--type-high-emphasis, #171520);
        font-size: 18.172px;
        font-style: normal;
        font-weight: 500;
        line-height: 22.715px;
        /* 125% */
    }

    .badge {
        margin-right: 10px;
    }

    .harga {
        color: var(--type-high-emphasis, #171520);
        font-size: 13px;
        padding-top: 5px;
        font-weight: 900px;
        line-height: 22.715px;
        /* 125% */
    }

    /* .onhover {
        transition: outline 0.6s linear;
    }

    .onhover:hover {
        cursor: pointer;
        box-shadow: 10px 12px 15px #45414e1a;
    } */

    .diskon {
        color: var(--type-high-emphasis, #171520);
        font-size: 11px;
        font-style: normal;
        font-weight: 500;
        line-height: 22.715px;
        /* 174.734% */
    }

    .lokasi {
        display: flex;
        width: 294.317px;
        height: 22.715px;
        flex-direction: column;
        justify-content: center;
        flex-shrink: 0;
        font-size: 12px;
    }

    .card-title {
        font-size: 12px;
        font-weight: 400;
        color: #000;
    }

    @media (max-width: 768px) { /* Ubah sesuai dengan lebar layar yang Anda inginkan */
    .button-container {
        position: relative; /* Atur posisi relatif untuk tombol */
        margin-top: 20px; /* Atur jarak atas */
    }

    .prev-button,
    .next-button {
        position: absolute; /* Atur posisi absolut untuk tombol */
        top: 50%; /* Pusatkan tombol secara vertikal */
        transform: translateY(-50%);
    }

    .prev-button {
        left: 10px; /* Geser tombol prev ke kiri */
    }

    .next-button {
        right: 10px; /* Geser tombol next ke kanan */
    }

    .section-divider{
        margin-top: 50px;
    }
}


</style>

<div class="container" id="dashboard">
    <!-- Section Iklan -->
    <div id="carouselIklan" class="carouselslide">
        <div class="carousel-inner">
            <div class="carousel-item" v-for="(slider, index) in this.slider_list" :key="slider.id"
                :class="{ active: index === 0 }">
                <img :src="slider.url_foto" class="d-block w-100" height="250">
            </div>
        </div>
    </div>
    <div class="section-divider"></div>

    <!-- Section Rekomendasi -->
    <div class="section-heading mt-4">Produk </div>
    <div id="carouselRekomendasi" class="carousel slide">
        <div class="carousel-inner mt-4">
            <div class="carousel-item" v-for="(chunk, index) in chunckRekomendasi" :key="index"
                :class="{ active: index === currentSlideIndex }">
                <div class="row">
                    <div class="col-md-2" v-for="rekomendasi in chunk" :key="rekomendasi.id">
                        <div class="card onhover" @click="navigasi(`{{ url('/p/') }}/barang/${rekomendasi.id}`)">
                            <div class="card-img-top">
                                <img :src="rekomendasi.thumbnail.includes('https://') ? rekomendasi.thumbnail : rekomendasi.thumbnail_readable" class="card-img-top" alt="Produk Foto"
                                    height="100">
                                <div class="card-body">
                                    <div class="card-title" style="font-style: uppercase;">
                                        @{{ rekomendasi.nama_barang }}
                                        <br></div>
                                    <div class="card-text">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="harga">
                                                    <span>@{{ rupiah(parseInt(rekomendasi.harga_user)) }}</span> <br>
                                                </div>
                                                <div class="mt-1 diskon"><span
                                                        class="badge badge-danger">@{{ rekomendasi.diskon }}%</span>
                                                    <s>@{{ rupiah(rekomendasi.harga_user_asli) }}</s>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row justify-content-between">
                                                    <div class="col-md-9">
                                                        <p class="lokasi">Stock : @{{ rekomendasi.stock_global }}</p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol untuk menggeser carousel -->
    <div class="button-container">
        <!-- Perbaikan: Ubah pemanggilan metode dari `slideLeft` menjadi `prevSlide` -->
        <button class="prev-button" @click="prevSlide">&#10094;</button>
        <!-- Perbaikan: Ubah pemanggilan metode dari `slideRight` menjadi `nextSlide` -->
        <button class="next-button" @click="nextSlide">&#10095;</button>
    </div>

    <div id="carouselRekomendasi" class="carousel slide" ref="carouselRekomendasi">

        <div class="section-divider"></div>

    </div>



    <script>
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

    </script>
    @endsection
