@extends('layouts.master')

@section('title')
    {{ __('section-title.learning_topic_edit') }}
@endsection
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/dropify/css/dropify.min.css')}}"/>
@stop
@section('content')
<div class="row clearfix">
    @include('admin.partials.topic-competency-modal')
    <div class="col-lg-12">
        @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show mb-5" role="alert">
            {!! session('status') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="card">
            <div class="header">
                <h2><strong>{{ __('section-title.learning_topic_edit') }}</strong></h2>
            </div>
            <div id="identitas" class="body">
                <form action="{{\LaravelLocalization::localizeURL('admin/topics/'.$topic->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="row">
                        @include('admin.learning-topic.form')
                        <div class="col-12 form-group">
                            <button type="submit" class="float-right btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')
<script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/plugins/dropify/js/dropify.min.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/dropify.js')}}"></script>
<script>
    $(document).ready(function(){

        $('#btnFilterKd').on('click', function(e){
            e.preventDefault()
            $('.alert-success').hide()
            $('.alert-danger').hide()

            fetch_data()
        });

        $(document).on("click",".btn-remove-competency",function(e){
            e.preventDefault()
            $(this).parent().parent().remove()
        });

        $(document).on("click", ".checkAll",function () {
            $(this).parents('.table').find('input:checkbox').prop('checked', this.checked)
        });

        $(document).on('click', '.pagination a', function(event){
            event.preventDefault()
            let page = $(this).attr('href').split('page=')[1]
            fetch_data(page)
        });

        function fetch_data(page = null)
        {
            let url;
            let subject_id = $('#subjectSelectBox').val()
            let grade_level = $('#gradeSelectBox').val()

            if(page == null)
            {
                url = "{!! route('competencies.filter') !!}";
            }
            else {
                url = "{!! route('competencies.filter') !!}?page="+page
            }

            $.ajax({
                url: url,
                data: {
                    subject_id: subject_id,
                    grade_level: grade_level,
                },
                beforeSend: function(){
                    $('#KdData').html("<p class='text-center'>Loading...</p>");
                },
                success:function(data)
                {
                    $('#KdData').html(data);
                },
                error:function(data){
                    console.log(data['error'])
                }
            });
        }

        $(document).on('click', '#btnAddKdToTopic', function(e){
            let grabbed_competencies = new Array()
            e.preventDefault()

            $("#KdData input[name='competency_id[]']:checked").each(function () {
                grabbed_competencies.push([
                    this.value,
                    this.nextElementSibling.innerText,
                ])
            });

            if(grabbed_competencies.length > 0){
                let competency_list = ``;

                for(i=0;i<grabbed_competencies.length;i++)
                {
                    competency_list += `<div class="row">
                            <div class="col-md-11 col-12 form-group">
                                <input type="hidden" name="competency_id[]" value="${grabbed_competencies[i][0]}"><textarea class="form-control" disabled>${grabbed_competencies[i][1]}</textarea>
                            </div>
                            <div class="col-md-1 col-12 form-group">
                                <button class="btn btn-danger btn-remove-competency">
                                    <span class="zmdi zmdi-delete"></span>
                                </button>
                            </div>
                        </div>`
                }

                $('#KdWrapper').append(competency_list)
            }
        });

        $(document).on('click', '#btnCreateKd', function(e){
            e.preventDefault()

            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')
            let subject_id = $('#addSubjectSelectBox').val()
            let grade_level = $('#addGradeSelectBox').val()
            let competency = $('#addCompetencyInput').val()

            if(competency == null){
                $('#competencyError').text("{!! __('messages.blank_competency_warning') !!}")
            }
            else {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                    },
                    url: "{!! route('competencies.store') !!}",
                    type: 'post',
                    dataType: 'json',
                    data: {
                        subject_id: subject_id,
                        grade_level: grade_level,
                        competency: competency,
                    },
                    beforeSend: function(){
                        $('#btnCreateKd').prop('disabled',true)
                        $('#btnCreateKd').html('Loading...')
                    },
                    success: function(response){
                        console.log(response)
                        $('#btnCreateKd').prop('disabled',false)
                        $('#btnCreateKd').html("{!! __('button-label.save') !!}")
                        $('#KdWrapper').append(response['kd_item'])
                        swal({
                            text: "{!! __('messages.success_input_competency') !!}",
                            icon: "success",
                        });
                    },
                    error: function(response){
                        $('#btnCreateKd').prop('disabled',false)
                        $('#btnCreateKd').html("{!! __('button-label.save') !!}")
                        swal({
                            text: "{!! __('messages.fail_input_competency') !!}",
                            icon: "error",
                        });
                    }
                })
            }
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
                    file_path: "{!! $topic->rpp_file ?? null !!}",
                    table: "learning_topics",
                    id: "{!! $topic->id !!}",
                    field: "rpp_file"
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