@extends("portal_layout.templates")
@section("content")
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100&display=swap');
    body {
        font-family: 'Poppins', sans-serif;
    }
    .space {
        width: 150px;
    }
    .category-title {
        font-size: 18px;
        margin-top: 20px;
    }
    .product-card {
        border: 1px solid #e0e0e0;
        padding: 10px;
        margin-top: 20px;
        border-radius: 5px;
        position: relative;
    }
    .product-card img {
        max-width: 100%;
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
        margin-top: 100px;
        margin-bottom: 30px;
    }
    .section-heading {
      color: #000;
      font-family: Poppins;
      font-size: 30px;
      font-style: normal;
      font-weight: 600;
      line-height: 24px; /* 48% */
    }
    .carouselslide{
      margin-top: 148px;
    }
    .carousel-control-prev,
    .carousel-control-next {
        width: auto;
        padding: 0;
        margin: 0;
    }
    .product-card h4 {
      color: var(--type-high-emphasis, #171520);
      font-size: 18.172px;
      font-style: normal;
      font-weight: 500;
      line-height: 22.715px; /* 125% */
    }
    .badge {
      margin-right: 10px;
    }
    .harga {
      color: var(--type-high-emphasis, #171520);
      font-size: 18.172px;
      font-style: normal;
      font-weight: 500;
      line-height: 22.715px; /* 125% */
    }
    .diskon {
      color: var(--type-high-emphasis, #171520);
      font-size: 15px;
      font-style: normal;
      font-weight: 500;
      line-height: 22.715px; /* 174.734% */
    }
    .lokasi {
      display: flex;
      width: 294.317px;
      height: 22.715px;
      flex-direction: column;
      justify-content: center;
      flex-shrink: 0;
    }
</style>

<div class="container">


  <!-- Section Iklan -->
  <div id="carouselIklan" class="carouselslide" data-bs-ride="carousel">
      <div class="carousel-inner">
          <div class="carousel-item active">
              <img src="{{URL::asset('/img/portal/iklan.png')}}" class="d-block w-100" alt="Banner 1">
          </div>
          <div class="carousel-item">
              <img src="{{URL::asset('/img/portal/iklan.png')}}" class="d-block w-100" alt="Banner 2">
          </div>
          <div class="carousel-item">
              <img src="{{URL::asset('/img/portal/iklan.png')}}" class="d-block w-100" alt="Banner 3">
          </div>
      </div>
      <a class="carousel-control-prev" href="#carouselIklan" role="button" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselIklan" role="button" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
      </a>
  </div>

  <div class="section-divider"></div>

    
  <div class="section-heading">Kategori Pilihan</div>
  <div id="carouselKategori" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
          <div class="carousel-item active">
              <div class="row">
                  <!-- Dummy data for category cards -->
                  <div class="col-md-4">
                      <div class="product-card">
                          <img src="{{URL::asset('/img/portal/kategori.png')}}" alt="Kategori 1">
                          <h5>Kategori 1</h5>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="product-card">
                          <img src="{{URL::asset('/img/portal/kategori.png')}}" alt="Kategori 2">
                          <h5>Kategori 2</h5>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="product-card">
                          <img src="{{URL::asset('/img/portal/kategori.png')}}" alt="Kategori 3">
                          <h5>Kategori 3</h5>
                      </div>
                  </div>
              </div>
          </div>
          <div class="carousel-item">
              <div class="row">
                  <!-- Dummy data for category cards -->
                  <div class="col-md-4">
                      <div class="product-card">
                          <img src="{{URL::asset('/img/portal/kategori.png')}}" alt="Kategori 4">
                          <h5>Kategori 4</h5>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="product-card">
                          <img src="{{URL::asset('/img/portal/kategori.png')}}" alt="Kategori 5">
                          <h5>Kategori 5</h5>
                      </div>
                  </div>
                  <div class="col-md-4">
                      <div class="product-card">
                          <img src="{{URL::asset('/img/portal/kategori.png')}}" alt="Kategori 6">
                          <h5>Kategori 6</h5>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <a class="carousel-control-prev" href="#carouselKategori" role="button" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselKategori" role="button" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
      </a>
  </div>

  <div class="section-divider"></div>

  <!-- Section Rekomendasi -->
  <div class="section-heading">Rekomendasi </div>
  <div id="carouselRekomendasi" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
          <div class="carousel-item active">
              <div class="row">
                  <!-- Dummy data for recommended product cards -->
                  <div class="col-md-3">
                      <div class="product-card">
                          <img src="{{URL::asset('/img/portal/produk.png')}}" alt="Produk 1">
                          <h4>Produk 1</h4>
                          <p>Kategori: Makanan</p>
                          <p>Rating: 4.5 (200 ulasan)</p>
                          <p class="harga">Harga: $90</p>
                          <p><span class="badge bg-danger">-10%</span><s class="diskon">Harga: $100</s></p>
                          <p class="lokasi">Lokasi: Toko A</p>
                          <i class="fas fa-shopping-cart cart-icon"></i>
                      </div>
                  </div>
                  <!-- More dummy data for recommended product cards -->
                  <div class="col-md-3">
                      <div class="product-card">
                          <img src="{{URL::asset('/img/portal/produk.png')}}" alt="Produk 1">
                          <h4>Produk 2</h4>
                          <p>Kategori: Makanan</p>
                          <p>Rating: 4.5 (200 ulasan)</p>
                          <p class="harga">Harga: $90</p>
                          <p><span class="badge bg-danger">-10%</span><s class="diskon">Harga: $100</s></p>
                          <p class="lokasi">Lokasi: Toko A</p>
                          <i class="fas fa-shopping-cart cart-icon"></i>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="product-card">
                          <img src="{{URL::asset('/img/portal/produk.png')}}" alt="Produk 1">
                          <h4>Produk 3</h4>
                          <p>Kategori: Makanan</p>
                          <p>Rating: 4.5 (200 ulasan)</p>
                          <p class="harga">Harga: $90</p>
                          <p><span class="badge bg-danger">-10%</span><s class="diskon">Harga: $100</s></p>
                          <p class="lokasi">Lokasi: Toko A</p>
                          <i class="fas fa-shopping-cart cart-icon"></i>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="product-card">
                          <img src="{{URL::asset('/img/portal/produk.png')}}" alt="Produk 1">
                          <h4>Produk 4</h4>
                          <p>Kategori: Makanan</p>
                          <p>Rating: 4.5 (200 ulasan)</p>
                          <p class="harga">Harga: $90</p>
                          <p><span class="badge bg-danger">-10%</span><s class="diskon">Harga: $100</s></p>
                          <p class="lokasi">Lokasi: Toko A</p>
                          <i class="fas fa-shopping-cart cart-icon"></i>
                      </div>
                  </div>
              </div>
          </div>
          <div class="carousel-item">
              <div class="row">
                  <!-- More dummy data for recommended product cards -->
                  <div class="col-md-3">
                      <div class="product-card">
                          <img src="{{URL::asset('/img/portal/produk.png')}}" alt="Produk 1">
                          <h4>Produk 5</h4>
                          <p>Kategori: Makanan</p>
                          <p>Rating: 4.5 (200 ulasan)</p>
                          <p class="harga">Harga: $90</p>
                          <p><span class="badge bg-danger">-10%</span><s class="diskon">Harga: $100</s></p>
                          <p class="lokasi">Lokasi: Toko A</p>
                          <i class="fas fa-shopping-cart cart-icon"></i>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="product-card">
                          <img src="{{URL::asset('/img/portal/produk.png')}}" alt="Produk 1">
                          <h4>Produk 6</h4>
                          <p>Kategori: Makanan</p>
                          <p>Rating: 4.5 (200 ulasan)</p>
                          <p class="harga">Harga: $90</p>
                          <p><span class="badge bg-danger">-10%</span><s class="diskon">Harga: $100</s></p>
                          <p class="lokasi">Lokasi: Toko A</p>
                          <i class="fas fa-shopping-cart cart-icon"></i>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="product-card">
                          <img src="{{URL::asset('/img/portal/produk.png')}}" alt="Produk 1">
                          <h4>Produk 7</h4>
                          <p>Kategori: Makanan</p>
                          <p>Rating: 4.5 (200 ulasan)</p>
                          <p class="harga">Harga: $90</p>
                          <p><span class="badge bg-danger">-10%</span><s class="diskon">Harga: $100</s></p>
                          <p class="lokasi">Lokasi: Toko A</p>
                          <i class="fas fa-shopping-cart cart-icon"></i>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="product-card">
                          <img src="{{URL::asset('/img/portal/produk.png')}}" alt="Produk 1">
                          <h4>Produk 8</h4>
                          <p>Kategori: Makanan</p>
                          <p>Rating: 4.5 (200 ulasan)</p>
                          <p class="harga">Harga: $90</p>
                          <p><span class="badge bg-danger">-10%</span><s class="diskon">Harga: $100</s></p>
                          <p class="lokasi">Lokasi: Toko A</p>
                          <i class="fas fa-shopping-cart cart-icon"></i>
                      </div>
                  </div>
                  
              </div>
          </div>
      </div>
      <a class="carousel-control-prev" href="#carouselRekomendasi" role="button" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselRekomendasi" role="button" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
      </a>
  </div>
  <div class="section-divider"></div>

</div>
@endsection