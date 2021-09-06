@extends('layouts.master')

@section('title')
    {{ __('section-title.student_edit') }}
@endsection
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>Edit</strong> Student Data</h2>
            </div>
            <div class="body">
                <form class="new-added-form" method="POST" action="{{ \LaravelLocalization::localizeURL('admin/students/'.$student->id) }}">
                    @csrf
                    @method('patch')
                    <div class="row">
                        @include('admin.student.form')
                        <div class="col-12 form-group text-right">
                            <button type="submit" class="btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection