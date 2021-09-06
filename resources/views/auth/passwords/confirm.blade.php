@extends('layouts.authentication')
@section('title')
    {{ __('section-title.password_confirmation') }}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-4 col-sm-12">
        <form class="card auth_form" method="POST" action="{{ route('password.confirm') }}">
            @csrf
            <div class="header">
                <img class="logo" src="{{asset('img/favicon-web.png')}}" alt="">
                <h5>{{ __('section-title.password_confirmation') }}</h5>
                <span class="px-2">{{ __('messages.confirm_password') }}</span>
            </div>
            <div class="body">
                <div class="form-group mb-3">
                    <div class="input-group">
                        <input id="password" type="password" class="form-control" placeholder="{{ __('label.password') }}" name="password" required>
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="zmdi zmdi-lock"></i></span>
                        </div>
                    </div>
                    @error('password')
                        <label for="password" class="error">{{ $message }}</label>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">{{ __('button-label.confirm_password') }}</button>
                <div class="mt-3">
                    @if (Route::has('password.request'))
                        <a class="text-danger" href="{{ route('password.request') }}">
                            {{ __('label.forgot_password?') }}
                        </a>
                    @endif
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
            <img src="{{asset('assets/images/signin.svg')}}" alt="Forgot Password"/>
        </div>
    </div>
</div>
@stop