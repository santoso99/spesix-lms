<!doctype html>
<html class="no-js" lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon-web.png')}}">
    <!-- Normalize CSS -->
    <link rel="stylesheet" href="{{asset('css/normalize.css')}}">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{asset('css/all.min.css')}}">
    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="{{asset('fonts/flaticon.css')}}">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{asset('css/animate.min.css')}}">
    <!-- Date Picker CSS -->
    <link rel="stylesheet" href="{{asset('css/datepicker.min.css')}}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('style.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom-auth.css')}}">
    <!-- Modernize js -->
    <script src="{{asset('js/modernizr-3.6.0.min.js')}}"></script>
</head>

<body>
    <!-- Preloader Start Here -->
    <div id="preloader"></div>
    <!-- Preloader End Here -->
    <!-- Login Page Start Here -->
    <div class="login-page-wrap">
        <div class="login-page-content">
            <div class="login-box">
                <div class="item-logo">
                    <img src="{{asset('img/favicon-web.png')}}" alt="logo" width="70px">
                    <h3 class="font-weight-bold mt-3" style="color:#1F4688;">{{ config('app.name') }}</h3>
                </div>
                @yield('content')
            </div>
        </div>
    </div>
    <!-- Login Page End Here -->
    <!-- jquery-->
    <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
    <!-- Plugins js -->
    <script src="{{asset('js/plugins.js')}}"></script>
    <!-- Popper js -->
    <script src="{{asset('js/popper.min.js')}}"></script>
    <!-- Bootstrap js -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    {{-- JQuery Validation --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
    <!-- Scroll Up Js -->
    <script src="{{asset('js/jquery.scrollUp.min.js')}}"></script>
    <!-- Date Picker Js -->
    <script src="{{asset('js/datepicker.min.js')}}"></script>
    <!-- Custom Js -->
    <script src="{{asset('js/main.js')}}"></script>

    @stack('scripts')

</body>

</html>