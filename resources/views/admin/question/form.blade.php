<div class="row">
    <div class="col-lg-3 col-12 form-group">
        <label for="questionTypeSelect">{{ __('label.question_type') }} <span class="text-danger">*</span></label>
        <select id="questionTypeSelect" class="form-control show-tick" name="question_type_id">
            @foreach ($question_types as $question_type)
                <option value="{{$question_type->id}}">{{$question_type->name}}</option>
            @endforeach
        </select>
    </div>
    @if(isset($exam))
        <input type="hidden" name="subject_id" value="{{ $exam->subject_id }}">
    @else
        <div id="subjectInputWrapper" class="col-lg-5 col-12 form-group">
            <label for="subjectSelect">{{ __('label.subject') }} <span class="text-danger">*</span></label>
            <select id="subjectSelect" class="form-control show-tick" name="subject_id">
                @foreach ($subjects as $subject)
                    <option value="{{$subject->id}}" @if(old('subject_id') == $subject->id) selected @endif>{{$subject->name}}</option>
                @endforeach
            </select>
        </div>
    @endif
</div>
<div class="form-group">
    <label>{{ __('label.question_name') }} <span class="text-danger">*</span></label>
    <input type="text" name="title" class="form-control" value="{{old('title') ?? null}}">
    @error('title')
    <div class="form-group">
        <span class="text-danger" role="alert">
            {{$message}}
        </span>
    </div>
    @enderror
</div>
<div class="form-group">
    <label for="question">{{ __('label.question_text') }} <span class="text-danger">*</span></label>
    <textarea name="question" id="editor" class="form-control" rows="10">{{old('question') ?? null}}</textarea>
    @error('question')
    <div class="form-group">
        <span class="text-danger" role="alert">
            {{$message}}
        </span>
    </div>
    @enderror
</div>
<div id="answerChoiceWrapper">
    <ol id="answerChoiceList" class="mt-3">
        <p class="font-weight-bold">{{ __('label.answer_option') }}</p>
        <small>({{ __('messages.mark_answer_key') }})</small>
        @for($i=1;$i<=4;$i++)
        <li class="answer-choice-item-wrapper">
            <div class="row mt-3">
                <div class="col-1 text-center">
                    <input type="radio" name="is_answer" value="{{$i}}" required>
                </div>
                <div class="col-7">
                    <input type="text" name="answers[]" class="form-control" style="height: 40px;" required>
                </div>
            </div>
        </li>
        @endfor
    </ol>
</div>