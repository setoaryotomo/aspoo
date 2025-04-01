@include('layout.head')
<style>
    /* Tambahkan CSS ini di bagian head atau file CSS terpisah */
    .user-profile {
        position: relative;
        margin-left: 15px;
    }
    
    .user-dropdown-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: inherit;
    }
    
    .user-info {
        display: flex;
        align-items: center;
    }
    
    .user-profile-img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .box-user {
        margin-left: 10px;
        line-height: 1.3;
    }
    
    .user-name {
        font-weight: 600;
        font-size: 14px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 120px;
    }
    
    .user-role {
        font-size: 12px;
        color: #6c757d;
    }
    
    .dropdown-menu {
        min-width: 220px;
        padding: 0;
        border-radius: 8px;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .dropdown-user {
        padding: 12px 16px;
        border-bottom: 1px solid #f1f1f1;
        background-color: #f8f9fa;
    }
    
    .dropdown-item {
        padding: 8px 16px;
        font-size: 14px;
    }
    
    .logout-item {
        color: #dc3545 !important;
    }
    
    /* Untuk tampilan mobile */
    @media (max-width: 767px) {
        .user-name, .user-role {
            display: none;
        }
        
        .user-profile-img {
            width: 32px;
            height: 32px;
        }
    }
    </style>
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
        <!-- header -->
        <header id="header" class="header-default header-style-2 header-style-4">
            <div class="main-header line">
                <div class="container">
                    <div class="row wrapper-header align-items-center">
                        <div class="col-md-4 col-3 tf-lg-hidden">
                            <a href="#mobileMenu" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="16" viewBox="0 0 24 16" fill="none">
                                    <path d="M2.00056 2.28571H16.8577C17.1608 2.28571 17.4515 2.16531 17.6658 1.95098C17.8802 1.73665 18.0006 1.44596 18.0006 1.14286C18.0006 0.839753 17.8802 0.549063 17.6658 0.334735C17.4515 0.120408 17.1608 0 16.8577 0H2.00056C1.69745 0 1.40676 0.120408 1.19244 0.334735C0.978109 0.549063 0.857702 0.839753 0.857702 1.14286C0.857702 1.44596 0.978109 1.73665 1.19244 1.95098C1.40676 2.16531 1.69745 2.28571 2.00056 2.28571ZM0.857702 8C0.857702 7.6969 0.978109 7.40621 1.19244 7.19188C1.40676 6.97755 1.69745 6.85714 2.00056 6.85714H22.572C22.8751 6.85714 23.1658 6.97755 23.3801 7.19188C23.5944 7.40621 23.7148 7.6969 23.7148 8C23.7148 8.30311 23.5944 8.59379 23.3801 8.80812C23.1658 9.02245 22.8751 9.14286 22.572 9.14286H2.00056C1.69745 9.14286 1.40676 9.02245 1.19244 8.80812C0.978109 8.59379 0.857702 8.30311 0.857702 8ZM0.857702 14.8571C0.857702 14.554 0.978109 14.2633 1.19244 14.049C1.40676 13.8347 1.69745 13.7143 2.00056 13.7143H12.2863C12.5894 13.7143 12.8801 13.8347 13.0944 14.049C13.3087 14.2633 13.4291 14.554 13.4291 14.8571C13.4291 15.1602 13.3087 15.4509 13.0944 15.6653C12.8801 15.8796 12.5894 16 12.2863 16H2.00056C1.69745 16 1.40676 15.8796 1.19244 15.6653C0.978109 15.4509 0.857702 15.1602 0.857702 14.8571Z" fill="currentColor"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="col-md-4 col-6">
                            <a href="{{ url('/p') }}" class="logo-header">
                                <img src="https://warungaspoo.com/img/portal/logo.png" alt="logo" class="logo">
                            </a>
                        </div>
                        <div class="col-md-4 col-6 tf-md-hidden">
                            <div class="tf-form-search">
                                <form action="home-search.html" class="search-box">
                                    <input type="text" placeholder="Search product">
                                    <button class="tf-btn"><i class="icon icon-search"></i></button>
                                </form>
                               
                            </div>
                        </div>
                        <div class="col-md-4 col-3">
                            <ul class="nav-icon d-flex justify-content-end align-items-center gap-20">
                                <li class="nav-search"><a href="#canvasSearch" data-bs-toggle="offcanvas" aria-controls="offcanvasLeft" class="nav-icon-item"><i class="icon icon-search"></i></a></li>
                                
                                <li class="nav-compare"><a href="{{ url('/p/listbarang') }}" class="nav-icon-item align-items-center gap-10"><i class="icon icon-shopping"></i><span class="text">Product</span></a></li>
                                
                                <li class="nav-wishlist"><a href="{{ url('/p/pesanparcel') }}" class="nav-icon-item  align-items-center gap-10"><i class="icon icon-gift"></i><span class="text">Parcel</span></a></li>
                                <li class="nav-cart cart-lg" v-if="this.isLoggedin == true"><a href="{{ url('/p/keranjang') }}" class="nav-icon-item"><i class="icon icon-bag"></i></a></li>
                                <li class="nav-account" v-if="this.isLoggedin == false"><a href="{{ url('/p/login') }}" class="nav-icon-item align-items-center gap-10"><i class="icon icon-account"></i> <span class="text">Login</span></a></li>
                                <div class="user-profile" v-if="this.isLoggedin == true">
                                    <div class="dropdown">
                                        <a href="#" role="button" id="userNavbarDropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" class="user-dropdown-link">
                                            <div class="user-info">
                                                <img :src="userData.fotodata || 'https://via.placeholder.com/40'" class="user-profile-img" alt="Profile">
                                                <div class="box-user">
                                                    {{-- <div class="user-name">@{{ userData.name }}</div> --}}
                                                    {{-- <div class="user-role">@{{ userData.roleName }}</div> --}}
                                                </div>
                                                <i class="icon icon-chevron-down ms-2" style="font-size:12px"></i>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userNavbarDropdown">
                                            <div class="dropdown-user">
                                                <div class="user-email">@{{ userData.email }}</div>
                                            </div>
                                            <a class="dropdown-item" href="{{ url('/p/daftartransaksi') }}">
                                                Daftar Transaksi
                                            </a>
                                            <a class="dropdown-item" 
                                               href="{{ url('/user/login') }}" 
                                               target="_blank" 
                                               rel="noopener noreferrer" 
                                               @click.stop>
                                                Ke Dashboard
                                            </a>
                                            <a class="dropdown-item" href="{{ url('/p/profile') }}">
                                                 Pengaturan
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item logout-item" href="{{ url('/p/logout') }}">
                                                <i class="icon icon-logout me-2"></i> Logout
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-bottom line tf-md-hidden">
                <div class="container">
                    <div class="wrapper-header d-flex justify-content-between align-items-center">
                       
                    </div>
                </div>
            </div>
        </header>