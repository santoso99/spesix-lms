@extends('layouts.authentication')
@section('title')
    {{ __('menu-label.register') }}
@endsection
@section('content')
<div class="row pb-3">
    <div class="col-lg-4 col-sm-12">
        @if (session('unavailable'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span>{{ session('unavailable') }}</span><a id="closeAlert" class="text-danger ml-2 float-right" href=""><span class="fas fa-times"></span></a>
        </div>
        @endif
        <form class="card auth_form mt-5" method="POST" action="{{ route('register.admin') }}">
            @csrf
            <div class="header">
                <a href="{{\LaravelLocalization::localizeURL('/')}}">
                    <img class="logo" src="{{asset('img/favicon-web.png')}}" alt="">
                </a>
                <h5>{{ __('menu-label.register') }}</h5>
            </div>
            <div class="body">
                
                <div class="form-group mb-3">
                    <div class="input-group">
                        <input id="name" type="text" class="form-control" placeholder="{{ __('label.name') }}" name="name" value="{{ old('name') }}" required>
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>
                        </div>
                    </div>
                    @error('name')
                        <label for="name" class="error">{{ $message }}</label>
                    @enderror
                </div>

                @include('auth.register-form')
                
                <div class="form-group mb-3">
                    <div class="input-group">
                        <input id="security-code" type="password" class="form-control" placeholder="{{ __('label.security_code') }}" name="security_code" required>
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="zmdi zmdi-key"></i></span>
                        </div>
                    </div>
                    @error('security_code')
                        <label for="security-code" class="error">{{ $message }}</label>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">{{ __('menu-label.register') }}</button>
                <div class="signin_with mt-3">
                    <a class="link" href="{{route('login')}}">{{ __('messages.already_have_account?') }}</a>
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
            <img src="{{asset('assets/images/signup.svg')}}" alt="Sign Up" />
        </div>
    </div>
</div>
@stop

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#registrationForm').validate({
                rules: {
                    identity_number: 'required',
                    pob: 'required',
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                        minlength: 8,
                    },
                },
                messages: {
                    identity_number: '{!! __("messages.identity_no_form") !!}',
                    pob: '{!! _("messages.pob_form") !!}',
                    email: '{!! _("messages.email_form") !!}',
                    password: '{!! _("messages.password_form") !!}',
                },
                errorPlacement: function(error, element){
                    error.insertAfter(element.parent().next());
                },
                submitHandler: function(form){
                    form.submit();
                }
            });
        });
    </script>
@endpush