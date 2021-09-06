@extends('layouts.master')

@section('title')
{{ __('label.result_of')}} {{$exam_result->exam->title}}
@endsection

@section('content')
<div class="row clearfix">
    <div class="col-lg-6 col-12">
        <div class="card">
            <div class="header">
                <div>
                    <h2><strong>{{$exam_result->user->name}}</strong></h2>
                    <span>{{ __('label.class')}} {{$exam_result->user->grade->name}}</span>
                </div>
            </div>
            <div class="body">
                <div class="rounded-circle outter-counter-wrapper">
                    @if($exam_result->is_remedial == 0)
                        <div class="rounded-circle inner-counter-wrapper">
                            <span></span>
                            <span class="text-soft-red text-large"><b>{{$exam_result->score}}</b></span>
                            <span>/{{$exam_result->exam->max_score}}</span><br>
                            @if($exam_result->remedial_score == 0)
                                <span>{{ __('label.passed') }}</span>
                            @else
                                <span>{{ __('label.pass_with_remedial') }}</span>
                            @endif
                        </div>
                        <div class="rounded-circle badge-star badge-excellent">
                            <span class="zmdi zmdi-thumb-up"></span>
                        </div>
                    @else
                        <div class="rounded-circle inner-counter-wrapper">
                            <span></span>
                            <span class="text-soft-red text-large"><b>{{$exam_result->score}}</b></span>
                            <span>/{{$exam_result->exam->max_score}}</span><br>
                            <span>{{ __('label.failed') }}</span>
                        </div>
                        <div class="rounded-circle badge-star badge-less">
                            <span class="zmdi zmdi-mood"></span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="card">
            <div class="header">
                <h2><strong>{{ __('label.summary')}}</strong></h2>
            </div>
            <div class="body">
                <div class="question-summary-wrapper table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <td><i class="zmdi zmdi-time"></i></td>
                            <td>{{ __('label.question_count')}}</td>
                            <td class="text-soft-red">{{$exam_result->exam->total_question}}</td>
                        </tr>
                        <tr>
                            <td><i class="zmdi zmdi-fast-forward"></i></td>
                            <td>{{ __('label.question_answered')}}</td>
                            <td class="text-soft-red">{{$exam_result->total_answered_question}}</td>
                        </tr>
                        <tr>
                            <td><i class="zmdi zmdi-check-circle"></i></td>
                            <td>{{ __('label.correct_answer')}}</td>
                            <td class="text-soft-red">{{$exam_result->total_correct_answer}}</td>
                        </tr>
                        <tr>
                            <td><i class="zmdi zmdi-close-circle"></i></td>
                            <td>{{ __('label.wrong_answer')}}</td>
                            <td class="text-soft-red">{{$exam_result->total_wrong_answer}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <div>
                    <h2><strong>{{ __('section-title.response_correction')}}</strong></h2>
                    <small>{{ __('messages.scoring')}}</small>
                </div>
                <ul class="header-dropdown">
                    <li>
                        <a role="button" href="{{\LaravelLocalization::localizeURL('admin/exams/'.$exam_result->exam->id.'/results')}}"><i class="zmdi zmdi-arrow-left"></i> {{ __('button-label.back_to_eval_result')}}</a>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive result-table-box">
                    <table id="table-question" class="table table-hover table-fixed">
                        <thead>
                            <tr>
                                <th style="width: 10%;">{{ __('label.number')}}</th>
                                <th style="width: 40%;">{{ __('label.question')}}</th>
                                <th style="width: 40%;">{{ __('label.basic_competency')}}</th>
                                <th style="width: 10%;">{{ __('label.grade')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($no=0)
                            @foreach($exam_questions as $exam_question)
                                @if($exam_responses->contains('question_id',$exam_question->id))
                                    <tr class="filled clickable-row" data-href="{{\LaravelLocalization::localizeURL('student/exams/results/'.$exam_result->id.'/questions/'.$exam_question->id)}}">
                                        <td><span class="badge-number">{{++$no}}</span></td>
                                        <td class="question">
                                            <h6 class="mb-0 font-weight-bold">{!! $exam_question->excerpt !!}</h6>
                                        </td>
                                        <td class="kd-question">
                                            {{$exam_question_raw->where('question_id',$exam_question->id)->first()->basicCompetency->competency ?? null}}
                                        </td>
                                        <td>
                                            @if($exam_responses->where('question_id',$exam_question->id)->first()->status == 1)
                                                <i class="zmdi zmdi-check text-success mr-2"></i>
                                            @else
                                                <i class="zmdi zmdi-close text-danger mr-2"></i>
                                            @endif
                                             {{$exam_responses->where('question_id',$exam_question->id)->first()->score}}
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td><span class="badge-number">{{++$no}}</span></td>
                                        <td class="question">
                                            <h6 class="mb-0 font-weight-bold">{!! $exam_question->excerpt !!}</h6>
                                        </td>
                                        <td class="kd-question">
                                            {{$exam_question_raw->where('question_id',$exam_question->id)->first()->basicCompetency->competency ?? null}}
                                        </td>
                                        <td>
                                            <i class="zmdi zmdi-close text-danger mr-2"></i>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection