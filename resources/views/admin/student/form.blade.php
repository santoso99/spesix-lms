<div class="col-lg-6 col-12">
    <div class="form-group mt-0">
        <label>{{ __('label.student_reg_number') }} <span class="text-danger">*</span></label>
        <div class="input-group">
            <div class="input-group-append">
                <span class="input-group-text"><i class="zmdi zmdi-account"></i></span>
            </div>
            <input id="identity_number" type="text" class="form-control @error('identity_number') is-invalid @enderror" name="identity_number" value="{{ $student->identity_number ?? (old('identity_number') ?? null)}}" required autocomplete="identity_number" autofocus placeholder="123xxxx">
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
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $student->name ?? (old('name') ?? null) }}" required autocomplete="name">
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
                <span class="input-group-text"><i class="zmdi zmdi-pin"></i></span>
            </div>
            <input id="pob" type="text" class="form-control @error('pob') is-invalid @enderror" name="pob" value="{{ $student->pob ?? (old('pob') ?? null) }}" required autocomplete="pob" placeholder="{{ __('label.city') }}">
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
<div class="col-lg-6 col-12">
    <div class="form-group">
        <label>{{ __('label.class') }} <span class="text-danger">*</span></label>
        <select class="form-control show-tick" name="grade">
            @if(isset($student->grade))
                @foreach ($grades as $grade)
                    <option value="{{$grade->name}}" @if($student->grade == $grade->name) selected @endif>{{$grade->name}}</option>
                @endforeach
            @elseif(old('grade'))
                @foreach ($grades as $grade)
                    <option value="{{$grade->name}}" @if(old('grade') == $grade->name) selected @endif>{{$grade->name}}</option>
                @endforeach
            @else
                @foreach ($grades as $grade)
                    <option value="{{$grade->name}}">{{$grade->name}}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>