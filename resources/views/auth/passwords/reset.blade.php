@extends('layouts.authentication')
@section('title')
    {{ __('section-title.password_reset') }}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-4 col-sm-12">

        <form class="card auth_form" method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <div class="header">
                <img class="logo" src="{{asset('img/favicon-web.png')}}" alt="">
                <h5>{{ __('section-title.password_reset') }}</h5>
            </div>
            <div class="body">
                <div class="form-group mb-3">
                    <div class="input-group">
                        <input id="email" type="email" class="form-control" placeholder="{{ __('label.email') }}" name="email" value="{{ old('email') }}" required autocomplete="email">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="zmdi zmdi-email"></i></span>
                        </div>
                    </div>
                    @error('email')
                        <label for="email" class="error">{{ $message }}</label>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <div class="input-group">
                        <input id="password" type="password" class="form-control" placeholder="{{ __('label.password').' ('.__('messages.password_min_char').')' }}" name="password" value="{{ old('password') }}" required autocomplete="new-password">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="zmdi zmdi-lock"></i></span>
                        </div>
                    </div>
                    @error('password')
                        <label for="password" class="error">{{ $message }}</label>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <div class="input-group">
                        <input id="password-confirm" type="password" class="form-control" placeholder="{{ __('label.retype_password') }}" name="password_confirmation" required autocomplete="new-password">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="zmdi zmdi-lock"></i></span>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">{{ __('button-label.reset_password') }}</button>                        
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
            <img src="{{asset('assets/images/signin.svg')}}" alt="Forgot Password"/>
        </div>
    </div>
</div>
@stop