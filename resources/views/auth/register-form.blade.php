<div class="form-group mb-3">
    <div class="input-group">
        <input id="identity_number" type="text" class="form-control" placeholder="{{ __('label.reg_number') }}" name="identity_number" value="{{ old('identity_number') }}" required autocomplete="identity_number">
        <div class="input-group-append">
            <span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>
        </div>
    </div>
    @error('identity_number')
        <label for="identity_number" class="error">{{ $message }}</label>
    @enderror
</div>
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