@extends('layouts.master')

@section('title')
{{ __('label.answer_of')}} {{$exam_result->exam->title}}
@endsection
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2>{{ __('label.answer_of')}} <strong>{{$exam_result->exam->title}} {{'- '.$exam_result->exam->subject->name}}</strong></h2>
                <ul class="header-dropdown">
                    <li>
                        <a role="button" href="{{\LaravelLocalization::localizeURL('admin/exams/results/'.$exam_result->id.'/responses')}}">
                            <i class="zmdi zmdi-arrow-left"></i> {{ __('button-label.back_to_answer_recap')}}
                        </a>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div id="exam-question-1">
                    <div class="question-navigation d-flex justify-content-between">
                        <a href="{{\LaravelLocalization::localizeURL('student/exams/results/'.$exam_result->id.'/questions/'.$question->id.'/prev')}}"><i class="zmdi zmdi-arrow-left font-weight-bold"></i></a>
                        <h4>{{ __('label.question')}} {{$number}} {{ __('label.from')}} {{$exam_result->exam->total_question}}</h4>
                        <a href="{{\LaravelLocalization::localizeURL('student/exams/results/'.$exam_result->id.'/questions/'.$question->id.'/next')}}"><i class="zmdi zmdi-arrow-right font-weight-bold"></i></a>
                    </div>
                    <div class="question-text pt-5 pb-3">
                        <p>{{ __('label.question')}}:</p>
                        <b>{!! $question->question !!}</b>
                    </div>
                    <p>{{ __('label.answer')}}:</p>
                    @if($question->question_type_id == 1)
                        <div class="question-answer">
                            @if(isset($exam_response))
                                @foreach($question->answerChoices as $answer_choice)
                                <div class="card-answer-option">
                                    @if($answer_choice->id == $exam_response->answer_choice_id)
                                        <label class="radio-label answer">
                                    @else
                                        <label class="radio-label">
                                    @endif
                                            <input type="radio" name="answer_choice_id">
                                            <span class="custom-radio-input">{{$answer_choice->label}}</span>
                                            <span>{{$answer_choice->text}}</span>
                                        </label>
                                </div>
                                @endforeach
                                <div class="mt-3 d-flex justify-content-between">
                                    <div>
                                        <span class="mr-3">{{ __('label.answer_key')}}:</span><span class="font-weight-bold text-purple answer-score">{{$question->answerChoices->where('is_answer',1)->first()->label}}</span>
                                    </div>
                                    <div>
                                        <span class="mr-3">{{ __('label.score')}}:</span><span class="font-weight-bold text-purple answer-score">{{$exam_response->score}}</span>
                                    </div>
                                </div>
                            @else
                                @foreach($question->answerChoices as $answer_choice)
                                <div class="card-answer-option">
                                    <label class="radio-label">
                                        <input type="radio" name="answer_choice_id">
                                        <span class="custom-radio-input">{{$answer_choice->label}}</span>
                                        <span>{{$answer_choice->text}}</span>
                                    </label>
                                </div>
                                @endforeach
                                <div class="text-right mt-3">
                                    <span class="mr-3">{{ __('label.score')}}:</span><span class="font-weight-bold text-purple answer-score">-</span>
                                </div>
                            @endif
                        </div>
                    @elseif($question->question_type_id == 2)
                        <div class="question-answer">
                            @if(isset($exam_response))
                                @hasrole('Siswa')
                                <div class="bg-light-gray mb-5 p-3">
                                    {{$exam_response->answer}}
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-8">
                                        <span class="font-weight-bold">{{ __('label.correction_note')}}:</span><br>
                                        <input type="text" class="form-control" disabled value="{{$exam_response->feedback}}">
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <span><b>{{ __('label.answer_correction')}}</b></span>
                                        <select class="form-control show-tick" name="status" disabled>
                                            <option value="0" @if($exam_response->status == 0) selected @endif>{{ __('label.wrong')}}</option>
                                            <option value="1" @if($exam_response->status == 1) selected @endif>{{ __('label.correct')}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <span><b>{{ __('label.score')}}</b></span>
                                        <input type="text" class="form-control" disabled value="{{$exam_response->score}}">
                                    </div>
                                </div>
                                @endhasrole
                                @hasrole('Pengajar')
                                <form action="{{\LaravelLocalization::localizeURL('admin/exams/results/'.$exam_result->id.'/responses/'.$exam_response->id)}}" method="post">
                                    @csrf
                                    @method('patch')
                                    <div class="bg-light-gray mb-5 p-3">
                                        {{$exam_response->answer}}
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-8">
                                            <span class="font-weight-bold">{{ __('label.correction_note')}}:</span><br>
                                            <input type="text" class="form-control" name="feedback" value="{{$exam_response->feedback}}">
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <span><b>{{ __('label.answer_correction')}}</b></span>
                                            <select class="form-control show-tick" name="status">
                                                <option value="0" @if($exam_response->status == 0) selected @endif>{{ __('label.wrong')}}</option>
                                                <option value="1" @if($exam_response->status == 1) selected @endif>{{ __('label.correct')}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <span><b>{{ __('label.score')}}</b></span>
                                            <input type="text" class="form-control" name="score" value="{{$exam_response->score}}">
                                        </div>
                                    </div>
                                    <div class="text-right mt-3">
                                        <button type="submit" class="btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.save')}}</button>
                                    </div>
                                </form>
                                @endhasrole
                            @else
                                <div class="bg-light-gray mb-5 p-3"></div>
                                <div class="row">
                                    <div class="form-group col-lg-10">
                                        <span class="font-weight-bold">{{ __('label.correction_note')}}:</span><br>
                                        <input type="text" class="form-control" disabled>
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <span><b>{{ __('label.score')}}</b></span>
                                        <input type="text" class="form-control" disabled value="-">
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection