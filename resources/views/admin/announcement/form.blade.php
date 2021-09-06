<div class="col-lg-12 col-12 form-group">
    <label>{{ __('label.title') }} <span class="text-danger">*</span></label>
    <input type="text" placeholder="ex. Donor Darah bersama PMI" name="title" class="form-control" value="{{$announcement->title ?? old('title') ?? null}}" required>
</div>
<div class="col-lg-6 col-12 form-group">
    <label>{{ __('label.date')}} <span class="text-danger">*</span></label>
    <div class="input-group">
        <div class="input-group-append">
            <span class="input-group-text"><i class="zmdi zmdi-calendar-alt"></i></span>
        </div>
        <input type="text" class="form-control datepicker @error('date') is-invalid @enderror" name="date" value="{{$announcement->formatted_date ?? old('date') ?? null}}" required/>
    </div>
    @error('date')
        <div class="form-group">
            <span class="text-danger" role="alert">
                {{ $message }}
            </span>
        </div>
    @enderror
</div>
<div class="col-lg-6 col-12 form-group">
    <label>{{ __('label.start_at')}} <span class="text-danger">*</span></label>
    <div class="input-group">
        <div class="input-group-append">
            <span class="input-group-text"><i class="zmdi zmdi-time"></i></span>
        </div>
        <input type="text" class="form-control timepicker @error('start_time') is-invalid @enderror" name="start_time" value="{{$announcement->start_time ?? old('start_time') ?? null}}" required/>
    </div>
    @error('start_time')
        <div class="form-group">
            <span class="text-danger" role="alert">
                {{ $message }}
            </span>
        </div>
    @enderror
</div>
<div class="col-lg-12 col-12 form-group">
    <label>{{ __('label.announcement_detail') }} <span class="text-danger">*</span></label>
    <textarea id="editor" name="content" placeholder="ex. Donasi darah Anda untuk kemanusiaan">{!! $announcement->content ?? old('content') ?? null !!}</textarea>
    @error('content')
    <div class="form-group">
        <span class="text-danger" role="alert">
            {{ $message }}
        </span>
    </div>
    @enderror
</div>