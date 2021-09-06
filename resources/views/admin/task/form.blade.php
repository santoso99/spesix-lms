<div class="col-lg-6 col-12 form-group">
    <label>{{ __('label.title') }} <span class="text-danger">*</span></label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$task->name ?? old('name') ?? null}}" required autofocus>
    @error('name')
    <div class="form-grop">
        <span class="text-danger" role="alert">
            {{$message}}
        </span>
    </div>
    @enderror
</div>
@if(isset($topic))
    <div class="col-lg-6 col-12 form-group">
        <label>{{ __('label.subject')}} <span class="text-danger">*</span></label>
        <select class="form-control" name="subject_id">
            <option value="{{$topic->subject_id}}">{{$topic->subject->name}}</option>
        </select>
        @error('subject_id')
        <div class="form-grop">
            <span class="text-danger" role="alert">
                {{$message}}
            </span>
        </div>
        @enderror
    </div>
    <div class="col-lg-6 col-12 form-group">
        <label>{{ __('label.topic') }} <span class="text-danger">*</span></label>
        <select class="form-control" name="learning_topic_id">
            <option value="{{$topic->id}}">{{ $topic->name }}</option>
        </select>
        @error('learning_topic_id')
        <div class="form-grop">
            <span class="text-danger" role="alert">
                {{$message}}
            </span>
        </div>
        @enderror
    </div>
@else
    <div class="col-lg-6 col-12 form-group">
        <label>{{ __('label.subject')}} <span class="text-danger">*</span></label>
        <select class="form-control" name="subject_id" id="mapelSelectBox">
            <option value="">-- {{ __('label.select') }} --</option>
            @if(isset($task->subject_id))
                @foreach ($subjects as $subject)
                    <option value="{{$subject->id}}" @if($task->subject_id == $subject->id) selected @endif>{{$subject->name}}</option>
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
        @error('subject_id')
        <div class="form-grop">
            <span class="text-danger" role="alert">
                {{$message}}
            </span>
        </div>
        @enderror
    </div>
    <div class="col-lg-6 col-12 form-group">
        <label>{{ __('label.topic') }} <span class="text-danger">*</span></label>
        <div id="topicSelectWrapper">
            @if(isset($task->learning_topic_id))
                <select class="form-control" name="learning_topic_id" id="topicSelectBox">
                    <option value="{{$task->learning_topic_id}}">{{$task->learningTopic->name}}</option>
                </select>
            @else
                <select class="form-control" name="learning_topic_id" id="topicSelectBox">
                    
                </select>
        @endif
        </div>
        @error('learning_topic_id')
        <div class="form-grop">
            <span class="text-danger" role="alert">
                {{$message}}
            </span>
        </div>
        @enderror
    </div>
@endif
<div class="col-lg-6 col-12 form-group">
    <label>{{ __('form-label.task_deadline') }} <span class="text-danger">*</span></label>
    <div class="input-group date">
        <div class="input-group-append">
            <span class="input-group-text"><i class="zmdi zmdi-calendar-alt"></i></span>
        </div>
        <input type="text" class="form-control datetimepicker @error('deadline') is-invalid @enderror" name="deadline" value="{{$task->deadline ?? old('deadline') ?? null}}" required/>
    </div>
    @error('deadline')
    <div class="form-grop">
        <span class="text-danger" role="alert">
            {{$message}}
        </span>
    </div>
    @enderror
</div>
<div class="col-lg-12 col-12 form-group">
    <label>{{ __('form-label.instruction') }} <span class="text-danger">*</span></label>
    <textarea id="editor" cols="30" rows="5" class="textarea form-control @error('instruction') is-invalid @enderror" name="instruction">
        {!! $task->instruction ?? old('instruction') ?? null !!}
    </textarea>
    @error('instruction')
    <div class="form-grop">
        <span class="text-danger" role="alert">
            {{$message}}
        </span>
    </div>
    @enderror
</div>
<div class="col-12 form-group">
    <label>{{ __('form-label.attachment') }} (optional)</label>
    <input type="file" name="attachment_file" class="dropify">
    <label class="mt-2">{{ __('messages.compress_file_link') }} <a href="https://youcompress.com">YouCompress.com</a></label>
    {{-- <input type="hidden" name="is_file_empty" value="0"> --}}
    @isset($task)
        @if($task->attachment_path != null)
            <div class="mt-3">
                <a href="{{asset('storage/'.$task->attachment_path)}}" class="link-icon mr-3"> {{$task->attachment_filename}}</a>
                <button id="btnRemoveFile" class="btn btn-danger btn-lg" data-url="{{asset('storage/'.$task->attachment_path)}}">
                    <span class="zmdi zmdi-delete"></span> {{ __('button-label.delete') }}
                </button>
            </div>
        @endif
    @endisset
    @error('attachment_file')
    <div class="form-grop">
        <span class="text-danger" role="alert">
            {{$message}}
        </span>
    </div>
    @enderror
</div>