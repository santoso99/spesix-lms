@extends('layouts.home-template')

@section('title')
    {{$task->name}}
@endsection

@section('before-styles')
<!-- Treeview Gijgo CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/css/gijgo.min.css">
@endsection

@section('content')
<div id="main" class="content">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                {{-- <li class="breadcrumb-item"><a href="/course-list-empty.php">Kelas X</a></li> --}}
                <li class="breadcrumb-item">
                    <a href="{{\LaravelLocalization::localizeURL('topics/subjects/'.$task->subject_id)}}">{{ $task->subject->name }}</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{\LaravelLocalization::localizeURL('topics/'.$task->learning_topic_id)}}">{{ $task->learningTopic->name }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{$task->name}}</li>
            </ol>
        </nav>
        <div class="row">
            <div id="course-side-nav" class="col-md-3 col-sm-12">
                <h4 class="font-weight-bold">{{ __('section-title.topic_index') }}</h4>
                @include('frontpage.topic-sidebar')
            </div>
            <div class="col-md-9 col-sm-12">
                <div class="card-topic card-tab-topic">
                    <div class="py-3">
                        @if(session('status'))
                        <div class="alert alert-success alert-dismissible fade show mb-5" role="alert">
                            {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        @auth
                            @if(Auth::user()->id == $task->user_id)
                                <a href="{{\LaravelLocalization::localizeURL('admin/tasks/'.$task->id.'/edit')}}"><i class="fa fa-pencil-alt"></i> {{ __('label.edit') }}</a>
                            @endif
                        @endauth
                        <div class="w-100 d-inline-flex justify-content-between task-header">
                            <div>
                                <h3 class="title mb-0">{{$task->name}}</h3>
                                <small>{{ __('label.by') }} {{$task->user->name}} {{ __('label.at') }} {{$task->created_at}}</small>
                            </div>
                            <div class="mb-3">
                                {{ __('label.deadline') }}: <span class="text-warning font-weight-bold">{{$task->deadline}}</span>
                            </div>
                        </div>
                        <div class="description my-5">
                            {!! $task->instruction !!}
                        </div>
                        @if($task->attachment_path != null)
                        <div class="file-attachment mb-5">
                            <p class="font-weight-bold">{{ __('label.attachment_file') }}</p>
                            <a href="{{asset('storage/'.$task->attachment_path)}}" class="link-icon"> {{$task->attachment_filename}}</a>
                        </div>
                        @endif
                        @auth
                            @hasrole('Siswa')
                                @if(!$submission)
                                <div class="submission-status table-responsive">
                                    <table class="table">
                                        <tr>
                                            <td>{{ __('label.status') }}</td>
                                            <td>
                                                {{ __('label.not_submit_yet') }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                @else
                                <div class="submission-status table-responsive">
                                    <table class="table">
                                        <tr>
                                            <td>{{ __('label.status') }}</td>
                                            <td>
                                                @if($submission->status == 1)
                                                    <span class="text-success">{{ __('label.on_time') }}</span>
                                                @elseif($submission->status == 2)
                                                    <span class="text-danger">{{ __('label.late') }}</span>
                                                @else
                                                    {{ __('label.not_submit_yet') }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('label.grade') }}</td>
                                            <td>
                                                {!! $submission->mark ?? '<span class="text-secondary">'.__('label.not_graded_yet').'</span>' !!}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('label.note') }}</td>
                                            <td>{!! $submission->teacher_notes ?? '-'!!}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div>
                                    <p>Submitted File</p>
                                    <ul>
                                        <li class="submitted-file"><a href="{{asset('storage/'.$submission->submission_path)}}" class="link-icon"> {{$submission->submission_filename}}</a></li>
                                    </ul>
                                </div>
                                @endif
                                <div class="mt-5">
                                    <div class="sub-topic-title">
                                        <h4>{{ __('section-title.task_reupload') }}</h4>
                                    </div>
                                    <small><i>*{{ __('messages.task_upload_notice') }}</i></small>
                                    @if(isset($submission))
                                        <form action="{{\LaravelLocalization::localizeURL('tasks/submissions/'.$submission->id)}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                                        @method('patch')
                                    @else
                                        <form action="{{\LaravelLocalization::localizeURL('tasks/submissions')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                                    @endif
                                        @csrf
                                        <input type="hidden" name="task_id" value="{{$task->id}}">
                                        <div class="row mt-3">
                                            <div class="col-lg-10 col-12 form-group">
                                                <label class="text-danger">Max. 15 MB</label>
                                                <input type="file" class="form-control file" name="task_file" data-browse-on-zone-click="true" required>
                                                @error('task_file')
                                                <div class="form-grop">
                                                    <span class="text-danger" role="alert">
                                                        {{$message}}
                                                    </span>
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="col-lg-2 col-12 pt-5">
                                                <button class="btn btn-lg btn-success" style="font-size: 1.8rem">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endhasrole
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Treeview Gijgo -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/js/gijgo.min.js"></script>
@endpush