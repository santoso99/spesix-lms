<!doctype html>
<html class="no-js" lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta name="description" content="E Learning SMP N 6 Semarang">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon-web.png')}}">
    <!-- Normalize CSS -->
    <link rel="stylesheet" href="{{asset('css/normalize.css')}}">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{asset('css/all.min.css')}}">
    <!-- Flaticon CSS -->
    <link rel="stylesheet" href="{{asset('fonts/flaticon.css')}}">

    @yield('before-styles')

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{asset('style.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom-icon-style.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <!-- Modernize js -->
    <script src="{{asset('js/modernizr-3.6.0.min.js')}}"></script>

    <link href="https://fonts.googleapis.com/css?family=Roboto|Ubuntu&display=swap" rel="stylesheet">
    
    @laravelPWA
    
    @auth
      @unlessrole('Siswa')
      <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
      <script>
        // let user_role = '{!! Auth::user()->roles[0]->name !!}'

        window.OneSignal = window.OneSignal || [];
        // OneSignal.push(["sendTag","user_role",user_role]);
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
    @endauth

</head>
<body class="bg-light">
	<!-- Preloader Start Here -->
    <div id="preloader"></div>

    <div id="wrapper" class="wrapper">
    	<!-- Header Menu Area Start Here -->
    	<div class="header-menu-one">
    		<div class="navbar navbar-expand-md navbar-light">
            <a class="navbar-brand" href="{{\LaravelLocalization::localizeURL('/')}}"><img src="{{asset('img/logo-web.png')}}" width="70"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarToggler">
              <ul class="navbar-nav mt-2 mt-lg-0 mr-auto align-items-center">
                <li class="nav-item {{($home_menu == '') ? 'active' : ''}}">
                  <a class="nav-link" href="{{\LaravelLocalization::localizeURL('/')}}">{{ __('menu-label.home') }}</a>
                </li>
                <li class="nav-item {{($home_menu == 'topics') ? 'active' : ''}}">
                  <a class="nav-link" href="{{\LaravelLocalization::localizeURL('topics')}}">{{ __('menu-label.topic') }}</a>
                </li>
                @hasrole('Siswa')
                <li class="nav-item {{($home_menu == 'my-topics') ? 'active' : ''}}">
                  <a class="nav-link" href="{{\LaravelLocalization::localizeURL('my-topics')}}">{{ __('menu-label.my_topic') }}</a>
                </li>
                @endhasrole
                <li class="nav-item {{($home_menu == 'exams') ? 'active' : ''}}">
                  <a class="nav-link" href="{{\LaravelLocalization::localizeURL('exams')}}">{{ __('menu-label.evaluation') }}</a>
                </li>
                @hasanyrole('Pengajar|Supervisor|Admin')
                  <li class="nav-item {{($home_menu == 'sops') ? 'active' : ''}}">
                    <a class="nav-link" href="{{\LaravelLocalization::localizeURL('sops')}}">{{ __('menu-label.sop_file') }}</a>
                  </li>
                @endhasanyrole
                <li class="nav-item {{($home_menu == 'contacts') ? 'active' : ''}}">
                  <a class="nav-link" href="{{\LaravelLocalization::localizeURL('contacts')}}">{{ __('menu-label.contact') }}</a>
                </li>
                <li class="nav-item">
                  <a class="btn btn-sm btn-pastel-orange btn-rounded text-light" href="https://drive.google.com/file/d/13-b9qSvL9uwVJMkR5GLudhFESutTEJK3/view?usp=sharing">{{ __('menu-label.manual_book') }}</a>
                </li>
              </ul>
              <div class="navbar-icon-wrapper">
                <a href="https://www.facebook.com" class="socmed-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com/" class="socmed-icon"><i class="fab fa-twitter"></i></a>
                <a href="https://www.instagram.com/" class="socmed-icon"><i class="fab fa-instagram"></i></a>
                <a href="https://www.linkedin.com/company" class="socmed-icon"><i class="fab fa-linkedin"></i></a>
                <a href="#" class="socmed-icon"><i class="fa fa-envelope"></i></a>
              </div>
              @guest()
              <a href="{{route('register')}}" class="btn btn-lg btn-outline-royal-blue btn-rounded mr-2">{{ __('menu-label.register') }}</a>
              <a href="{{route('login')}}" class="btn btn-lg btn-royal-blue btn-rounded btn-login text-light mr-2">{{ __('menu-label.login') }}</a>
              <a href="{{route('register')}}" class="btn btn-outline-royal-blue btn-sm-login">{{ __('menu-label.register') }}</a>
              <a href="{{route('login')}}" class="btn btn-royal-blue btn-sm-login text-light">{{ __('menu-label.login') }}</a>
              @endguest
              @auth()
              <form action="{{route('logout')}}" method="post">
                @csrf
                <a href="{{\LaravelLocalization::localizeURL('dashboard')}}" class="btn btn-lg btn-royal-blue btn-rounded mr-2 btn-login text-light">{{ __('menu-label.dashboard') }}</a>
                <button type="submit" class="btn btn-lg btn-outline-royal-blue btn-rounded btn-login mr-2">{{ __('menu-label.logout') }}</button>
                <a href="{{\LaravelLocalization::localizeURL('dashboard')}}" class="btn btn-royal-blue btn-sm-login text-light">{{ __('menu-label.dashboard') }}</a>
                <button type="submit" class="btn btn-outline-royal-blue btn-sm-login">{{ __('menu-label.logout') }}</button>
              </form>
              @endauth
              <div id="langSelect" class="dropdown">
                <a class="btn bg-transparent text-dark dropdown-toggle text-uppercase" href="#" role="button" 
                  data-toggle="dropdown" aria-expanded="false" id="languangeDropdown">{{ LaravelLocalization::getCurrentLocale() }}</a>
                <div class="dropdown-menu" aria-labelledby="languangeDropdown">
                  @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                      {{ $properties['native'] }}
                    </a>
                  @endforeach
                </div>
              </div>
            </div>
	        </div>
      </div>

      @yield('content')

      <footer class="footer">
        <div class="container">
          <div class="footer-bottom">
              <div class="copyright">{{ __('label.developed_by') }} Dody Sumardi &copy; {{ date('Y') }}. All rights reserved.</div>
              <div class="footer-icon">
              <a href="https://www.facebook.com"><i class="fab fa-facebook-f"></i></a>
              <a href="https://twitter.com"><i class="fab fa-twitter"></i></a>
              <a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>
              <a href="https://www.linkedin.com/company"><i class="fab fa-linkedin"></i></a>
              <a href="#"><i class="fa fa-envelope"></i></a>
              </div>
          </div>
        </div>
    </footer>
</div>

<!-- jquery-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Plugins js -->
<script src="{{asset('js/plugins.js')}}"></script>
<!-- Popper js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<!-- Bootstrap js -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<!-- Scroll Up Js -->
<script src="{{asset('js/jquery.scrollUp.min.js')}}"></script>

@stack('scripts')

<!-- Custom Js -->
{{-- <script src="{{asset('js/main.js')}}"></script> --}}

<script src="{{asset('js/custom.js')}}"></script>

@stack('after-scripts')
</body>
</html>