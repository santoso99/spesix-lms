@extends('layouts.home-template')

@section('title')
    {{$exam->title}}
@endsection

@section('content')
<div id="main" class="content">
    <div class="container">
        <div class="row exam-wrapper">
            <div class="col-lg-3 col-sm-12 d-none d-md-block">
                @include('frontpage.exam-sidebar')
            </div>
            <div class="col-lg-9 col-md-12 col-sm-12">
                <div id="examQuestionWrapper" class="card-topic card-tab-topic py-3">
                    <div class="question-navigation d-flex justify-content-between">
                        <a href="{{\LaravelLocalization::localizeURL('exams/'.$exam->id.'/questions/'.$question->id.'/prev')}}" class="text-dark"><i class="fa fa-arrow-left font-weight-bold"></i></a>
                        <h4>{{$number}} {{ __('label.from')}} {{$exam->total_question}}</h4>
                        <a href="{{\LaravelLocalization::localizeURL('exams/'.$exam->id.'/questions/'.$question->id.'/next')}}" class="btn-next-question text-purple">{{ __('button-label.question_skip')}}</a>
                    </div>
                    <div class="question-text pb-3">
                        {!! $question->question !!}
                    </div>
                    <div class="question-answer">
                        <form action="{{\LaravelLocalization::localizeURL('exams/'.$exam->id.'/questions/'.$question->id.'/submit')}}" method="POST">
                            @csrf
                            <input type="hidden" name="basic_competency_id" value="{{$competency_id}}">
                            @if($question->question_type_id == 2)
                                <div class="form-group">
                                    <textarea class="form-control" name="answer" rows="5">{!! $exam_response->answer ?? null !!}</textarea>
                                </div>
                            @elseif($question->question_type_id == 1)
                                @if(isset($exam_response))
                                    @foreach($question->answerChoices as $answer_choice)
                                    <div class="card-answer-option">
                                        @if($answer_choice->id == $exam_response->answer_choice_id)
                                            <label class="radio-label correct" style="background-color: rgb(201, 245, 165);">
                                        @else
                                            <label class="radio-label">
                                        @endif
                                                <input type="radio" name="answer_choice_id" value="{{$answer_choice->id}}">
                                                <span class="custom-radio-input">{{$answer_choice->label}}</span>
                                                <span>{{$answer_choice->text}}</span>
                                            </label>
                                    </div>
                                    @endforeach
                                @else
                                    @foreach($question->answerChoices as $answer_choice)
                                    <div class="card-answer-option">
                                        <label class="radio-label">
                                            <input type="radio" name="answer_choice_id" value="{{$answer_choice->id}}">
                                            <span class="custom-radio-input">{{$answer_choice->label}}</span>
                                            <span>{{$answer_choice->text}}</span>
                                        </label>
                                    </div>
                                    @endforeach
                                @endif
                            @endif
                            <div class="d-flex justify-content-between mt-5">
                                <a href="{{\LaravelLocalization::localizeURL('exams/'.$exam->id)}}"><i class="fa fa-chevron-left"></i> {{ __('button-label.question_index')}}</a>
                                <button type="submit" data-question-id="1" class="btn btn-lg bg-purple text-light btn-next-question"><i class="fa fa-check mr-2"></i> {{ __('button-label.submit_response')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection