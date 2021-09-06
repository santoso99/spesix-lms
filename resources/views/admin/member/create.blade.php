@extends('layouts.master')
@section('title')
    {{ __('section-title.school_member_import') }}
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
                <h2><strong>Import</strong> data</h2>
                <ul class="header-dropdown">
                    <li>
                        <a role="button" href="{{asset('doc/format-import-data-anggota-sekolah.xlsx')}}" download>
                            {{ __('form-label.file_format_download') }}
                            <i class="ml-2 fas fa-file-excel"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="body">
                <form action="{{\LaravelLocalization::localizeURL('admin/members/import')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <p>{{ __('messages.school_member_import') }}</p>
                    <div class="row">
                        <div class="col-lg-6 col-12 form-group">
                            <label>{{ __('form-label.excel_upload') }} <span class="text-danger">* (Max: 2MB)</span></label>
                            <input type="file" name="member_file" class="dropify" data-max-file-size="2000K" data-allowed-file-extensions="xlsx xls">
                            @error('member_file')
                            <div class="form-grop">
                                <span class="text-danger" role="alert">
                                    {{$message}}
                                </span>
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 form-group">
                            <button type="submit" class="btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.import') }}</button>
                        </div>
                    </div>
                    <span><b>{{__('label.note')}}</b></span><br>
                    <span>{{ __('messages.school_member_import_note') }}</span>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
@section('page-script')
<script src="{{asset('assets/plugins/dropify/js/dropify.min.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/dropify.js')}}"></script>
@stop