@extends('layouts.master')

@section('title')
    {{ __('section-title.evaluation_create') }}
@endsection
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>{{ __('section-title.evaluation_create') }}</strong></h2>
            </div>
            <div class="body">
                <form action="{{\LaravelLocalization::localizeURL('admin/exams')}}" method="POST">
                    @csrf
                    <div class="row">
                        @include('admin.exam.form')
                        <div class="col-12 form-group text-right">
                            <button type="submit" class="btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.save')}} & {{ __('section-title.question_create')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page-script')
<script src="{{asset('assets/plugins/momentjs/moment.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/basic-form-elements.js')}}"></script>
@stop