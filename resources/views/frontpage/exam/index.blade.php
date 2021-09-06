@extends('layouts.home-template')

@section('title')
    {{ __('label.evaluation')}}
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
                <h2 class="title">{{ __('section-title.ongoing_evaluation')}}</h2>
                @unlessrole("Siswa")
                <span><i>*{{ __('messages.user_only_evaluation')}}</i></span>
                @endunlessrole
                @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show mb-5" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div id="examListOutterWrapper">
                    @include('frontpage.exam.content')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection