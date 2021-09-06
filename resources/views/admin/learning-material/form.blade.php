<div class="col-lg-12 row p-3 mx-auto mb-3 learning-material">
    <div class="col-lg-12 col-12 form-group">
        <label>{{ __('label.name') }} <span class="text-danger">*</span></label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $material->name ?? old('name') ?? null }}">
        @error('name')
            <div class="form-group">
                <span class="text-danger" role="alert">
                    <strong>{{$message}}</strong>
                </span>
            </div>
        @enderror
    </div>
    <div class="col-lg-12 col-12 form-group">
        <label>{{ __('form-label.attachment') }} (optional) <span class="text-danger">Max. 10 MB</span></label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" name="material" id="customFile">
            <label class="custom-file-label" for="customFile">Choose file</label>
        </div>
        <label class="mt-2">{{ __('messages.compress_file_link') }} <a href="https://youcompress.com">YouCompress.com</a></label>
        @isset($material)
            @if($material->file_path != null)
                <div class="mt-3">
                    <a href="{{asset('storage/'.$material->file_path)}}" class="link-icon"> {{ __('label.uploaded_file') }}</a>
                </div>
            @endif
        @endisset
        @error('material')
            <div class="form-group">
                <span class="text-danger" role="alert">
                    <strong>{{$message}}</strong>
                </span>
            </div>
        @enderror
    </div>
    <div class="col-lg-12 col-12 form-group">
        <label>{{ __('label.content') }} <span class="text-danger">*</span></label>
        <textarea id="editor" name="content" class="textarea form-control @error('content') is-invalid @enderror">
            {!! $material->content ?? old('content') !!}
        </textarea>
        @error('content')
            <div class="form-group">
                <span class="text-danger" role="alert">
                    <strong>{{$message}}</strong>
                </span>
            </div>
        @enderror
    </div>
</div>