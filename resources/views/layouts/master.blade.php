<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon-web.png')}}">
        <title>@yield('title') | {{ config('app.name') }}</title>
        <meta name="description" content="@yield('meta_description', config('app.name'))">
        <meta name="author" content="@yield('meta_author', config('app.name'))">
        @yield('meta')

        @yield('before-styles')
        <!-- Bootstrap -->
        <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}">

        <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
        
        @if (trim($__env->yieldContent('page-style')))
            @yield('page-style')
        @endif
        <!-- Custom Css -->
        <link rel="stylesheet" href="{{asset('assets/css/style.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/custom-style.css')}}">
        @yield('after-styles')

        @laravelPWA
    
        @unlessrole('Siswa')
        <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
        <script>
        window.OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
            OneSignal.init({
            appId: "{!! config('services.onesignal.app_id') !!}",
            notifyButton: {
                enable: true,
            },
            allowLocalhostAsSecureOrigin: true,
            });
        });
        </script>
        @endunlessrole
    </head>
    <?php 
        $setting = !empty($_GET['theme']) ? $_GET['theme'] : '';
        $theme = "theme-purple";

        if (Request::segment(2) === 'rtl' ){
            $theme .= " rtl";
        }
    ?>
    <body class="<?= $theme ?>">
        <!-- Page Loader -->
        <div class="page-loader-wrapper">
            <div class="loader">
                <div class="m-t-30"><img class="zmdi-hc-spin" src="{{asset('assets/images/loader.svg')}}" width="48" height="48" alt="{{ config('app.name') }}"></div>
                <p>Please wait...</p>        
            </div>
        </div>
        <!-- Overlay For Sidebars -->
        <div class="overlay"></div>
        @include('layouts.navbarright')
        @include('layouts.sidebar')
        @include('layouts.rightsidebar')
        <section class="content">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-7 col-md-6 col-sm-12">
                        <h2>@yield('title')</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{\LaravelLocalization::localizeURL('/')}}"><i class="zmdi zmdi-home"></i> {{ config('app.name') }}</a></li>
                            @if (trim($__env->yieldContent('parentPageTitle')))
                                <li class="breadcrumb-item">@yield('parentPageTitle')</li>
                            @endif
                            @if (trim($__env->yieldContent('title')))
                                <li class="breadcrumb-item active">@yield('title')</li>
                            @endif
                        </ul>
                        <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                    </div>            
                    <div class="col-lg-5 col-md-6 col-sm-12">
                        <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                    </div>
                </div>
            </div>
            <div class="container-fluid">                
                @yield('content')
            </div>
        </section>
        @yield('modal')
        <!-- Scripts -->
        @stack('before-scripts')
        <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>    
        <script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>

        <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>

        <script src="{{ asset('js/custom.js') }}"></script>

        @stack('after-scripts')
        @if (trim($__env->yieldContent('page-script')))
            @yield('page-script')
		@endif
    </body>
</html>