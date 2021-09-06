@extends('layouts.authentication')
@section('title')
    {{ __('section-title.password_reset') }}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-4 col-sm-12">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <form class="card auth_form" method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="header">
                <img class="logo" src="{{asset('img/favicon-web.png')}}" alt="">
                <h5>{{ __('label.forgot_password?') }}</h5>
                <span>{{ __('messages.email_for_reset_password') }}</span>
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
                <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">{{ __('button-label.send_reset_password_link') }}</button>                        
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