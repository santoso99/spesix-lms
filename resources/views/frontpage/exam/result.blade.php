@extends('layouts.home-template')

@section('title')
    {{ __('section-title.evaluation_finish')}}
@endsection

@section('content')
<div id="main" class="content">
    <div class="container">
        <div class="row exam-wrapper">
            <div class="col-lg-3 col-sm-12">
                @include('frontpage.exam-sidebar')
            </div>
            <div class="col-lg-9 col-md-12 col-sm-12">
                <div class="card card-topic card-tab-topic row align-items-start text-center">
                    <div id="exam-closing" class="col-lg-6 col-sm-12">
                        <h3 class="font-weight-bold text-green">Good Job!</h3>
                        <div class="alert alert-success mb-5" role="alert">
                            {{ __('messages.eval_finish')}}
                        </div>
                        <p>{{ __('messages.eval_finish_note') }}</p>
                        <a href="{{\LaravelLocalization::localizeURL('topics/subjects/'.$exam->subject_id)}}" class="btn btn-lg bg-green btn-subject-materi-back text-light ">{{ __('button-label.back_to_subject_topic')}}</a>
                        <a href="{{\LaravelLocalization::localizeURL('topics')}}" class="btn btn-lg bg-warning text-dark">{{ __('button-label.to_topic_index')}}</a>
                    </div>
                    <div id="exam-summary" class="col-lg-6 col-sm-12">
                        <h4 class="font-weight-bold text-soft-red">{{ __('label.summary')}}</h4>
                        <div class="rounded-circle outter-counter-wrapper">
                            <div class="rounded-circle inner-counter-wrapper">
                                <span>{{$total_answered_question}}</span>
                                <span>/{{$exam->total_question}}</span>
                                <br>
                                <span class="text-soft-red"><b>{{ __('label.question_answered') }}</b></span>
                            </div>
                            <div class="rounded-circle badge-star">
                                <span class="fa fa-star text-light"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection