@extends('layouts.authentication')
@section('title')
    {{ __('menu-label.login') }}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-4 col-sm-12">
        @if(session('resent'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('resent') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <form class="card auth_form" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="header">
                <a href="{{\LaravelLocalization::localizeURL('/')}}">
                    <img class="logo" src="{{asset('img/favicon-web.png')}}" alt="">
                </a>
                <h5>{{ __('menu-label.login') }}</h5>
            </div>
            <div class="body">
                <div class="form-group mb-3">
                    <div class="input-group">
                        <input id="email" type="email" class="form-control" name="email" value="{{old('email')}}" autocomplete required placeholder="{{ __('label.email') }}">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="zmdi zmdi-email"></i></span>
                        </div>
                    </div>
                    @error('email')
                        <label for="name" class="error">{{ $message }}</label>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <div class="input-group">
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password" required autocomplete="current-password">
                        <div class="input-group-append">                                
                            <span class="input-group-text"><i class="zmdi zmdi-lock"></i></span>
                        </div>                            
                    </div>
                    @error('password')
                        <label for="password" class="error">{{ $message }}</label>
                    @enderror
                </div>
                <div class="form-group d-flex align-items-center justify-content-between">
                    <div class="checkbox">
                        <input id="remember_me" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember_me">{{ __('label.remember_me') }}</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="text-danger" href="{{ route('password.request') }}">
                            {{ __('label.forgot_password?') }}
                        </a>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">{{ __('menu-label.login') }}</button>
                <div class="mt-3 text-center">
                    {{ __('label.dont_have_account') }} 
                    <a href="{{route('register')}}">{{ __('label.register_here') }}</a>
                </div>
            </div>
        </form>
        <div class="copyright text-center">
            &copy;
            <script>document.write(new Date().getFullYear())</script>
            <span>{{ config('app.name') }} | All Rights Reserved.</span>
        </div>
    </div>
    <div class="col-lg-8 col-sm-12 auth-img">
        <div class="card">
            <img src="{{asset('assets/images/signin.svg')}}" alt="Login"/>
        </div>
    </div>
</div>
@stop