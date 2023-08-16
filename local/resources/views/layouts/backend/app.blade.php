<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Vrich (Admin)</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('backend/assets/img/favicon.ico') }}"/>
    <!-- Common Styles Starts -->
    <link href="{{ asset('backend/assets/css/style.css')}}" rel="stylesheet" type="text/css" />
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
    <link href="{{ asset('backend/assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/assets/css/dashboard/dashboard_2.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/plugins/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/assets/css/elements/tooltip.css') }}" rel="stylesheet" type="text/css" />

    <link {{ asset('backend/plugins/animate/animate.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('backend/plugins/sweetalerts/promise-polyfill.js') }}"></script>
    <link {{ asset('backend/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link {{ asset('backend/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link {{ asset('backend/assets/css/basic-ui/custom_sweetalert.css') }}" rel="stylesheet" type="text/css" />


    @yield('css')
    <!-- Page Level Plugin/Style Ends -->
</head>
<body>
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
        <p class="xato-loader-heading">Xato</p>
    </div>
    <!--  Loader Ends -->
    <!--  Navbar Starts  -->
    <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm">
            <ul class="navbar-item theme-brand flex-row  text-center">
                <li class="nav-item theme-logo">
                    <a href="{{ route('admin/Dashboard')}}">
                        <img src="{{ asset('frontend/images/logo.png') }}" class="navbar-logo" alt="logo">
                    </a>
                </li>
                {{-- <li class="nav-item theme-text">
                    <a href="index.html" class="nav-link"> Xato </a>
                </li> --}}
            </ul>
            <ul class="navbar-item flex-row ml-md-0 ml-auto">

            </ul>
            <ul class="navbar-item flex-row ml-md-auto">
                {{-- <li class="nav-item dropdown fullscreen-dropdown d-none d-lg-flex">
                    <a class="nav-link full-screen-mode" href="javascript:void(0);">
                        <i class="las la-compress" id="fullScreenIcon"></i>
                    </a>
                </li> --}}
                {{-- <li class="nav-item dropdown language-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="language-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="las la-language"></i>
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="language-dropdown">
                        <a class="dropdown-item d-flex" href="javascript:void(0);">
                            <img src="{{ asset('backend/assets/img/flag/usa-flag.png')}}" class="flag-width" alt="flag">
                            <span class="align-self-center">&nbsp;English</span>
                        </a>
                        <a class="dropdown-item d-flex" href="javascript:void(0);">
                            <img src="{{ asset('backend/assets/img/flag/spain-flag.png')}}" class="flag-width" alt="flag">
                            <span class="align-self-center">&nbsp;Spanish</span>
                        </a>
                        <a class="dropdown-item d-flex" href="javascript:void(0);">
                            <img src="{{ asset('backend/assets/img/flag/france-flag.png')}}" class="flag-width" alt="flag">
                            <span class="align-self-center">&nbsp;French</span>
                        </a>
                        <a class="dropdown-item d-flex" href="javascript:void(0);">
                            <img src="{{ asset('backend/assets/img/flag/saudi-arabia-flag.png')}}" class="flag-width" alt="flag">
                            <span class="align-self-center">&nbsp;Arabic</span>
                        </a>
                    </div>
                </li> --}}
                {{-- <li class="nav-item dropdown message-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="messageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="las la-envelope"></i>
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="messageDropdown">
                        <div class="nav-drop is-notification-dropdown" >
                            <div class="inner">
                                <div class="nav-drop-header">
                                      <span class="text-black font-12 strong">3 new mails</span>
                                      <a class="text-muted font-12" href="#">
                                        Mark all read
                                      </a>
                                </div>
                                <div class="nav-drop-body account-items pb-0">

                                    <a class="account-item marked-read">
                                        <div class="media">
                                            <div class="user-img">
                                                <img class="rounded-circle avatar-xs" src="{{ asset('backend/assets/img/profile-9.jpg')}}" alt="profile">
                                            </div>
                                            <div class="media-body">
                                                <div class="">
                                                    <h6 class="text-primary font-13 mb-0 strong">Victoria Williamson</h6>
                                                    <p class="m-0 mt-1 font-10 text-muted">Account need to be synced</p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <hr class="account-divider">
                                    <div class="text-center">
                                        <a class="text-primary strong font-13" href="apps_mail.html">View All</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li> --}}
                <li class="nav-item dropdown notification-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle position-relative" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="las la-bell"></i>
                        <div class="blink">
                            <div class="circle"></div>
                        </div>
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="notificationDropdown">
                        <div class="nav-drop is-notification-dropdown" >
                            <div class="inner">
                                <div class="nav-drop-header">
                                      <span class="text-black font-12 strong">5 Notifications</span>
                                      <a class="text-muted font-12" href="#">
                                        Clear All
                                      </a>
                                </div>
                                <div class="nav-drop-body account-items pb-0">
                                    <a class="account-item" href="apps_ecommerce_orders.html">
                                      <div class="media align-center">
                                          <div class="icon-wrap">
                                            <i class="las la-box font-20"></i>
                                          </div>
                                          <div class="media-content ml-3">
                                              <h6 class="font-13 mb-0 strong">2 New orders placed</h6>
                                              <p class="m-0 mt-1 font-10 text-muted">10 sec ago</p>
                                          </div>
                                      </div>
                                    </a>

                                    <hr class="account-divider">
                                    <div class="text-center">
                                        <a class="text-primary strong font-13" href="pages_notifications.html">View All</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown user-profile-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <img src="{{asset('backend/assets/img/profile-16.jpg')}}" alt="avatar">
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                        <div class="nav-drop is-account-dropdown" >
                            <div class="inner">
                                <div class="nav-drop-header">
                                      <span class="text-primary font-15">Welcome Admin !</span>
                                </div>
                                <div class="nav-drop-body account-items pb-0">
                                    <a id="profile-link"  class="account-item" href="pages_profile.html">
                                        <div class="media align-center">
                                            <div class="media-left">
                                                <div class="image">
                                                    <img class="rounded-circle avatar-xs" src="{{ asset('backend/assets/img/profile-16.jpg')}}" alt="">
                                                </div>
                                            </div>
                                            <div class="media-content ml-3">
                                                <h6 class="font-13 mb-0 strong">Vrich</h6>
                                            </div>
                                            <div class="media-right">
                                                <i data-feather="check"></i>
                                            </div>
                                        </div>
                                    </a>
                                    {{-- <a class="account-item" href="pages_profile.html">
                                      <div class="media align-center">
                                          <div class="icon-wrap">
                                            <i class="las la-user font-20"></i>
                                          </div>
                                          <div class="media-content ml-3">
                                              <h6 class="font-13 mb-0 strong">My Account</h6>
                                          </div>
                                      </div>
                                    </a>
                                    <a class="account-item" href="pages_timeline.html">
                                        <div class="media align-center">
                                            <div class="icon-wrap">
                                                <i class="las la-briefcase font-20"></i>
                                            </div>
                                            <div class="media-content ml-3">
                                                <h6 class="font-13 mb-0 strong">My Activity</h6>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="account-item settings">
                                      <div class="media align-center">
                                          <div class="icon-wrap">
                                            <i class="las la-cog font-20"></i>
                                          </div>
                                          <div class="media-content ml-3">
                                              <h6 class="font-13 mb-0 strong">Settings</h6>
                                          </div>
                                      </div>
                                    </a>
                                    <a class="account-item" href="auth_lock_screen_3.html">
                                        <div class="media align-center">
                                            <div class="icon-wrap">
                                                <i class="las la-lock font-20"></i>
                                            </div>
                                            <div class="media-content ml-3">
                                                <h6 class="font-13 mb-0 strong">Lock Screen</h6>
                                            </div>
                                        </div>
                                    </a> --}}
                                    <hr class="account-divider">

                                    <a class="account-item"  href="{{ route('logout_admin') }}"  >

                                        <div class="media align-center">
                                            <div class="icon-wrap">
                                                <i class="las la-sign-out-alt font-20"></i>
                                            </div>
                                            <div class="media-content ml-3">
                                                <h6 class="font-13 mb-0 strong ">Logout</h6>
                                            </div>
                                        </div>
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            {{-- <ul class="navbar-item flex-row">
                <li class="nav-item dropdown header-setting">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle rightbarCollapse" data-placement="bottom">
                        <i class="las la-sliders-h"></i>
                    </a>
                </li>
            </ul> --}}
        </header>
    </div>
    <!--  Navbar Ends  -->
    <!--  Main Container Starts  -->


    <div class="main-container" id="container">
        <div class="overlay"></div>
        <div class="search-overlay"></div>
        <div class="rightbar-overlay"></div>
        <!--  Top Menu Bar Starts  -->


        @include('layouts.backend.sidebar')
        <!--  Top Menu Bar Ends  -->
        <!--  Content Area Starts  -->
        <div id="content" class="main-content">
            <!--  Navbar Starts / Breadcrumb Area  -->
            <div class="sub-header-container">
                <header class="header navbar navbar-expand-sm">
                    <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom">
                        <i class="las la-bars"></i>
                    </a>
                    <ul class="navbar-nav flex-row">
                        <li>
                            <div class="page-header">
                                {{-- <nav class="breadcrumb-one" aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboards</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><span>Dashboard 1</span></li>
                                    </ol>
                                </nav> --}}
                                @yield('page-header')
                            </div>
                        </li>
                    </ul>
                    {{-- <ul class="navbar-nav d-flex align-center ml-auto right-side-filter">
                        <li class="nav-item more-dropdown">
                            <div class="input-group input-group-sm">
                                <input id="rangeCalendarFlatpickr" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Select Date">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-primary border-primary" id="basic-addon2">
                                        <i class="lar la-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item more-dropdown">
                            <a href="javascript: void(0);" data-original-title="Reload Data" data-placement="bottom" class="btn btn-primary dash-btn btn-sm ml-2 bs-tooltip">
                                <i class="las la-sync"></i>
                            </a>
                        </li>
                        <li class="nav-item custom-dropdown-icon">
                            <a href="javascript: void(0);" data-original-title="Filter" data-placement="bottom" id="customDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-primary dash-btn btn-sm ml-2 bs-tooltip">
                                <i class="las la-filter"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="customDropdown">
                                <a class="dropdown-item" data-value="Filter 1" href="javascript:void(0);">Filter 1</a>
                                <a class="dropdown-item" data-value="Filter 2" href="javascript:void(0);">Filter 2</a>
                                <a class="dropdown-item" data-value="Filter 3" href="javascript:void(0);">Filter 3</a>
                            </div>
                        </li>
                    </ul> --}}
                </header>
            </div>
            <!--  Navbar Ends / Breadcrumb Area  -->
            <!-- Main Body Starts -->
            <div class="layout-px-spacing">
             @yield('content')
            </div>
            <!-- Main Body Ends -->
            {{-- <div class="responsive-msg-component">
                <p>
                    <a class="close-msg-component"><i class="las la-times"></i></a>
                    Please reload the page to view the responsive functionalities
                </p>
            </div> --}}
            <!-- Copyright Footer Starts -->
            <div class="footer-wrapper">
                {{-- <div class="footer-section f-section-1">
                    <p class="">Copyright © 2021 <a target="_blank" href="https://xato-web.web.app/">XatoWeb</a>, All rights reserved.</p>
                </div>
                <div class="footer-section f-section-2">
                    <p class="">Crafted with extra <i class="las la-heart text-danger"></i></p>
                </div> --}}
            </div>
            <!-- Copyright Footer Ends -->
            <!-- Arrow Starts -->
            <div class="scroll-top-arrow" style="display: none;">
                <i class="las la-angle-up"></i>
            </div>
            <!-- Arrow Ends -->
        </div>
        <!--  Content Area Ends  -->
        <!--  Rightbar Area Starts -->
        <div class="right-bar">
            <div class="h-100">
                <div class="simplebar-wrapper" style="margin: 0px;">
                    <div class="simplebar-mask">
                        <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                            <div class="simplebar-content-wrapper" style="height: 100%;">
                                <div class="simplebar-content" style="padding: 0px;">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs nav-bordered nav-justified" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link  active" data-toggle="tab" href="#chat-tab" role="tab" aria-selected="true">
                                                <i class="las la-sms"></i>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " data-toggle="tab" href="#status-tab" role="tab" aria-selected="false">
                                                <i class="las la-tasks"></i>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " data-toggle="tab" href="#settings-tab" role="tab" aria-selected="false">
                                                <i class="las la-cog"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- Tab panes starts -->
                                    <div class="tab-content pt-0 rightbar-tab-container">
                                        <div class="tab-pane active rightbar-tab" id="chat-tab" role="tabpanel">
                                            <form class="search-bar p-3">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control search-form-control" placeholder="Search">
                                                    <span class="mdi mdi-magnify"></span>
                                                </div>
                                            </form>
                                            <h6 class="right-bar-heading px-3 mt-2 text-uppercase">Chat Groups</h6>
                                            <div class="p-2">
                                                <a href="javascript: void(0);" class="text-reset group-item pl-3 mb-2 d-block">
                                                    <i class="las la-dot-circle mr-1 text-success"></i>
                                                    <span class="mb-0 mt-1 text-success">Backend Team</span>
                                                </a>
                                                <a href="javascript: void(0);" class="text-reset group-item pl-3 mb-2 d-block">
                                                    <i class="las la-dot-circle mr-1 text-warning"></i>
                                                    <span class="mb-0 mt-1 text-warning">Frontend Team</span>
                                                </a>
                                                <a href="javascript: void(0);" class="text-reset group-item pl-3 mb-2 d-block">
                                                    <i class="las la-dot-circle mr-1 text-danger"></i>
                                                    <span class="mb-0 mt-1 text-danger">Back Office</span>
                                                </a>
                                                <a href="javascript: void(0);" class="text-reset group-item pl-3 d-block">
                                                    <i class="las la-dot-circle mr-1 text-info"></i>
                                                    <span class="mb-0 mt-1 text-info">Personal</span>
                                                </a>
                                            </div>
                                            <h6 class="right-bar-heading px-3 mt-2 text-uppercase">My Favourites <a href="javascript: void(0);"><i class="las la-angle-right"></i></i></a></h6>

                                            <h6 class="right-bar-heading px-3 mt-2 text-uppercase">Chats <a href="javascript: void(0);"><i class="las la-angle-right"></i></i></a></h6>

                                        </div>

                                        <div class="tab-pane rightbar-tab" id="settings-tab" role="tabpanel">
                                            <h6 class="right-bar-heading p-2 px-3 mt-2 text-uppercase">Account Setting </h6>
                                            <div class="px-2">
                                                <div class="switch-container mb-3 pl-2">
                                                    <label class="switch">
                                                        <input type="checkbox" checked>
                                                        <span class="slider round primary-switch"></span>
                                                    </label>
                                                    <p class="ml-3 text-dark">Sync Contacts</p>
                                                </div>
                                                <div class="switch-container mb-3 pl-2">
                                                    <label class="switch">
                                                        <input type="checkbox">
                                                        <span class="slider round primary-switch"></span>
                                                    </label>
                                                    <p class="ml-3 text-dark">Auto Update</p>
                                                </div>
                                                <div class="switch-container mb-3 pl-2">
                                                    <label class="switch">
                                                        <input type="checkbox">
                                                        <span class="slider round primary-switch"></span>
                                                    </label>
                                                    <p class="ml-3 text-dark">Recieve Notifications</p>
                                                </div>
                                            </div>
                                            <h6 class="right-bar-heading p-2 px-3 mt-2 text-uppercase">Mail Setting </h6>


                                        </div>
                                    </div>
                                    <!-- Tab panes ends -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  Rightbar Area Ends -->
    </div>

    <!-- Main Container Ends -->
    <!-- Common Script Starts -->
    <script src="{{ asset('backend/assets/js/libs/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('backend/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('backend/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="{{ asset('backend/assets/js/custom.js') }}"></script>
    <!-- Common Script Ends -->
    <script src="{{ asset('backend/assets/js/loader.js') }}"></script>

    <script src="{{ asset('backend/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/basicui/sweet_alerts.js') }}"></script>
    @include('layouts.frontend.flash-message')
    {{-- <script src="{{ asset('backend/plugins/apex/apexcharts.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('backend/assets/js/dashboard/dashboard_1.js') }}"></script> --}}
    <!-- Page Level Plugin/Script Ends -->
    @yield('js')
</body>
</html>
