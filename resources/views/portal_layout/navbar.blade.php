@include('layout.head')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
    }

    .custom-navbar {
        background-color: #FBD9C0;
        font-weight: 600;
        padding: 10px 20px;
    }

    .navbar-logo {
        font-size: 24px;
        margin-right: 20px;
    }

    .navbar-menu {
        color: #333333;
        transition: color 0.3s;
        margin-right: 20px;
    }

    .navbar-menu:hover {
        color: #ff6600;
    }

    .dropdown-menu .submenu {
        display: flex;
        justify-content: space-between;
        padding: 10px 20px;
        border-radius: 25px;
    }

    .dropdown-title {
        margin-left: 33px;
        margin-bottom: 20px;
    }

    .dropdown-divider {
        border-right: 2px solid #000000;
        height: 220px;
        margin: 0 20px;
    }

    .dropdown-header-text {
        font-weight: bolder;
        color: #000000;
    }

    .dropdown-item-text {
        font-weight: 300;
    }

    .search-form {
        position: relative;
        padding-left: 20px;
        margin-right: 20px;
    }

    .cart-icon {
        font-size: 24px;
        cursor: pointer;
    }

    .keranjang-link {
        margin-left: auto;
        margin-right: 25px;
    }

    .jadi-mitra-button {
        color: #757272;
        padding-right: 45px;
        margin-left: 20px;
        text-decoration: none;

    }

    .user-profile {
        margin-left: 0;
        margin-right: 28px;
    }

    .search-input {
        border-radius: 15px;
        padding-right: 40px;
        width: 250px;
    }

    .search-icon {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        background-color: transparent;
        border: none;
        cursor: pointer;
        color: #000;
        font-size: 16px;
    }

    .user-profile-img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .user-info {
        display: flex;
        justify-content: center;
    }

    .box-user {
        justify-content: center;
        flex-direction: column;
        text-decoration: none;
    }

    .user-name {
        color: #757272;
        font-family: Poppins;
        font-size: 18px;
        font-style: normal;
        font-weight: 600;
    }

    .user-role {
        color: #757272;
        font-family: Poppins;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
    }

    .dropdown-menu {
        /* Your existing styles... */
        /* Add or modify styles below */
        padding: 10px;
        width: 240px;
        /* Adjust the width as needed */
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }

    .dropdown-divider {
        border-bottom: 1px solid #ccc;
        margin: 8px 0;
    }

    .dropdown-item {
        padding: 8px 12px;
        color: #333;
        text-decoration: none;
        display: block;
        transition: background-color 0.3s;
    }

    .dropdown-item:hover {
        background-color: #f5f5f5;
    }

    /* Style for logout item */
    .logout-item {
        margin-top: 10px;
        color: #ff0000;
        /* Change the color as needed */
    }

</style>
<nav class="navbar custom-navbar navbar-expand-lg navbar-light" id="navbar">
    <div class="container">
        <a class="navbar-logo navbar-brand" href="{{ url('/p') }}">
            <img style="width: 110px" src="{{ URL::asset('/img/portal/logo.png') }}" alt="Logo" width="65">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="navbar-menu nav-link" style="font-size: 16px; align:center; font-weight: bold;"
                        href="{{ url('/p') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="navbar-menu nav-link" style="font-size: 16px; align:center; font-weight: bold;"
                        href="{{ url('/p/listbarang') }}">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="navbar-menu nav-link" style="font-size: 16px; align:center; font-weight: bold;"
                        href="{{ url('/p/pesanparcel') }}">Parcel</a>
                </li>
            </ul>
            <form class="search-form" action="{{ url('/p/cari') }}" role="search" method="GET">
                <input class="form-control search-input" type="search" placeholder="Search" name="q"
                    aria-label="Search">
                <input type="hidden" name="tipe" value="barang">
                <!-- Tambahkan input hidden untuk jenis pencarian (barang) -->
                <button type="submit" name="cari" class="fa-solid fa-magnifying-glass search-icon"></button>
            </form>

            <a class="navbar-menu keranjang-link" href="{{ url('/p/keranjang') }}">
                <img src="{{ URL::asset('/img/portal/keranjang.png') }}" alt="Keranjang" width="30">
            </a>
            <a class="navbar-menu jadi-mitra-button" v-if="this.isLoggedin == false" style="font-size: 16px"
                href="{{ url('/p/login') }}">Jadi Mitra</a>
            <div class="user-profile" v-if="this.isLoggedin == false">
                <div class="dropdown">
                    <a href="#" role="button" id="userNavbarDropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" class="user-dropdown-link">
                        <div class="user-info">
                            <img src="{{ URL::asset('/img/portal/user-icon.png') }}" class="user-profile-img" alt="">

                        </div>

                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-width"
                        aria-labelledby="userNavbarDropdown">
                        <a class="dropdown-item" :href="`{{ url('/p/login') }}`">Login</a>
                    </div>
                </div>
            </div>
            <div class="user-profile" v-if="this.isLoggedin == true">
                <div class="dropdown">
                    <a href="#" role="button" id="userNavbarDropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" class="user-dropdown-link">
                        <div class="user-info">
                            <img :src="userData.fotodata" class="user-profile-img" alt="">
                            <div class="box-user ml-3">
                                <div class="user-name">@{{ this.userData.name }} </div>
                                <div class="user-role">@{{ this.userData.roleName }}</div>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-width"
                        aria-labelledby="userNavbarDropdown">
                        <div class="dropdown-user">
                            <div class="user-name">@{{ this.userData.email }}</div>
                        </div>
                        <a class="dropdown-item" href="{{ url('/p/daftartransaksi') }}">Daftar Transaksi</a>
                        <a class="dropdown-item" href="{{ url('/user/login') }}">Ke Dashboard</a>
                        <a class="dropdown-item" href="{{ url('/p/profile') }}">Pengaturan</a>
                        <a class="dropdown-item logout-item" href="{{ url('/p/logout') }}">Logout</a>
                    </div>

                </div>
            </div>
        </div>
</nav>
