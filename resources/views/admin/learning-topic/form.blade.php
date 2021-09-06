<div class="col-lg-6 col-12 form-group">
    <label>{{ __('label.topic_name') }} <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" required name="name" value="{{ $topic->name ?? (old('name') ?? null)}}" autocomplete="name" autofocus>
    @error('name')
    <div class="form-group">
        <span class="text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    </div>
    @enderror
</div>
<div class="col-lg-6 col-12 form-group">
    <label>{{ __('label.subject') }} <span class="text-danger">*</span></label>
    <select class="form-control show-tick" name="subject_id">
        @if(isset($topic->subject_id))
            @foreach ($subjects as $subject)
                <option value="{{$subject->id}}" @if($topic->subject_id == $subject->id) selected @endif>{{$subject->name}}</option>
            @endforeach
        @elseif(old('subject_id'))
            @foreach ($subjects as $subject)
                <option value="{{$subject->id}}" @if(old('subject_id') == $subject->id) selected @endif>{{$subject->name}}</option>
            @endforeach
        @else
            @foreach ($subjects as $subject)
                <option value="{{$subject->id}}">{{$subject->name}}</option>
            @endforeach
        @endif
    </select>
</div>
<div class="col-md-3 col-12 form-group">
    <label>{{ __('label.school_year') }} <span class="text-danger">*</span></label>
    <input type="text" class="form-control" required name="school_year" value="{{$topic->school_year ?? old('school_year') ?? '2019/2020'}}">
</div>
<div class="col-lg-3 col-12 form-group">
    <label>{{ __('label.semester') }} <span class="text-danger">*</span></label>
    <select class="form-control show-tick" name="semester">
        <option value="">Pilih Semester *</option>
        @if(isset($topic->semester))
            @for($i=1;$i<=6;$i++)
                <option value="{{$i}}" @if($topic->semester == $i) selected @endif>{{$i}}</option>
            @endfor
        @elseif(old('semester'))
            @for($i=1;$i<=6;$i++)
                <option value="{{$i}}" @if(old('semester') == $i) selected @endif>{{$i}}</option>
            @endfor
        @else
            @for($i=1;$i<=6;$i++)
                <option value="{{$i}}">{{$i}}</option>
            @endfor
        @endif
    </select>
</div>
<div class="col-lg-3 col-12 form-group">
    <label>{{ __('label.class_level') }} <span class="text-danger">*</span></label>
    <select class="form-control show-tick" name="grade_level">
        @if(isset($topic->grade_level))
            <option value="7" @if($topic->grade_level == 7) selected @endif>7</option>
            <option value="8" @if($topic->grade_level == 8) selected @endif>8</option>
            <option value="9" @if($topic->grade_level == 9) selected @endif>9</option>
        @elseif(old('grade_level'))
            <option value="7" @if(old('grade_level') == 7) selected @endif>7</option>
            <option value="8" @if(old('grade_level') == 8) selected @endif>8</option>
            <option value="9" @if(old('grade_level') == 9) selected @endif>9</option>
        @else
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
        @endif
    </select>
</div>
<div class="col-12-xxxl col-lg-3 col-12 form-group">
    <label>{{ __('label.class') }} <span class="text-danger">*</span></label>
    <select id="topicGradeSelect" class="form-control show-tick" name="grade_id[]" multiple>
        @if(isset($topic_grades))
            @foreach ($grades as $grade)
                <option value="{{$grade->id}}" @if(in_array($grade->id, $topic_grades)) selected @endif>{{$grade->name}}</option>
            @endforeach
        @else
            @foreach ($grades as $grade)
                <option value="{{$grade->id}}">{{$grade->name}}</option>
            @endforeach
        @endif
    </select>
</div>
<div class="col-12 form-group">
    <label>{{ __('label.rpp_file') }} (optional) <span class="text-danger">Max. 10 MB</span></label>
    <input type="file" name="rpp_file" class="dropify">
    <label class="mt-2">{{ __('messages.compress_file_link') }} <a href="https://youcompress.com">YouCompress.com</a></label>
    {{-- <input type="hidden" name="is_file_empty" value="0"> --}}
    @isset($topic)
        @if($topic->rpp_file != null)
            <div class="mt-3">
                <a href="{{asset('storage/'.$topic->rpp_file)}}" class="link-icon mr-3"> {{ __('form-label.rpp_file') }}</a>
                <button id="btnRemoveFile" class="btn btn-danger" data-url="{{asset('storage/'.$topic->rpp_file)}}">
                    <span class="zmdi zmdi-delete"></span> {{ __('button-label.delete') }}
                </button>
            </div>
        @endif
    @endisset
</div>
<div class="col-xl-12 col-lg-12 col-12 form-group">
    <label>{{ __('label.basic_competency') }} <span class="text-danger">*</span></label>
    <div id="KdWrapper">
        @include('admin.partials.new-added-competency')
    </div>
    <div class="btn-group" role="group">
        <button id="btnGroupAddKd" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="zmdi zmdi-plus"></span> {{ __('button-label.competency_add') }}
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupAddKd" style="font-size: 1.6rem;">
          <a class="dropdown-item" href="#" type="buton" data-toggle="modal" data-target="#createKdModal">{{ __('button-label.make_new_competency') }}</a>
          <a class="dropdown-item btn-kd-bank" href="#" type="button" data-toggle="modal" data-target="#KdDataModal">{{ __('button-label.from_competency_data') }}</a>
        </div>
    </div>
    @error('competency_id')
    <div class="form-group">
        <span class="text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    </div>
    @enderror
</div>