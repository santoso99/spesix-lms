<div class="col-lg-6 col-12">
    <div class="form-group mt-0">
        <label>{{ __('label.fullname') }}<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-append">
                <span class="input-group-text"><i class="zmdi zmdi-account"></i></span>
            </div>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $parent->name ?? (old('name') ?? null) }}" required autocomplete="name">
        </div>
        @error('name')
        <div class="form-group">
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        </div>
        @enderror
    </div>
</div>
<div class="col-lg-6 col-12">
    <div class="form-group mt-0">
        <label>{{ __('label.email') }} <span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-append">
                <span class="input-group-text"><i class="zmdi zmdi-email"></i></span>
            </div>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $parent->email ?? (old('email') ?? null)}}" required autocomplete="email" placeholder="mail@mail.com">
        </div>
        @error('email')
        <div class="form-group">
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        </div>
        @enderror
    </div>
</div>
<div class="col-lg-6 col-12">
    <div class="form-group mt-0">
        <label>{{ __('label.password') }}</label>
        <div class="input-group">
            <div class="input-group-append">
                <span class="input-group-text"><i class="zmdi zmdi-lock"></i></span>
            </div>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password" placeholder="{{ isset($parent->password) ? __('messages.leave_password_blank') : __('messages.min_password_char')}}">
        </div>
        @error('password')
        <div class="form-group">
            <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        </div>
        @enderror
    </div>
</div>
<div class="col-lg-6 col-12">
    <div class="form-group">
        <label>{{ __('label.retype_password') }}</label>
        <div class="input-group">
            <div class="input-group-append">
                <span class="input-group-text"><i class="zmdi zmdi-lock"></i></span>
            </div>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
        </div>
    </div>
</div>