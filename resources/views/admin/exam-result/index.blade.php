@extends('layouts.master')

@section('title')
    {{ __('section-title.evaluation_result_data')}}
@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
@stop

@section('content')
<div class="row clearfix">
    @include('admin.exam-result.modal')
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>{{$exam->title}}</strong></h2>
                <ul class="header-dropdown">
                    <li>
                        <a role="button" href="{{\LaravelLocalization::localizeURL('admin/exams')}}"><i class="zmdi zmdi-arrow-left"></i> {{ __('label.back')}}</a>
                    </li>
                </ul>
            </div>
            <div class="body">
                <table class="table table-borderless">
                    <tr>
                        <td style="width: 25%">{{ __('label.subject')}}</td>
                        <td style="width: 5%">:</td>
                        <td style="width: 70%"><b>{{$exam->subject->name}}</b></td>
                    </tr>
                    <tr>
                        <td>{{ __('label.time')}}</td>
                        <td>:</td>
                        <td><b>{{$exam->date->format('d F Y').', '.$exam->time_start.' - '.$exam->time_end}}</b></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>{{ __('label.summary') }}</strong></h2>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card w_data_1">
                            <div class="body">
                                <div class="w_icon green"><i class="zmdi zmdi-check-circle"></i></div>
                                <h4 class="mt-3">{{$exam_result_count->studentPass}}</h4>
                                <span class="text-muted">{{ __('label.passed_student')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card w_data_1">
                            <div class="body">
                                <div class="w_icon pink"><i class="zmdi zmdi-close-circle"></i></div>
                                <h4 class="mt-3">{{ $exam_result_count->studentFail }}</h4>
                                <span class="text-muted">{{ __('label.fail_student')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card w_data_1">
                            <div class="body">
                                <div class="w_icon cyan"><i class="zmdi zmdi-star-half"></i></div>
                                <h4 class="mt-3">{{ $exam_result_count->averageScore }}</h4>
                                <span class="text-muted">{{ __('label.avg_score')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="alert alert-success alert-dismissible show fade" @if(!session('status'))style="display:none"@endif role="alert">
            {{ session('status') ?? null }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="alert alert-danger alert-dismissible show fade" style="display:none" role="alert">
            
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="card">
            <div class="header">
                <h2><strong>{{ __('section-title.evaluation_result_data')}}</strong></h2>
                @hasrole("Pengajar")
                <ul class="header-dropdown">
                    <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> {{ __('label.select_class') }} <i class="zmdi zmdi-more"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-left slideUp">
                            @foreach($grades as $grade)
                                <li>
                                    <a href="{{\LaravelLocalization::localizeURL('admin/exams/'.$exam->id.'/results/grades/'.$grade->id)}}">{{$grade->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li>
                        <button id="btnExportEvaluationResult" type="button" class="btn btn-success"><i class="zmdi zmdi-file-text text-light"></i> Export {{ __('label.evaluation_result')}}</button>
                    </li>
                </ul>
                @endhasrole
            </div>
            <div class="body">
                <form action="{{route('exam-results.batch.delete',$exam->id)}}" method="POST">
                    @csrf
                    @method('delete')
                    <div class="table-responsive">
                        <table id="tableEvaluationResult" class="table table-hover dataTable c_table theme-color">
                            <thead>
                                <tr>
                                    <th class="no-sort">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input checkAll">
                                            <label class="form-check-label">-</label>
                                        </div>
                                    </th>
                                    <th>{{ __('label.number') }}</th>
                                    <th>{{ __('label.name') }}</th>
                                    <th>{{ __('label.class') }}</th>
                                    <th>{{ __('label.note') }}</th>
                                    <th>{{ __('label.grade') }}</th>
                                    <th>{{ __('label.correction_finish?') }}</th>
                                    <th class="no-sort"><i class="zmdi zmdi-settings"></i> {{ __('label.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($no=0)
                                @foreach($exam_results as $exam_result)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" value="{{$exam_result->id}}" name="exam_result_id[]" class="form-check-input">
                                            <label class="form-check-label">-</label>
                                        </div>
                                    </td>
                                    <td>{{++$no}}</td>
                                    <td>{{$exam_result->user}}</td>
                                    <td>{{$exam_result->grade}}</td>
                                    <td class="is-remedial">
                                        @if($exam_result->is_remedial == 0)
                                            @if($exam_result->remedial_score == 0)
                                                <span class="text-success">{{ __('label.passed') }}</span>
                                            @else
                                                <span class="text-success">{{ __('label.pass_with_remedial') }}</span>
                                            @endif
                                        @else
                                            <span class="text-danger">{{ __('label.failed') }}</span>
                                        @endif
                                    </td>
                                    <td class="final-score">{{$exam_result->final_score}}</td>
                                    <td>
                                        @if($exam_result->correction_status == 1)
                                            <button type="button" class="btn btn-toggle correction-status-toggle active" data-toggle="button" aria-pressed="true" autocomplete="off" data-exam-result-id="{{$exam_result->id}}">
                                                <div class="handle"></div>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-toggle correction-status-toggle" data-toggle="button" aria-pressed="false" autocomplete="off" data-exam-result-id="{{$exam_result->id}}">
                                                <div class="handle"></div>
                                            </button>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="material-action">
                                            <a href="{{\LaravelLocalization::localizeURL('admin/exams/results/'.$exam_result->id.'/responses')}}" class="mx-2 text-primary" title="{{ __('button-label.show_and_correct')}}"><i class="zmdi zmdi-eye"></i></a>
                                            @if($exam_result->is_remedial == 1)
                                                <a href="#" data-toggle="modal" data-target="#remedScoreInputModal"
                                                data-exam-result-id="{{$exam_result->id}}" class="text-warning mx-2 btn-input-remedial-score" title="{{ __('button-label.remed_score_input')}}"><i class="zmdi zmdi-edit"></i></a>
                                            @endif
                                            <a href="#" data-exam-result-id="{{$exam_result->id}}" data-toggle="modal" data-target="#scorePerCompetencyModal" class="btn-competency-score-summary mx-2 text-success" title="{{ __('button-label.score_per_competency')}}"><i class="zmdi zmdi-assignment"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @hasrole("Pengajar")
                        <div class="col-lg-3 col-12 mb-3">
                            <button type="submit" class="btn btn-warning btn-raised waves-effect">{{ __('button-label.batch_delete')}}</button>
                        </div>
                        @endhasrole
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('js/table2excel.js')}}"></script>
<script>
    $(document).ready(function(){
        $("#btnExportEvaluationResult").click(function(){
            $("#tableEvaluationResult").table2excel({
                name: "{!! __('label.evaluation_result') !!} {!! $exam->title !!}",
                filename: "{!! __('label.evaluation_result') !!} {!! $exam->title !!}",
                fileext: ".xls",
                columns: [1,2,3,5]
            }); 
        });
    });
</script>
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
        let exam_result_id;
        let remedialInputBtn;

        $('.btn-toggle').on('click',function(){

            let status = $(this).attr("aria-pressed")
            exam_result_id = $(this).data("exam-result-id")

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                url: '{!! \LaravelLocalization::localizeURL("/") !!}/admin/exams/results/'+exam_result_id+'/status/change',
                type: 'patch',
                dataType: 'json',
                data: {
                    status: status,
                },
                success: function(response){
                    $('.alert-danger').slideUp(500)
                    $('.alert-success').slideDown(500).delay(1000).slideUp()
                    $('.alert-success').text(response['message'])
                },
                error: function(response){
                    $('.alert-success').slideUp(500)
                    $('.alert-danger').slideDown(500).delay(1000).slideUp()
                    $('.alert-danger').text("{!! __('messages.correction_status_unchanged') !!}")
                    console.log(response)
                },
            })
        });

        $('.btn-input-remedial-score').on('click', function(){

            remedialInputBtn = $(this)
            exam_result_id = $(this).data("exam-result-id")

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                url: '{!! \LaravelLocalization::localizeURL("/") !!}/admin/exams/results/'+exam_result_id+'/remedial',
                type: 'get',
                dataType: 'json',
                success: function(response){
                    $('#remedialScoreInput').val(response['remedial_score'])
                    $('#remedialSelect').val(response['is_remedial'])
                },
                error: function(response){
                    console.log(response)
                },
            })
        });

        $('#btnSaveRemedialScore').on('click', function(e){

            e.preventDefault()
            let is_remedial = $('#remedialSelect').val()
            let remedial_score = $('#remedialScoreInput').val()

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                url: '{!! \LaravelLocalization::localizeURL("/") !!}/admin/exams/results/'+exam_result_id+'/remedial',
                type: 'patch',
                dataType: 'json',
                data: {
                    is_remedial: is_remedial, remedial_score: remedial_score,
                },
                success: function(response){
                    swal({
                        text: response['message'],
                        icon: "success",
                    });
                    $('#remedScoreInputModal').modal('hide')
                    remedialInputBtn.parent().parent().siblings('td.is-remedial').html(response['exam_status'])
                    remedialInputBtn.parent().parent().siblings('td.final-score').text(response['final_score'])
                },
                error: function(response){
                    swal({
                        text: "{!! __('messages.remed_score_unsaved') !!}",
                        icon: "error",
                    });
                },
            })
        });

        $('.btn-competency-score-summary').on('click',function(){
            $('.alert-success').hide()
            $('.alert-danger').hide()

            exam_result_id = $(this).data('exam-result-id')
            
            $.ajax({
                url: "{!! route('exams.results.competencies.score') !!}",
                type: 'get',
                data: {
                    exam_result_id: exam_result_id,
                },
                beforeSend: function(){
                    $('#competencyScoreSummaryWrapper').html("<tr class='text-center'><td colspan='4'>Loading...</td></tr>");
                },
                success:function(data)
                {
                    console.log(data)
                    $('#competencyScoreSummaryWrapper').html(data['content']);
                },
                error:function(data){
                    console.log(data['error'])
                }
            });
        });
    });
</script>
@stop