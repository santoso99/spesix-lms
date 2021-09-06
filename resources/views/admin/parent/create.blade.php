@extends('layouts.master')

@section('title')
    {{ __('section-title.parent_add') }}
@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>Add</strong> Parent Account</h2>
            </div>
            <div class="body">
                <p>{{ __('label.student')." : ".$student->name }}</p>
                <form method="POST" action="{{ \LaravelLocalization::localizeURL('admin/students/'.$student->id.'/parents') }}">
                    @csrf
                    <div class="row clearfix">
                        @include('admin.parent.form')
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">{{ __('button-label.save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
