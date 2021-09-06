@extends('layouts.master')

@section('title')
    {{ __('section-title.task_submission_show') }}
@endsection

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
                <h2>{{ __('label.task_grading') }} <strong>{{$submission->task}}</strong></h2>
                <ul class="header-dropdown">
                    <li>
                        <a role="button" href="{{\LaravelLocalization::localizeURL('admin/tasks/'.$submission->task_id.'/submissions')}}"><i class="zmdi zmdi-arrow-left"></i> {{ __('button-label.back_to_task_submission') }}</a>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div>
                    <table class="table table-borderless" style="table-layout: fixed;">
                        <tr>
                            <td class="w-3p"><i class="zmdi zmdi-account"></i></td>
                            <td class="w-15p">{{ __('label.student') }}</td>
                            <td class="font-weight-bold">{{$submission->user}}</td>
                        </tr>
                        <tr>
                            <td class="w-3p"><i class="zmdi zmdi-badge-check"></i></td>
                            <td class="w-15p">{{ __('label.class') }}</td>
                            <td class="font-weight-bold">{{$submission->grade}}</td>
                        </tr>
                        <tr>
                            <td class="w-3p"><i class="zmdi zmdi-file text-dark"></i></td>
                            <td class="w-15p">{{ __('label.task_file') }}</td>
                            <td class="font-weight-bold"><a href="{{asset('storage/'.$submission->submission_path)}}">{{$submission->submission_filename}}</a></td>
                        </tr>
                        <tr>
                            <td class="w-3p"><i class="zmdi zmdi-time"></i></td>
                            <td class="w-15p">{{ __('label.status') }}</td>
                            <td>
                                @if($submission->status == 1)
                                    <span class="badge badge-pill badge-success">{{ __('label.on_time') }}</span>
                                @elseif($submission->status == 2)
                                    <span class="badge badge-pill badge-warning">{{ __('label.late') }}</span>
                                @else
                                    <span class="badge badge-pill badge-secondary">{{ __('label.not_submit_yet') }}</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="mt-5">
                    <h3>{{ __('label.task_grading_form') }}</h3>
                </div>
                <form action="{{\LaravelLocalization::localizeURL('admin/tasks/submissions/'.$submission->id)}}" method="POST">
                    @csrf
                    @method('patch')
                    <div class="row clearfix">
                        <div class="col-lg-2 col-12 form-group">
                            <label>{{ __('label.grade') }}</label>
                            <input type="text" name="mark" class="form-control" value="{{ $submission->mark}}">
                        </div>
                        <div class="col-lg-10 col-12 form-group">
                            <label>{{ __('label.note') }}</label>
                            <textarea name="teacher_notes" class="form-control" cols="20" rows="10">{{ $submission->teacher_notes}}</textarea>
                        </div>
                        <div class="col-12 form-group text-right mg-t-8">
                            <button type="submit" class="btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection