<div class="col-lg-12 col-12 form-group">
    <label>{{ __('label.name')}} <span class="text-danger">*</span></label>
    <input type="text" name="title" class="form-control" required value="{{$exam->title ?? old('title') ?? null }}">
    @error('title')
        <div class="form-group">
            <span class="text-danger" role="alert">
                {{ $message }}
            </span>
        </div>
    @enderror
</div>
<div class="col-lg-6 col-12 form-group">
    <label>{{ __('label.subject')}} <span class="text-danger">*</span></label>
    <select class="form-control show-tick" name="subject_id">
        @if(isset($exam->subject_id))
            @foreach($subjects as $subject)
                <option value="{{$subject->id}}" @if($exam->subject_id == $subject->id) selected @endif>{{$subject->name}}</option>
            @endforeach
        @elseif(old('subject_id'))
            @foreach($subjects as $subject)
                <option value="{{$subject->id}}" @if(old('subject_id') == $subject->id) selected @endif>{{$subject->name}}</option>
            @endforeach
        @else
            @foreach($subjects as $subject)
                <option value="{{$subject->id}}">{{$subject->name}}</option>
            @endforeach
        @endif
    </select>
</div>
<div class="col-lg-3 col-12 form-group">
    <label>{{ __('label.kkm_score')}} <span class="text-danger">*</span></label>
    <div class="input-group">
        <div class="input-group-append">
            <span class="input-group-text"><i class="zmdi zmdi-minus"></i></span>
        </div>
        <input type="text" name="kkm_score" class="form-control" required value="{{$exam->kkm_score ?? old('kkm_score') ?? null}}">
    </div>
    @error('kkm_score')
        <div class="form-group">
            <span class="text-danger" role="alert">
                {{ $message }}
            </span>
        </div>
    @enderror
</div>
<div class="col-lg-3 col-12 form-group">
    <label>{{ __('label.max_score')}} <span class="text-danger">*</span></label>
    <div class="input-group">
        <div class="input-group-append">
            <span class="input-group-text"><i class="zmdi zmdi-check"></i></span>
        </div>
        <input type="text" name="max_score" class="form-control" required value="{{$exam->max_score ?? old('max_score') ?? null}}">
    </div>
    @error('max_score')
        <div class="form-group">
            <span class="text-danger" role="alert">
                {{ $message }}
            </span>
        </div>
    @enderror
</div>
<div class="col-lg-3 col-12 form-group">
    <label>{{ __('label.class')}} <span class="text-danger">*</span></label>
    <select id="gradeSelect" class="form-control show-tick" name="grade_id[]" multiple>
        @if(isset($exam_grades))
            @foreach ($grades as $grade)
                <option value="{{$grade->id}}" @if(in_array($grade->id, $exam_grades)) selected @endif>{{$grade->name}}</option>
            @endforeach
        @else
            @foreach ($grades as $grade)
                <option value="{{$grade->id}}">{{$grade->name}}</option>
            @endforeach
        @endif
    </select>
</div>
<div class="col-lg-3 col-12 form-group">
    <label>{{ __('label.date')}} <span class="text-danger">*</span></label>
    <div class="input-group">
        <div class="input-group-append">
            <span class="input-group-text"><i class="zmdi zmdi-calendar-alt"></i></span>
        </div>
        @if(isset($exam->date))
            <input type="text" class="form-control datepicker @error('date') is-invalid @enderror" name="date" value="{{$exam->date->format('l d F Y')}}" required/>
        @else
            <input type="text" class="form-control datepicker @error('date') is-invalid @enderror" name="date" value="{{old('date') ?? null}}" required/>
        @endif
    </div>
    @error('date')
        <div class="form-group">
            <span class="text-danger" role="alert">
                {{ $message }}
            </span>
        </div>
    @enderror
</div>
<div class="col-lg-3 col-12 form-group">
    <label>{{ __('label.start_at')}} <span class="text-danger">*</span></label>
    <div class="input-group">
        <div class="input-group-append">
            <span class="input-group-text"><i class="zmdi zmdi-time"></i></span>
        </div>
        <input type="text" class="form-control timepicker @error('time_start') is-invalid @enderror" name="time_start" value="{{$exam->time_start ?? old('time_start') ?? null}}" required/>
    </div>
    @error('time_start')
        <div class="form-group">
            <span class="text-danger" role="alert">
                {{ $message }}
            </span>
        </div>
    @enderror
</div>
<div class="col-lg-3 col-12 form-group">
    <label>{{ __('label.finish_at')}} <span class="text-danger">*</span></label>
    <div class="input-group">
        <div class="input-group-append">
            <div class="input-group-text"><span class="zmdi zmdi-time"></span></div>
        </div>
        <input type="text" class="form-control timepicker @error('time_end') is-invalid @enderror" name="time_end" value="{{$exam->time_end ?? old('time_end') ?? null}}" required/>
    </div>
    @error('time_end')
        <div class="form-group">
            <span class="text-danger" role="alert">
                {{ $message }}
            </span>
        </div>
    @enderror
</div>