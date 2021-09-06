<div class="row clearfix">
    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
        <label>{{ __('form-label.sop_name') }} <span class="text-danger">*</span></label>
    </div>
    <div class="col-lg-10 col-md-10 col-sm-8">
        <div class="form-group">
            <input type="text" name="filename" class="form-control @error('filename') is-invalid @enderror" value="{{$sop->filename ?? old('filename') ?? null}}" required>
            @error('filename')
            <div class="form-group">
                <span class="text-danger" role="alert">
                    {{$message}}
                </span>
            </div>
            @enderror
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-2 col-md-2 col-sm-4 form-control-label">
        <label>{{ __('form-label.sop_file') }}</label>
    </div>
    <div class="col-lg-10 col-md-10 col-sm-8">
        <div class="form-group">
            <input type="file" name="file" class="dropify" data-allowed-file-extensions="pdf doc docx ppt pptx odt">
            <label class="mt-2">{{ __('messages.compress_file_link') }} <a href="https://youcompress.com">YouCompress.com</a></label>
            @error('file')
            <div class="form-group">
                <span class="text-danger" role="alert">
                    {{$message}}
                </span>
            </div>
            @enderror
        </div>
    </div>
</div>