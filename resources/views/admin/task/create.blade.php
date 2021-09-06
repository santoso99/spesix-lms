@extends('layouts.master')

@section('title')
    {{ __('section-title.task_add') }}
@endsection
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/dropify/css/dropify.min.css')}}"/>
@stop
@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>{{ __('section-title.task_add') }}</strong></h2>
            </div>
            <div id="identitas" class="body">
                <form method="post" action="{{route('tasks.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        @include('admin.task.form')
                        <div class="col-12 form-group">
                            <button type="submit" class="float-right ml-3 btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.publish') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
<script src="{{asset('assets/plugins/dropify/js/dropify.min.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/dropify.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.11/tinymce.min.js"></script>
<script src="{{asset('js/custom/tinymce-init.js')}}"></script>
<script>
    $(document).ready(function(){
        $("#mapelSelectBox").on("change", function(){
            let subject_id = $(this).val()

            $.ajax({
                url: '{!! \LaravelLocalization::localizeURL("/") !!}/admin/subjects/'+subject_id+'/topics',
                type: 'get',
                success: function(topics){
                    $('#topicSelectWrapper').html(topics)
                },
                error: function(response){
                },
            })
        });
    });
</script>
@stop