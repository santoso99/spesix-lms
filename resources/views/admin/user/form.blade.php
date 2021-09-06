<div class="col-lg-6 col-12">
    <div class="form-group mt-0">
        <label>{{ __('label.reg_number') }} <span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-append">
                <span class="input-group-text"><i class="zmdi zmdi-account"></i></span>
            </div>
            <input id="identity_number" type="text" class="form-control @error('identity_number') is-invalid @enderror" name="identity_number" value="{{ $user->member->identity_number ?? (old('identity_number') ?? null)}}" required autocomplete="identity_number" autofocus placeholder="123xxxx">
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
        <label>{{ __('label.fullname') }}<span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-append">
                <span class="input-group-text"><i class="zmdi zmdi-account"></i></span>
            </div>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name ?? (old('name') ?? null) }}" required autocomplete="name">
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
<div class="col-lg-4 col-12">
    <div class="form-group mt-0">
        <label>{{ __('label.pob') }} <span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-append">
                <span class="input-group-text"><i class="zmdi zmdi-pin"></i></span>
            </div>
            <input id="pob" type="text" class="form-control @error('pob') is-invalid @enderror" name="pob" value="{{ $user->member->pob ?? (old('pob') ?? null) }}" required autocomplete="pob" placeholder="{{ __('label.city') }}">
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
<div class="col-lg-4 col-12">
    <div class="form-group">
        <label>{{ __('label.class') }} <span class="text-danger">*</span></label>
        <select class="form-control show-tick" name="grade_id">
            @if(isset($user->grade_id))
                <option value=""  @if($user->grade_id == null) selected @endif>Non {{ __('label.student') }}</option>
                @foreach ($grades as $grade)
                    <option value="{{$grade->id}}" @if($user->grade_id == $grade->id) selected @endif>{{$grade->name}}</option>
                @endforeach
            @elseif(old('grade_id'))
                <option value="" @if(old('grade_id') == "") selected @endif>Non {{ __('label.student') }}</option>
                @foreach ($grades as $grade)
                    <option value="{{$grade->id}}" @if(old('grade_id') == $grade->id) selected @endif>{{$grade->name}}</option>
                @endforeach
            @else
                <option value="">Non {{ __('label.student') }}</option>
                @foreach ($grades as $grade)
                    <option value="{{$grade->id}}">{{$grade->name}}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>
<div class="col-lg-4 col-12">
    <div class="form-group">
        <label>{{ __('label.level') }} <span class="text-danger">*</span></label>
        <select class="form-control show-stick" name="role">
            @if(isset($user->roles[0]))
                @foreach ($roles as $role)
                    <option value="{{$role->name}}" @if($user->roles[0]->id == $role->id) selected @endif>{{$role->name}}</option>
                @endforeach
            @elseif(old('role'))
                @foreach ($roles as $role)
                    <option value="{{$role->name}}" @if(old('role') == $role->name) selected @endif>{{$role->name}}</option>
                @endforeach
            @else
                @foreach ($roles as $role)
                    <option value="{{$role->name}}">{{$role->name}}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>
<div class="col-lg-4 col-12">
    <div class="form-group mt-0">
        <label>{{ __('label.email') }} <span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-append">
                <span class="input-group-text"><i class="zmdi zmdi-email"></i></span>
            </div>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email ?? (old('email') ?? null)}}" required autocomplete="email" placeholder="mail@mail.com">
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
<div class="col-lg-4 col-12">
    <div class="form-group mt-0">
        <label>{{ __('label.password') }}</label>
        <div class="input-group">
            <div class="input-group-append">
                <span class="input-group-text"><i class="zmdi zmdi-lock"></i></span>
            </div>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password" placeholder="{{ isset($user->password) ? __('messages.leave_password_blank') : __('messages.min_password_char')}}">
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
<div class="col-lg-4 col-12">
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