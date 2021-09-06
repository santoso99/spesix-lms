@extends('layouts.home-template')

@section('title')
{{ __('label.evaluation')}}
@endsection

@section('before-styles')
<!-- Treeview Gijgo CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/css/gijgo.min.css">
@endsection

@section('content')
<div id="main" class="content">
    <div class="container">
        <div class="row">
            <div id="course-side-nav" class="col-md-3 col-sm-12">
                <h4 class="font-weight-bold">{{ __('section-title.topic_index')}}</h4>
                @include('frontpage.topic-sidebar')
            </div>
            <div class="col-md-9 col-sm-12">
                <div id="exam-list-wrapper">
                    <div class="card card-topic">
                        <div id="examListWrapper" class="card-body p-0">
                            <div class="exam-item row align-items-center">
                                <div class="exam-info col-12">
                                    <h4 class="mb-2"><i class="fa fa-clipboard-list text-dark"></i> {{$exam->title}}</h4>
                                    <p><b>{{$exam->subject->name}}</b> | {{$exam->user->name}} | {{$exam->date->format('d F Y')}} | {{$exam->time_start.' - '.$exam->time_end}}</p>
                                    <span class="text-secondary">{{ __('label.question_count')}}: {{$exam->total_question}}</span>
                                </div>
                                @unlessrole('Siswa')
                                <div class="text-center w-100">
                                    @isset($forbidden_msg)
                                        <p>-- {{$forbidden_msg}} --</p>
                                    @endisset
                                </div>
                                @endunlessrole
                            </div>
                            <div class="mt-5 px-5">
                                @hasrole('Siswa')
                                <p>{{ __('messages.input_eval_code') }}</p>
                                <form action="{{\LaravelLocalization::localizeURL('exams/'.$exam->id.'/unlock')}}" method="POST">
                                    @csrf
                                    <div class="form-group row">
                                    <label for="enrollCode" class="col-sm-2 col-form-label">{{ __('label.access_code')}}</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="enrollCode" name="enroll_code">
                                        @isset($error)
                                            <div class="form-group mt-2">
                                                <span class="text-danger" role="alert">
                                                    {{$error}}
                                                </span>
                                            </div>
                                        @endisset
                                    </div>
                                    </div>
                                    <div class="form-group row">
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-lg bg-purple text-light">{{ __('button-label.start_eval')}}</button>
                                    </div>
                                    </div>
                                </form>
                                @endhasrole
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Treeview Gijgo -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/js/gijgo.min.js"></script>
@endpush