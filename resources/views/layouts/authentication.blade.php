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

        @stack('before-styles')

        <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/style.min.css')}}">
        <style>
            .auth-img {
                display: block;
            }
            @media(max-width: 480px) {
                .auth-img {
                    display: none;
                }
            }
        </style>
        @stack('after-styles')
    </head>    
    <?php 
        $setting = !empty($_GET['theme']) ? $_GET['theme'] : '';
        $theme = "theme-cyan";
        $menu = "";
        if ($setting == 'p') {
            $theme = "theme-purple";
        } else if ($setting == 'b') {
            $theme = "theme-blue";
        } else if ($setting == 'g') {
            $theme = "theme-green";
        } else if ($setting == 'o') {
            $theme = "theme-orange";
        } else if ($setting == 'bl') {
            $theme = "theme-blush";
        } else {
             $theme = "theme-cyan";
        }

    ?>
    <body class="<?= $theme ?>">
    <div class="authentication">
        <div class="container">
            @yield('content')
        </div>
    </div>

        <!-- Scripts -->
        @stack('before-scripts')
        <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>    
        <script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
        @stack('scripts')        
    </body>
</html>
