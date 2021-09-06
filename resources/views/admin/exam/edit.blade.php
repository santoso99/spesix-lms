@extends('layouts.master')

@section('title')
{{ __('section-title.evaluation_edit') }}
@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@stop

@section('content')
<div class="row clearfix">
    @include('admin.exam.question-modal')
    <div class="col-lg-12 col-12">
        @isset($exam_status)
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {!! $exam_status !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endisset
        <div class="card">
            <div class="header">
                <h2><strong>{{ __('section-title.evaluation_edit') }}</strong></h2>
            </div>
            <div class="body">
                <form id="examEditForm" action="{{\LaravelLocalization::localizeURL('admin/exams/'.$exam->id)}}" method="POST">
                    @csrf
                    @method('patch')
                    <div class="row">
                        @include('admin.exam.form')
                        @hasrole("Pengajar")
                        <div class="col-12 form-group text-right">
                            <button type="submit" class="btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.update')}}</button>
                        </div>
                        @endhasrole
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-12">
        <div id="alertQuestionExamSuccess" class="alert alert-success alert-dismissible show fade" @if(!session('status'))style="display:none"@endif role="alert">
            {{ session('status') ?? null }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div id="alertQuestionExamDanger" class="alert alert-danger alert-dismissible show fade" style="display:none" role="alert">
            
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="card">
            <div class="header">
                <h2>{{ __('section-title.question_for_evaluation')}} <strong>{{$exam->title}}</strong></h2>
            </div>
            <div class="body">
                @hasrole('Pengajar')
                <div class="row">
                    <div class="btn-group btn-lg" role="group">
                        <button id="btnGroupAddQuestion" type="button" class="btn btn-success btn-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="zmdi zmdi-plus"></i> {{ __('section-title.question_add')}}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupAddQuestion" style="width: 100%;
                        font-size: 1.6rem;">
                          <a class="dropdown-item" href="#" type="buton" data-toggle="modal" data-target="#createQuestionModal">{{ __('section-title.question_create')}}</a>
                          <a class="dropdown-item btn-question-bank" href="#" type="button" data-toggle="modal" data-target="#questionBankModal">{{ __('label.from_question_bank')}}</a>
                        </div>
                    </div>
                </div>
                @endhasrole
                <form action="{{route('exam-questions.batch.delete',$exam->id)}}" method="POST">
                    @csrf
                    @method('delete')
                    <div class="table-responsive result-table-box">
                        <table id="table-question" class="table table-borderless table-hover table-fixed dataTable">
                            <thead>
                                <tr>
                                    <th class="no-sort" style="width: 5%">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input checkAll">
                                            <label class="form-check-label">-</label>
                                        </div>
                                    </th>
                                    <th style="width: 8%">
                                        <label class="form-check-label">{{ __('label.number')}}</label>
                                    </th>
                                    <th style="width: 12%">{{ __('label.type')}}</th>
                                    <th style="width: 40%">{{ __('label.question')}}</th>
                                    <th style="width: 35%">{{ __('label.basic_competency')}}</th>
                                </tr>
                            </thead>
                            <tbody id="examQuestionData">
                                @include('admin.exam.new-added-exam-question')
                            </tbody>
                        </table>
                        @hasrole("Pengajar")
                        <div>
                            <button type="submit" class="btn btn-warning btn-raised waves-effect">{{ __('button-label.remove_question_from_evaluation')}}</button>
                        </div>
                        @endhasrole
                    </div>
                </form>
                @hasrole('Pengajar')
                <div class="row">
                    <div class="btn-group btn-lg" role="group">
                        <button id="btnGroupAddQuestion" type="button" class="btn btn-success btn-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="zmdi zmdi-plus"></i> {{ __('section-title.question_add')}}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupAddQuestion" style="width: 100%;
                        font-size: 1.6rem;">
                          <a class="dropdown-item" href="#" type="buton" data-toggle="modal" data-target="#createQuestionModal">{{ __('section-title.question_create')}}</a>
                          <a class="dropdown-item btn-question-bank" href="#" type="button" data-toggle="modal" data-target="#questionBankModal">{{ __('label.from_question_bank')}}</a>
                        </div>
                    </div>
                </div>
                @endhasrole
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.11/tinymce.min.js"></script>
<script src="{{asset('js/custom/tinymce-init.js')}}"></script>
<script>
    $('.dataTable').dataTable( {
            "columnDefs": [ {
            "targets": 'no-sort',
            "orderable": false,
        } ]
    } );

    /*-------------------------------------
        All Checkbox Checked
    -------------------------------------*/
    $(".checkAll").on("click", function () {
        $(this).parents('.table').find('input:checkbox').prop('checked', this.checked);
    });
</script>
<script>
    $(document).ready(function(){
        
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')
        let answer_choice_list = $('#answerChoiceList')

        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });

        $(document).on("change", "#questionTypeSelect", function(){
            let type = parseInt($(this).val());

            if(type == 2){
                $('#answerChoiceWrapper').empty();
            }
            else if(type == 1){
                $('#answerChoiceWrapper').append(answer_choice_list);
            }
        });

        $('.btn-question-bank').on('click',function(){
            $('#alertQuestionExamSuccess').hide()
            $('#alertQuestionExamDanger').hide()
            fetch_data()
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

            if(page == null)
            {
                url = "{!! route('questions.subjects.data',[$exam->id,$exam->subject_id]) !!}"
            }
            else {
                url = "{!! route('questions.subjects.data',[$exam->id,$exam->subject_id]) !!}?page="+page
            }

            $.ajax({
                url: url,
                beforeSend: function(){
                    $('#questionData').html("<p class='text-center'>Loading...</p>")
                },
                success:function(data)
                {
                    $('#questionData').html(data)
                },
                error:function(data){
                    console.log(data['error'])
                }
            });
        }

        $(document).on('click', '#btnAddQuestionToExam', function(e){
            let question_ids = new Array()
            e.preventDefault()

            $("#questionData input[name='question_id[]']:checked").each(function () {
                question_ids.push(this.value)
            });

            if(question_ids.length > 0){

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    url: '{!! route("exams.questions.add",$exam->id) !!}',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        question_ids: question_ids,
                    },
                    beforeSend: function(){
                        $("#btnAddQuestionToExam").prop("disabled",true)
                        $("#btnAddQuestionToExam").html("Loading...")
                    },
                    success: function(data){
                        toastr.success("{!! __('messages.question_success_added') !!}")
                        $("#btnAddQuestionToExam").prop("disabled",false)
                        $("#btnAddQuestionToExam").html("{!! __('button-label.add_to_evaluation') !!}")
                        $("#examQuestionData").html(data['content'])
                        location.reload()
                    },
                    error: function(data){
                        $("#examQuestionData").html(data.responseText)
                        $("#btnAddQuestionToExam").prop("disabled",false)
                        $("#btnAddQuestionToExam").html("{!! __('button-label.add_to_evaluation') !!}")
                        toastr.error(data['message'])
                        
                    },
                })
            }
        });

        let x = 0;

        $("select.kd-question-select").on("change", function(){
            let competency_id = $(this).val()
            let exam_question_id = $(this).data("exam-question-id")

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                },
                url: '{!! \LaravelLocalization::localizeURL("/") !!}/admin/exams/questions/'+exam_question_id+'/competencies',
                type: 'patch',
                dataType: 'json',
                data: {
                    competency_id: competency_id,
                },
                success: function(response){
                    toastr.success(response['message'])
                },
                error: function(response){
                    toastr.error("{!! __('messages.competency_fail_applied') !!}")
                },
            })
        });
    });
</script>
@stop