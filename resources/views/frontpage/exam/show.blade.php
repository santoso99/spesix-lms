@extends('layouts.home-template')

@section('title')
    {{ __('section-title.eval_preview')}}
@endsection

@section('content')
<div id="main" class="content">
    <div class="container">
        <div class="row exam-wrapper">
            <div class="col-lg-3 col-sm-12 exam-sidebar-wrapper">
                @include('frontpage.exam-sidebar')
            </div>
            <div class="col-lg-9 col-md-12 col-sm-12">
                <div id="exam-question" class="card-topic card-tab-topic">
                    <div class="header d-flex align-items-center">
                        <div id="question-counter">
                            <span>{{ __('label.question_answered') }}: </span>
                            <br>
                            <span id="question-answered">{{$total_answered_question}}</span>
                            <span id="question-total">/{{$exam->total_question}}</span>
                        </div>
                        <div id="start-test">
                            <a href="{{\LaravelLocalization::localizeURL('exams/'.$exam->id.'/start')}}" class="btn text-light">Start Test</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="table-question" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{{ __('label.number')}}</th>
                                    <th>{{ __('label.type')}}</th>
                                    <th>{{ __('label.question')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($no=0)
                                @foreach($exam_questions as $exam_question)
                                <tr class="@if($exam_responses->contains('question_id',$exam_question->id)) filled @endif clickable-row" data-href="{{\LaravelLocalization::localizeURL('exams/'.$exam->id.'/questions/'.$exam_question->id)}}">
                                    <td><span class="badge-number">{{++$no}}</span></td>
                                    @if($exam_question->question_type_id == 1)
                                    <td>
                                        <span class="badge badge-pill badge-primary">{{ __('label.multiple_choice')}}</span>
                                    </td>
                                    <td>
                                        <div id="question-item-wrapper">
                                            <h6 class="mb-2">{!!$exam_question->excerpt!!}</h6>
                                            {{-- <small class="text-secondary mr-3">Jawaban Kamu:</small> --}}
                                            {{-- <small class="text-purple"></small> --}}
                                        </div>
                                    </td>
                                    @elseif($exam_question->question_type_id == 2)
                                    <td>
                                        <span class="badge badge-pill badge-warning">{{ __('label.essay')}}</span>
                                    </td>
                                    <td>
                                        <div id="question-item-wrapper">
                                            <h6 class="mb-0">{!!$exam_question->excerpt!!}</h6>
                                            {{-- <small class="text-secondary mr-3">Jawaban Kamu:</small> --}}
                                            {{-- <small class="text-purple">-</small> --}}
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection