@extends('layouts.master')

@section('title')
    {{ __('section-title.subject_edit') }}
@endsection
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>{{ __('section-title.subject_edit') }}</strong></h2>
            </div>
            <div class="body">
                <form action="{{\LaravelLocalization::localizeURL('admin/subjects/'.$subject->id)}}" method="POST">
                    @csrf
                    @method('patch')
                    <div class="row clearfix">
                        <div class="col-lg-8 col-12">
                            <div class="form-group">
                                <input type="text" placeholder="{{__('label.subject_name')}}" name="name" value="{{$subject->name}}" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.update') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection