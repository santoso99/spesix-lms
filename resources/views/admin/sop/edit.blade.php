@extends('layouts.master')

@section('title')
    {{ __('section-title.sop_edit') }}
@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/dropify/css/dropify.min.css')}}"/>
@stop

@section('content')
<div class="row clearfix">
    <div class="col-12">
        <div class="card">
            <div class="header">
                <h2><strong>{{ __('section-title.sop_edit') }}</strong></h2>
            </div>
            <div class="body">
                <form action="{{\LaravelLocalization::localizeURL('admin/sops/'.$sop->id)}}" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    @include('admin.sop.form')
                    <div class="row clearfix">
                        <div class="col-sm-8 offset-sm-2">
                            <button type="submit" class="btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')
<script src="{{asset('assets/plugins/dropify/js/dropify.min.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/dropify.js')}}"></script>
@stop