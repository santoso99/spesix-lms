@extends('layouts.authentication')
@section('title')
    {{ __('section-title.verify_email') }}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-4 col-sm-12">
        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif
        <form class="card auth_form" method="POST" action="{{ route('verification.resend') }}">
            @csrf

            <div class="header">
                <img class="logo" src="{{asset('img/favicon-web.png')}}" alt="">
                <h5>{{ __('section-title.verify_email') }}</h5>
                <div class="px-2">
                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    <br>
                    {{ __('If you did not receive the email') }},
                    <br>
                </div>
            </div>
            <div class="body">
                
                <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">{{ __('click here to request another') }}</button>                        
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