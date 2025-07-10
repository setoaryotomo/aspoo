@extends('portal_layout.templates')
@section('content')


<style>
    /* Add the Poppins font */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
    
    body {
        font-family: 'Poppins', sans-serif;
        /* background-color: #FBD9C0; */
    }
    
    main#login-page {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }
    
    .login-card {
        background: white;
        border-radius: 30px;
        width: 100%;
        max-width: 1100px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .login-image {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px;
    }
    
    .login-image img {
        max-width: 100%;
        height: auto;
        object-fit: contain;
    }
    
    .login-form {
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    .form-control-lg {
        padding: 12px 20px;
        border-radius: 10px;
        border: 1px solid #ddd;
    }
    
    .btn-login {
        background-color: #606C5D;
        color: white;
        font-weight: bold;
        padding: 12px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .btn-login:hover {
        background-color: #4e584d;
        transform: translateY(-2px);
    }
    
    .logo-container {
        padding: 20px;
        text-align: center;
    }
    
    /* Responsive adjustments */
    @media (max-width: 992px) {
        .login-card {
            margin: 20px 0;
        }
        
        .login-image {
            padding: 20px;
        }
        
        .login-form {
            padding: 30px;
        }
    }
    
    @media (max-width: 768px) {
        .login-card {
            flex-direction: column;
            height: auto;
        }
        
        .login-image img {
            max-height: 250px;
        }
        
        .login-form {
            padding: 25px;
        }
    }
    
    @media (max-width: 576px) {
        .login-form {
            padding: 20px;
        }
        
        .logo-container img {
            width: 120px;
            height: auto;
        }
    }
</style>

<main id="login-page" class="main-content">
    <div class="container">
        <div class="login-card row g-0">
            {{-- <div class="logo-container col-12">
                <img src="../img/portal/logo.png" alt="Logo" style="width: 200px" class="img-fluid"/>
            </div> --}}
            
            <div class="col-md-6 login-image">
                <img src="{{URL::asset('/img/portal/login_logo.png')}}" alt="Login Illustration" class="img-fluid"/>
            </div>
            
            <div class="col-md-6 login-form">
                <h4 class="text-center fw-bold mb-4" style="color: rgba(0, 0, 0, 0.9);">Login</h4>
                
                <form role="form">
                    <div class="mb-3">
                        <input v-model="email" type="email" class="form-control form-control-lg" placeholder="Email" aria-label="Email">
                    </div>
                    <div class="mb-3">
                        <input v-model="password" type="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password">
                        <div class="mt-2 text-end">
                            <a href="{{ url('/p/registrasi') }}" style="font-size: 13px; color: #606C5D;">Don't have an account?</a>
                        </div>
                    </div>
                    <div class="text-center">
                        <button @click="login" type="button" class="btn btn-login w-100 mt-4 mb-0">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
    createApp({
        data() {
            return {
                // email: "<?= (env('APP_ENV') == 'local' ? 'developer@gmail.com' : '') ?>",
                // password: "<?= (env('APP_ENV') == 'local' ? 'kecilsemuatanpaspasi' : '') ?>",
                remember_me: false
            };
        },
        methods: {
            async login() {
                try {
                    showLoading();
                    const { email, password, remember_me } = this;
                    const response = await httpClient.post("/p/login", {
                        email,
                        password,
                        remember_me
                    });
                    location.href = '/';
                } catch (err) {
                    hideLoading();
                    showToast({
                        message: err.message,
                        type: 'warning'
                    });
                }
            }
        }
    }).mount('#login-page');
</script>
@endsection