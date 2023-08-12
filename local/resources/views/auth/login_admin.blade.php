<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title> Vrich </title>
    {{-- <link rel="icon" type="image/x-icon" href="{{ asset ('backend/assets/img/favicon.ico') }}"/> --}}
    <link href="{{ asset('backend/assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('backend/assets/js/loader.js') }}"></script>
    <!-- Common Styles Starts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('backend/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/css/main.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/assets/css/structure.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/plugins/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/plugins/highlight/styles/monokai-sublime.css') }}" rel="stylesheet" type="text/css" />
    <!-- Common Styles Ends -->
    <!-- Common Icon Starts -->
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <!-- Common Icon Ends -->
    <!-- Page Level Plugin/Style Starts -->
    <link href="{{ asset('backend/plugins/owl-carousel/owl.carousel.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/plugins/owl-carousel/owl.theme.default.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/assets/css/authentication/auth_1.css') }}" rel="stylesheet" type="text/css">

    <script src="{{ asset('backend/plugins/sweetalerts/promise-polyfill.js') }}"></script>
    <link {{ asset('backend/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link {{ asset('backend/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link {{ asset('backend/assets/css/basic-ui/custom_sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <!-- Page Level Plugin/Style Ends -->
</head>
<body class="login-one">
    <!-- Loader Starts -->
    <div id="load_screen">
        <div class="boxes">
            <div class="box">
                <div></div><div></div><div></div><div></div>
            </div>
            <div class="box">
                <div></div><div></div><div></div><div></div>
            </div>
            <div class="box">
                <div></div><div></div><div></div><div></div>
            </div>
            <div class="box">
                <div></div><div></div><div></div><div></div>
            </div>
        </div>
        {{-- <p class="xato-loader-heading">Xato</p> --}}
    </div>
    <!--  Loader Ends -->
    <!-- Main Body Starts -->
    <div class="container-fluid login-one-container">
        <div class="p-30 h-100" >
            <div class="row main-login-one h-100">

                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 p-0">

                    <div class="login-one-start">
                        <form method="POST" action="{{ route('admin_login') }}">
                            @csrf

                            <div class="text-center"> <img src="{{ asset('frontend/images/logo.png') }}" width="400" class="logo" /> </div>
                        {{-- <h6 class="mt-2 text-primary text-center font-20">Admin Log In</h6> --}}
                        <p class="text-center text-muted mt-3 mb-3 font-14">Admin Log In</p>

                        <div class="login-one-inputs mt-5">
                            <input type="text"  name="username" value="{{ old('username') }}" placeholder="Username" maxlength="10"/>
                            <i class="las la-user-alt"></i>
                        </div>
                        <div class="login-one-inputs mt-3">
                            <input type="password" id="password" name="password"  placeholder="Password" maxlength="10"/>
                            <i class="las la-lock"></i>
                        </div>
                        {{-- <div class="login-one-inputs check mt-4">
                            <input class="inp-cbx" id="cbx" type="checkbox" style="display: none">
                            <label class="cbx" for="cbx">
                                <span>
                                    <svg width="12px" height="10px" viewBox="0 0 12 10">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                    </svg>
                                </span>
                                <span class="font-13 text-muted">Remember me ?</span>
                            </label>
                        </div> --}}
                        <div class="login-one-inputs mt-4">
                            <button type="submit" class="ripple-button ripple-button-primary btn-lg btn-login" type="button">
                                <div class="ripple-ripple js-ripple">
                                <span class="ripple-ripple__circle"></span>
                                </div>
                                LOG IN
                            </button>
                        </div>

                    </form>
                        {{-- <div class="login-one-inputs mt-4 text-center font-12 strong">
                            <a href="auth_forget_password_1.html" class="text-primary">Forgot your Password ?</a>
                        </div>
                        <div class="login-one-inputs social-logins mt-4">
                            <div class="social-btn"><a href="#" class="fb-btn"><i class="lab la-facebook-f"></i></a></div>
                            <div class="social-btn"><a href="#" class="twitter-btn"><i class="lab la-twitter"></i>
                            </a></div>
                            <div class="social-btn"><a href="#" class="google-btn"><i class="lab la-google-plus"></i>
                            </a></div>
                        </div> --}}
                    </div>

                </div>

                <div class="col-xl-8 col-lg-6 col-md-6 d-none d-md-block p-0">
                    <div class="slider-half">
                        <div class="slide-content">

                            <div class="clearfix"></div>
                            <div class="owl-carousel owl-theme">
                                <div class="item">
                                    <i class="lar la-grin-alt font-45 text-white"></i>
                                    <h2 class="font-30 text-white mt-2">Start your journey</h2>
                                    <p class="summary-count text-white font-12 mt-2 slide-text" >Everyone has been made for some particular work, and the desire for that work has been put in every heart</p>
                                </div>
                                <div class="item">
                                    <i class="lar la-clock font-45 text-white"></i>
                                    <h2 class="font-30 text-white mt-2">Save your time</h2>
                                    <p class="summary-count text-white font-12 mt-2 slide-text" >Everyone has been made for some particular work, and the desire for that work has been put in every heart</p>
                                </div>
                                <div class="item">
                                    <i class="las la-hand-holding-usd font-45 text-white"></i>
                                    <h2 class="font-30 text-white mt-2">Save your money</h2>
                                    <p class="summary-count text-white font-12 mt-2 slide-text" >Everyone has been made for some particular work, and the desire for that work has been put in every heart</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Body Ends -->
    <!-- Page Level Plugin/Script Starts -->
    <script src="{{ asset('backend/assets/js/libs/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/owl-carousel/owl.carousel.js') }}"></script>
    <script src="{{ asset('backend/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/authentication/auth_1.js') }}"></script>
    @include('layouts.frontend.flash-message')
    <!-- Page Level Plugin/Script Ends -->
</body>
</html>
