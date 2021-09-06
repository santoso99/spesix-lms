@extends('layouts.master')

@section('title')
    {{ __('button-label.student_response_recap')}}
@endsection

@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>{{$exam->title}}</strong></h2>
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
                <h2><strong>{{ __('button-label.student_response_recap')}}</strong></h2>
                <ul class="header-dropdown">
                    <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> {{ __('label.select_class') }} <i class="zmdi zmdi-more"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-left slideUp">
                            @foreach($grades as $grade)
                                <li>
                                    <a href="{{\LaravelLocalization::localizeURL('admin/exams/'.$exam->id.'/results/responses/grades/'.$grade->id)}}">{{$grade->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="mb-3 text-right">
                    <button id="btnExportStudentResponse" type="button" class="btn btn-lg btn-success"><i class="zmdi zmdi-file-text action-icon"></i> Export {{ __('button-label.student_response_recap')}}</button>
                </div>
                <div class="table-responsive">
                    <table id="tableStudentResponse" class="table text-nowrap">
                        <thead>
                            <tr>
                                <th>{{ __('label.name')}}</th>
                                @for($i=1;$i<=count($exam_questions);$i++)
                                    <th>Soal {{$i}}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($exam_results as $exam_result)
                            <tr>
                                <td>{{$exam_result->user->name}}</td>
                                @foreach($exam_questions as $exam_question)
                                    @if($exam_question->question_type_id == 1)
                                        <td>{{$exam_question->examResponses->where('exam_result_id',$exam_result->id)->first()->answerChoice->label ?? null}}</td>
                                    @elseif($exam_question->question_type_id == 2)
                                        <td>{{$exam_question->examResponses->where('exam_result_id',$exam_result->id)->first()->answer ?? null}}</td>
                                    @endif
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('after-scripts')
<script src="{{asset('js/jquery.table2excel.js')}}"></script>
<script>
    $(document).ready(function(){
        $("#btnExportStudentResponse").click(function(){
            $("#tableStudentResponse").table2excel({
                name: "{!! __('button-label.student_response_recap') !!} {!! $exam->title !!}",
                filename: "{!! __('button-label.student_response_recap') !!} {!! $exam->title !!}",
                fileext: ".xls"
            }); 
        });
    });
</script>
@endpush