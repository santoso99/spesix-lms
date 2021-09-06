@extends('layouts.master')

@section('title')
    {{ __('section-title.question_show') }}
@endsection

@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <td style="width: 25%;"><i class="zmdi zmdi-label mr-2"></i> {{ __('label.question_type') }}</td>
                            <td style="width: 5%;">:</td>
                            <td style="width: 70%;"><b>{{$question->questionType->name}}</b></td>
                        </tr>
                        <tr>
                            <td><i class="zmdi zmdi-collection-bookmark mr-2"></i> {{ __('label.subject') }}</td>
                            <td>:</td>
                            <td><b>{{$question->subject->name}}</b></td>
                        </tr>
                        <tr>
                            <td><i class="zmdi zmdi-format-color-text mr-2"></i> {{ __('label.name') }}</td>
                            <td>:</td>
                            <td><b>{{$question->title}}</b></td>
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
            <div class="body">
                <div id="exam-question-1">
                    <h3><u>{{ __('label.question') }}:</u></h3>
                    <div class="question-text pb-3">
                        {!! $question->question !!}
                    </div>
                    <div class="question-answer">
                        <!-- <form action=""> -->
                            @foreach ($question->answerChoices as $answer_choice)
                            <div class="card-answer-option">
                                <label class="radio-label @if($answer_choice->is_answer == 1) correct @endif}}">
                                    <input type="radio" name="answer">
                                    <span class="custom-radio-input">{{$answer_choice->label}}</span>
                                    <span>{!! $answer_choice->text !!}</span>
                                </label>
                            </div>
                            @endforeach
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection