@extends('layouts.home-template')

@section('title')
    {{$topic->name}}
@endsection

@section('content')
<div id="main" class="content">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{\LaravelLocalization::localizeURL('topics/grades/'.$topic->grade_level)}}"> {{ __('label.class')}} {{$topic->grade_level}}</a></li>
                <li class="breadcrumb-item"><a href="{{\LaravelLocalization::localizeURL('topics/subjects/'.$topic->subject_id)}}">{{$topic->subject->name}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$topic->name}}</li>
            </ol>
        </nav>
        <div class="row topic-wrapper">
            <div id="course-side-nav" class="col-md-3 col-sm-12">
                <h4 class="font-weight-bold">{{ __('section-title.topic_index')}}</h4>
                @include('frontpage.topic-sidebar')
                <div class="mt-5">
                    <h4 class="font-weight-bold">{{ __('section-title.recent_access')}} <i class="fas fa-circle text-green online-icon"></i></h4>
                    <div class="user-online-box-wrap">
                        @php($active_users = Cache::get('topic-user-active'))
                        @if(isset($active_users))
                            @for($i=0;$i<count($active_users);$i++)
                                <div class="mb-3 row mx-0">
                                    <div class="col-2 px-0">
                                        <img src="{{ $active_users[$i]->avatar ? asset('storage/'.$active_users[$i]->avatar) : asset('img/avatar/default-user.jpg') }}" alt="avatar" width="30px">
                                    </div>
                                    <div class="col-8">
                                        <span>{{$active_users[$i]->name}}</span>
                                    </div>
                                    <div class="col-2 px-0">
                                        <span class="text-primary">{{$active_users[$i]->grade->name ?? "Guru"}}</span>
                                    </div>
                                </div>
                            @endfor
                        @else
                        <span>{{ __('label.no_data')}}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-9 col-sm-12">
                <div id="contentWrapper" class="content-wrapper">
                    @if($author)
                        <a href="{{\LaravelLocalization::localizeURL('admin/topics/'.$topic->id.'/edit')}}"><i class="fa fa-pencil-alt"></i> {{ __('label.edit')}}</a>
                    @endif
                    <div class="w-100 md-title-section d-sm-flex d-md-inline-flex justify-content-between">
                        <div class="text-right mb-3">
                            <span id="fullscreenSection">Fullscreen <button class="ml-2 btn btn-link btn-lg" onclick="openFullscreen()"><i class="fa fa-expand-arrows-alt"></i></button></span>
                            <span id="escFullscreenSection" style="display:none;">Quit Fullscreen Mode <button class="ml-2 btn btn-link btn-lg" onclick="closeFullscreen()"><i class="fa fa-compress-arrows-alt"></i></button></span>
                        </div>
                        <h3><b>{{$topic->name}}</b></h3>
                    </div>
                    <div class="w-100 mb-5 d-sm-flex d-md-inline-flex justify-content-between">
                        <div>
                            <img src="{{($topic->user->avatar != null) ? asset('storage/'.$topic->user->avatar) : asset('img/avatar/default-user.jpg')}}" class="rounded-circle mr-3" width="40px" alt="">
                            <span>{{$topic->user->name}}</span>
                        </div>
                        <div>
                            <p>{{ __('label.accessed')}} {{$views_count}} user(s) 
                                @hasanyrole('Admin|Supervisor|Pengajar')
                                    <a href="{{\LaravelLocalization::localizeURL('admin/topics/'.$topic->id.'/visitors')}}" title="Lihat Daftar Pengunjung"><i class="fa fa-eye"></i></a>
                                @endhasanyrole
                            </p>
                        </div>
                    </div>
                    <div class="mb-5 table-responsive">
                        <table class="table table-borderless text-dark">
                            <tr>
                                <td>{{ __('label.class')}}</td>
                                <td>:</td>
                                <td>
                                    <span class="trimmed-last">
                                        @foreach($topic->grades as $grade)
                                            {{ $grade->name.' - '}}
                                        @endforeach
                                    </span>
                                    / {{ __('label.semester')}} {{$topic->semester}}
                                </td>
                            </tr>
                            @if(count($topic->basicCompetencies)>0)
                                <tr>
                                    <td>{{ __('label.basic_competency')}}</td>
                                    <td>:</td>
                                    <td>
                                        <ul>
                                            @foreach($topic->basicCompetencies as $competency)
                                                <li>{{$competency->competency}}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endif
                            @if($topic->rpp_file != null)
                                <tr>
                                    <td>{{ __('label.rpp_file')}}</td>
                                    <td>:</td>
                                    <td>
                                        <a href="{{asset('storage/'.$topic->rpp_file)}}" class="link-icon"> RPP</a>
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                    <div class="card-topic card-tab-topic mb-5">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item"> <a class="nav-link @if(session('tasks') == null) active @endif" data-toggle="tab" href="#material" role="tab">{{ __('label.material')}}</a> </li>
                            <li class="nav-item"> <a class="nav-link {{ session('tasks') ?? '' }}" data-toggle="tab" href="#assignment" role="tab">{{ __('label.task')}} <span class="ml-2 badge badge-primary">{{$task_count}}</span></a> </li>
                        </ul>
                    </div>
                    <div class="card-topic card-tab-topic">
                        <div class="tab-content w-100">
                            <div class="tab-pane py-5  @if(session('tasks') == null) active show @endif" id="material" role="tabpanel">
                                @if(sizeof($materials) == 0)
                                    <p class="text-secondary text-center">{{ __('label.no_data')}} <i class="fas fa-folder-open ml-2"></i></p>
                                @else
                                    @foreach($materials as $material)
                                    <div class="sub-topic-material">
                                        <div class="material-icon-wrapper">
                                            <a href="{{($material->file_path != null) ? asset('storage/'.$material->file_path) : '#' }}" class="material-icon link-icon"></a>
                                        </div>
                                        <div class="material-content">
                                            <a class="material-link" href="{{($material->file_path != null) ? asset('storage/'.$material->file_path) : '#' }}">
                                                {{$material->name}}
                                            </a>
                                            <div>
                                                {!! $material->content !!}
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="tab-pane py-5 {{ session('tasks') ?? '' }}" id="assignment" role="tabpanel">
                                @include('frontpage.task.learning-topic-tab-content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
@endsection

@push('after-scripts')
<script>
    /* Get the documentElement (<html>) to display the page in fullscreen */
    var elem = document.getElementById('contentWrapper');
    
    /* View in fullscreen */
    function openFullscreen() {
      if (elem.requestFullscreen) {
        elem.requestFullscreen();
      } else if (elem.mozRequestFullScreen) { /* Firefox */
        elem.mozRequestFullScreen();
      } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari and Opera */
        elem.webkitRequestFullscreen();
      } else if (elem.msRequestFullscreen) { /* IE/Edge */
        elem.msRequestFullscreen();
      }

      $("#fullscreenSection").hide();
      $("#escFullscreenSection").show();
    }
    
    /* Close fullscreen */
    function closeFullscreen() {
      if (document.exitFullscreen) {
        document.exitFullscreen();
      } else if (document.mozCancelFullScreen) { /* Firefox */
        document.mozCancelFullScreen();
      } else if (document.webkitExitFullscreen) { /* Chrome, Safari and Opera */
        document.webkitExitFullscreen();
      } else if (document.msExitFullscreen) { /* IE/Edge */
        document.msExitFullscreen();
      }

      $("#escFullscreenSection").hide();
      $("#fullscreenSection").show();
    }

    $(document).ready(function(){
        // Trim last char
        let grades = $('.trimmed-last').text()
        let trimmed_grades = grades.substring(0, grades.length-2)

        $('.trimmed-last').text(trimmed_grades)
    })

</script>
@endpush