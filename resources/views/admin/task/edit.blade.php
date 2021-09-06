@extends('layouts.master')

@section('title')
    {{ __('section-title.task_edit') }}
@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/dropify/css/dropify.min.css')}}"/>
@stop

@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>{{ __('section-title.task_edit') }}</strong></h2>
            </div>
            <div id="identitas" class="body">
                <form method="post" action="{{route('tasks.update',$task->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="row">
                        @include('admin.task.form')
                        <div class="col-12 form-group">
                            <button type="submit" class="float-right ml-3 btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.update') }}</button>
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
<script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $("#mapelSelectBox").on("change", function(){
            let subject_id = $(this).val()
            $("#topicSelectBox").prop("disabled",true)

            $.ajax({
                url: '{!! \LaravelLocalization::localizeURL("/") !!}/admin/subjects/'+subject_id+'/topics',
                type: 'get',
                dataType: 'json',
                success: function(topics){
                    $('#topicSelectBox').empty()
                    
                    for(let topic of topics)
                    {
                        $('#topicSelectBox').append(`<option value="${topic.id}">${topic.name}</option>`);
                    }
                    $("#topicSelectBox").prop("disabled",false)
                },
                error: function(response){
                },
            })
        });

        $('#btnRemoveFile').on('click', function(e){
            e.preventDefault()

            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                },
                url: "{!! route('file.delete') !!}",
                type: 'delete',
                dataType: 'json',
                data: {
                    file_path: "{!! $task->attachment_path ?? null !!}",
                    table: "tasks",
                    id: "{!! $task->id !!}",
                    field: "attachment_path"
                },
                success: (response) => {
                    $(this).parent().remove();
                    swal({
                        text: "{!! __('messages.file_deleted') !!}",
                        icon: "success",
                    });
                },
                error: function(response){
                    swal({
                        text: "{!! __('messages.file_fail_deleted') !!}",
                        icon: "error",
                    });
                }
            })
        });
    });
</script>
@stop