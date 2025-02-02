<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartASPOO</title>
    <link rel="icon" href="{{URL::asset('/img/portal/android-chrome-512x512.png')}}" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
    body {
        font-family: 'Poppins';
    }
    .navbar {
        font-family: 'Poppins';
        background-color: #FBD9C0;
        font-weight: 600;
        display: flex;
        flex-wrap: inherit;
        align-items: center;
        justify-content: flex-start;
    }
    .navbar>.container, .navbar>.container-fluid, .navbar>.container-lg, .navbar>.container-md, .navbar>.container-sm, .navbar>.container-xl, .navbar>.container-xxl {
        display: flex;
        flex-wrap: inherit;
        align-items: center;
        justify-content: flex-start;
        font-weight: bolder;
    }
    .arrow-icon {
        font-size: 28px;
        color: #000; 
        background: none;
        border: none;
        padding: 0;
    }
    .margin-up {
        margin-top: 30px;
    }
    .store-info {
        display: flex;
        align-items: center;
    }
    .store-logo {
        max-width: 100px;
        margin-right: 20px;
        cursor: pointer;
    }
    .store-details {
        flex-grow: 1;
    }
    .store-title {
        font-size: 24px;
        font-weight: bold;
    }
    .store-activity {
        color: #9b9b9b;
    }
    .store-follow {
        font-size: 16px;
        font-weight: bold;
    }
    .store-follow-count {
        font-size: 14px;
        color: #9b9b9b;
    }
    .store-follow-divider {
        border-right: 2px solid #9b9b9b;
        margin: 0 10px;
    }
    .store-description {
        padding: 20px;
    }

    .store-image {
        max-width: 100%;
        height: auto;
        margin-top: 20px; 
    }
    .modal-content {
        background-color: transparent;
        border: none;
    }

    #infotoko-page {
        margin-top: 50px;
        margin-left: 0px;
    }
    .store-name {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
        margin-top: 50px;
    }
    .mall-name {
        font-size: 16px;
        color: #fff;
        background-color: #606C5D;
        padding: 5px 10px;
        margin-top: 10px;
        display: inline-block;
    }
    .mall-name {
        margin-top: 10px;
    }
    .list-group {
        margin-top: 20px;
        width: 160%; 
    }
    .list-group-item {
        background-color: transparent; 
        border: none;
        border-bottom: 8px solid #000000;
        position: relative;
        padding-left: 25px;
        font-size: 15px; 
    }
    .section-divider {
        border-top: 2px solid #000000;
        margin-top: 10px;
        margin-bottom: 10px;
        padding-left: 5px;
        margin-left: 11px;
        width: 100%;
    }
    .row-blank{
        margin-top: 30px;
    }

    @media (min-width: 768px) {
        #infotoko-page {
            margin-top: 50px;
            margin-left: 69px;
        }
    }
</style>
</head>
<body>

<nav class="navbar">
    <div class="container">
        <a href="{{ url('/p/penjualan') }}" class="btn ">
            <i class="fas fa-arrow-left arrow-icon"></i>
        </a>            
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Detail Toko</a>
            </li>
        </ul>
    </div>
</nav>
<main id="infotoko-page" class="main-content mt-0">
    <section>
        <div class="row g-0" style="max-width: 900px;"> 
            <div class="container margin-up">
                <div class="store-info">
                    <img class="store-logo" src="{{URL::asset('/img/portal/storelogo.png')}}" alt="Store Logo" class="img-fluid" data-bs-toggle="modal" data-bs-target="#logoModal">
                    <div class="store-details">
                        <div class="store-title">Nama Toko </div>
                        <div class="store-activity">Toko telah aktif beberapa menit yang lalu</div>
                        <div class="store-follow">
                            1.2K Pengikut
                            <span class="store-follow-divider"></span>
                            200 Mengikuti
                        </div>
                    </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="logoModal" tabindex="-1" aria-labelledby="logoModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <img src="{{URL::asset('/img/portal/storelogo.png')}}" alt="Store Logo">
                    </div>
                </div>
            </div>
            <div class="mall-name">
                Aspoo Mall
            </div>
        </div>
        {{-- line dibawah adalah line revisi --}}
        <div class="row">
            <div class="d-flex align-items-center" style="margin-top: 30px">
                <i class="fa-regular fa-star"></i>
                <p class=" mt-3 text-muted" style="padding-left: 10px;">Penilaian</p>
            </div>
            <div class="section-divider"></div>
            <div class="d-flex align-items-center">
                <i class="bi bi-chat-left-text-fill"></i>
                <p class=" mt-3 text-muted" style="padding-left: 10px">Performa chat</p>
            </div>
            <div class="section-divider"></div>
            <div class="d-flex align-items-center">
                <p class=" mt-3 text-muted" style="padding-left: 28px">Produk</p>
            </div>
            <div class="section-divider"></div>
            <div class="d-flex align-items-center">
                <p class=" mt-3 text-muted" style="padding-left: 28px">Bergabung</p>
            </div>
            <div class="section-divider"></div>
            <div class="d-flex align-items-center">
                <i class="bi bi-file-text-fill"></i>
                <p class=" mt-3 text-muted" style="padding-left: 10px">Keterangan</p>
            </div>
            <div class="section-divider"></div>
            <div class="d-flex align-items-center">
                <p class=" mt-3 text-muted" style="padding-left: 28px">Tautan toko</p>
            </div>
            <div class="section-divider"></div>
            <div class="d-flex align-items-center">
                <i class="bi bi-check-square-fill"></i>
                <p class=" mt-3 text-muted" style="padding-left: 10px">Akun Terverifikasi</p>
            </div>
        </div>
        <div class="row">
            <div class="text-center">
                <button type="button" class="btn btn-lg mt-4 mb-0" style="background-color: #606C5D; 
                color: white; font-weight: bold; border-radius: 15px; margin-top: 20px; width:100%">Lihat Semua Produk</button>
            </div>
        </div>
        <div class="row-blank">

        </div>
    </section>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>


