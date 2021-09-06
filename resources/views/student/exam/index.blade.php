@extends('layouts.master')

@section('title')
    {{ __('section-title.evaluation_data') }}
@endsection
@section('page-style')
<!-- Fontawesome CSS -->
<link rel="stylesheet" href="{{asset('css/all.min.css')}}">
@stop
@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="body topic-list-wrapper">
                @include('frontpage.exam.content')
            </div>
        </div>
    </div>
</div>
@endsection
@section('page-script')
@stop