@extends('layouts.master')

@section('title')
    {{ __('section-title.teacher_edit') }}
@endsection

@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>Edit</strong> Teacher Data</h2>
            </div>
            <div class="body">
                <form method="POST" action="{{ \LaravelLocalization::localizeURL('admin/teachers/'.$teacher->id) }}">
                    @csrf
                    @method('patch')
                    <div class="row">
                        @include('admin.teacher.form')
                        <div class="col-12 form-group text-right mg-t-8">
                            <button type="submit" class="btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection