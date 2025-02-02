@extends('portal_layout.templates')
@section('content')

@php
    $hideHeaderFooter = true;
@endphp
<style>
    /* Add the Poppins font */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
    body {
        font-family: 'Poppins';
    }
    main#login-page {
        background: #FBD9C0;
        height: 100vh;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-plain {
            margin: 50px 0 0 0;
        }

        .col-md-6 {
            margin-top: 15px; 
        }

        img {
            max-width: 100%;
            height: auto; 
        }
    }
</style>

<main id="login-page" class="main-content mt-0" style="background: #6999bb;">
    <section>
        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row">
                    <div style="display: flex; justify-content: center;">
                        <div class="card card-plain" style="max-width: 1100px; height: 550px; border-radius: 30px; margin: 92px 0 0 15px;">
                            <div class="row">
                                <div class="col-md-12" style="text-align: center; margin-top: 20px;">
                                    <img src="../img/portal/logo.png" width="160" height="100"/>
                                </div>
                                <div class="col-md-6" style="display: flex; align-items: center; justify-content: center; margin-top: 25px;">
                                    <div style="text-align: center;">
                                        <img src="{{URL::asset('/img/portal/login-dashboard.jpg')}}" width="450" height="357"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div style="padding-right: 24px;">
                                        <br>
                                        <h1 style="text-align: center; font-weight: bold; color: #rgba(0, 0, 0, 0.90);">Dashboard Aspoo Login</h1>
                                        <br>
                                        <form role="form">
                                            <div class="mb-3">
                                                <input v-model="username" type="email" class="form-control form-control-lg" placeholder="email" aria-label="email">
                                            </div>
                                            <div class="mb-3">
                                                <input v-model="password" type="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password">
                                            </div>
                                            <div class="text-center">
                                                <button @click="login" type="button" class="btn btn-lg btn-lg w-100 mt-4 mb-0" style="background-color: #3A6381; color: white; font-weight: bold;">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script>
    createApp({
        data() {
            return {
                username: "<?= (env("APP_ENV") == "local"?"developer@gmail.com" :"")?>",
                password: "<?= (env("APP_ENV") == "local"?"kecilsemuatanpaspasi" :"")?>",
                remember_me: false
            }
        },
        methods: {
            async login() {
                try {
                    showLoading()
                    const {
                        username,
                        password,
                        remember_me
                    } = this
                    const response = await httpClient.post('/user/login', {
                        username,
                        password,
                        remember_me
                    })
                    location.href = "/dashboard"
                } catch (err) {
                    hideLoading()
                    showToast({
                        message: err.message,
                        type: "warning"
                    })
                }
            }
        }
    }).mount('#login-page')
</script>
@endsection