@extends('layouts.master')

@section('title')
    {{ __('section-title.avatar_edit') }}
@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/dropify/css/dropify.min.css')}}"/>
@stop

@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="card">
            <div class="header">
                <h2><strong>{{ __('section-title.avatar_edit') }}</strong></h2>
            </div>
            <div class="mb-2">
                <form id="uploadAvatarForm" method="POST" action="{{ \LaravelLocalization::localizeURL('admin/users/avatar/'.Auth::user()->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="row clearfix">
                        <div class="col-lg-9 col-12">
                            <div class="card">
                                <div class="body">
                                    <div class="form-group mt-0">
                                        <label>{{ __('form-label.image_upload') }}</label>
                                        <input id="avatar" type="file" name="avatar" class="dropify" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.save') }}</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-12 text-center">
                            <div class="card">
                                <div class="body">
                                    <p>{{ __('label.avatar') }}</p>
                                    <img src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : asset('img/avatar/default-user.jpg') }}" width="150">
                                </div>
                            </div>
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