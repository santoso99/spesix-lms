<div class="col-lg-6 col-12">
    <div class="form-group mt-0">
        <label>{{ __('label.employee_reg_number') }} <span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-append">
                <span class="input-group-text"><i class="zmdi zmdi-account"></i></span>
            </div>
            <input id="identity_number" type="text" class="form-control @error('identity_number') is-invalid @enderror" name="identity_number" value="{{ $teacher->identity_number ?? (old('identity_number') ?? null)}}" required autocomplete="identity_number" autofocus placeholder="123xxxx">
        </div>
        @error('identity_number')
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
        <label>{{ __('label.fullname') }} <span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-append">
                <span class="input-group-text"><i class="zmdi zmdi-account"></i></span>
            </div>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $teacher->name ?? (old('name') ?? null) }}" required autocomplete="name">
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
        <label>{{ __('label.pob') }} <span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-append">
                <span class="input-group-text"><i class="zmdi zmdi-account"></i></span>
            </div>
            <input id="pob" type="text" class="form-control @error('pob') is-invalid @enderror" name="pob" value="{{ $teacher->pob ?? (old('pob') ?? null) }}" required autocomplete="pob" placeholder="{{ __('label.city') }}">
        </div>
        @if(session('pob_unverified'))
        <div class="form-group">
            <span class="text-danger" role="alert">
                <strong>{{ session('pob_unverified') }}</strong>
            </span>
        </div>
        @endif
    </div>
</div>