@extends('layouts.master')

@section('title')
{{ __('label.result_of')}} {{$exam_result->exam->title}}
@endsection

@section('content')
<div class="row clearfix">
    <div class="col-lg-6 col-12">
        <div class="card">
            <div class="body">
                <h3><strong>{{ __('label.grade')}}</strong></h3>
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
                            <span class="zmdi zmdi-mood-bad"></span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-12">
        <div class="card">
            <div class="body">
                <h3>{{ __('label.summary')}}</h3>
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
    <div class="col-lg-12 col-12">
        @if(session('status'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="card">
            <div class="header">
                <h2><strong>{{ __('label.answer_correction')}}</strong></h2>
            </div>
            <div class="body">
                <div class="table-responsive result-table-box">
                    <table id="table-question" class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>{{ __('label.number')}}</th>
                                <th>{{ __('label.type')}}</th>
                                <th>{{ __('label.question')}}</th>
                                <th>{{ __('label.score')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($no=0)
                            @foreach($exam_questions as $exam_question)
                                @if($exam_responses->contains('question_id',$exam_question->id))
                                    <tr class="filled clickable-row" data-href="{{\LaravelLocalization::localizeURL('student/exams/results/'.$exam_result->id.'/questions/'.$exam_question->id)}}">
                                        <td><span class="badge-number">{{++$no}}</span></td>
                                        @if($exam_question->question_type_id == 1)
                                            <td>
                                                <span class="badge badge-pill badge-primary">{{ __('label.multiple_choice')}}</span>
                                            </td>
                                            <td>
                                                <div id="question-item-wrapper">
                                                    <h6 class="mb-0">{!! $exam_question->excerpt !!}</h6>
                                                    <span></span>
                                                    {{-- <small class="text-secondary mr-3">Jawaban Kamu:</small>
                                                    <small class="text-purple">{{$exam_responses->where('question_id',$exam_question->id)->first()->answerChoice->label}}</small> --}}
                                                </div>
                                            </td>
                                        @elseif($exam_question->question_type_id == 2)
                                            <td>
                                                <span class="badge badge-pill badge-warning">{{ __('label.essay')}}</span>
                                            </td>
                                            <td>
                                                <div id="question-item-wrapper">
                                                    <h6 class="mb-0">{!! $exam_question->excerpt !!}</h6>
                                                    <span></span>
                                                    {{-- <small class="text-secondary mr-3">Jawaban Kamu:</small>
                                                    <small class="text-purple">{{$exam_responses->where('question_id',$exam_question->id)->first()->answer}}</small> --}}
                                                </div>
                                            </td>
                                        @endif
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
                                    <tr class="clickable-row" data-href="{{\LaravelLocalization::localizeURL('student/exams/results/'.$exam_result->id.'/questions/'.$exam_question->id)}}">
                                        <td><span class="badge-number">{{++$no}}</span></td>
                                        @if($exam_question->question_type_id == 1)
                                            <td>
                                                <span class="badge badge-pill badge-primary">{{ __('label.multiple_choice')}}</span>
                                            </td>
                                            <td>
                                                <div id="question-item-wrapper">
                                                    <h6 class="mb-0">{!! $exam_question->excerpt !!}</h6>
                                                </div>
                                            </td>
                                        @elseif($exam_question->question_type_id == 2)
                                            <td>
                                                <span class="badge badge-pill badge-warning">{{ __('label.essay')}}</span>
                                            </td>
                                            <td>
                                                <div id="question-item-wrapper">
                                                    <h6 class="mb-0">{!! $exam_question->excerpt !!}</h6>
                                                </div>
                                            </td>
                                        @endif
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