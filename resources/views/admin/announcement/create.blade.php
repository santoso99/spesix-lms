@extends('layouts.master')

@section('title')
    {{ __('section-title.announcement_add') }}
@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
@endsection

@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>{{ __('section-title.announcement_add') }}</strong></h2>
            </div>
            <div id="identitas" class="body">
                <form method="post" action="{{\LaravelLocalization::localizeURL('admin/announcements')}}">
                    @csrf
                    <div class="row clearfix">
                        @include('admin.announcement.form')
                        <div class="col-12 form-group text-right">
                            <button type="submit" class="btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.publish') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('after-scripts')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.11/tinymce.min.js"></script>
<script>
    var editor_config = {
    path_absolute : "/",
    selector: "textarea#editor",
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    relative_urls: false,
    file_browser_callback : function(field_name, url, type, win) {
        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
        var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

        var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
        if (type == 'image') {
        cmsURL = cmsURL + "&type=Images";
        } else {
        cmsURL = cmsURL + "&type=Files";
        }

        tinyMCE.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'Filemanager',
        width : x * 0.8,
        height : y * 0.8,
        resizable : "yes",
        close_previous : "no"
        });
    }
    };

    tinymce.init(editor_config);
</script>
@endpush