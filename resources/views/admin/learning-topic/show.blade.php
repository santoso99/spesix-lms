@extends('layouts.master')

@section('title')
    {{ __('section-title.learning_topic_show') }}
@endsection

@section('page-style')
<!-- Fontawesome CSS -->
<link rel="stylesheet" href="{{asset('css/all.min.css')}}">
<link rel="stylesheet" href="{{asset('css/custom-icon-style.css')}}">
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>{{ __('label.detail') }}</strong></h2>
                <ul class="header-dropdown">
                    <li>
                        <a role="button" class="btn bg-purple" href="{{\LaravelLocalization::localizeURL('admin/topics/'.$topic->id.'/edit')}}"><i class="zmdi zmdi-edit text-light mr-1"></i> {{ __('section-title.learning_topic_edit') }}</a>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <td style="width: 25%;"><i class="zmdi zmdi-format-color-text mr-2"></i> {{ __('label.name') }}</td>
                            <td style="width: 5%;">:</td>
                            <td style="width: 70%;"><b>{{$topic->name}}</b></td>
                        </tr>
                        <tr>
                            <td><i class="zmdi zmdi-collection-bookmark mr-2"></i> {{ __('label.subject') }}</td>
                            <td>:</td>
                            <td><b>{{$topic->subject->name}}</b></td>
                        </tr>
                        <tr>
                            <td><i class="zmdi zmdi-badge-check mr-2"></i> {{ __('label.class') }}</td>
                            <td>:</td>
                            <td><b>{{ $topic->grade_level }}</b></td>
                        </tr>
                        <tr>
                            <td><i class="zmdi zmdi-calendar mr-2"></i> {{ __('label.semester') }}</td>
                            <td>:</td>
                            <td><b>{{ $topic->semester}}</b></td>
                        </tr>
                        <tr>
                            <td><i class="zmdi zmdi-collection-text mr-2"></i> {{ __('label.basic_competency') }}</td>
                            <td>:</td>
                            <td>{!! $topic->basic_competency !!}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>{{ __('label.learning_material') }}</strong></h2>
            </div>
            <div class="body">
                @if(sizeof($materials) == 0)
                <div id="emptyMaterialWrapper" class="text-center">
                    <p class="text-secondary"><i class="zmdi zmdi-layers-off mr-2"></i>{{ __('label.no_learning_material')}}</p>
                </div>
                @else
                    @foreach($materials as $material)
                        <div class="sub-topic-material">
                            <div class="material-icon-wrapper">
                                <a href="{{($material->file_path != null) ? asset('storage/'.$material->file_path) : '#' }}" class="material-icon link-icon"></a>
                            </div>
                            <div class="material-content">
                                <a href="{{($material->file_path != null) ? asset('storage/'.$material->file_path) : '#' }}">{{$material->name}}</a>
                                <div>
                                    {!! $material->content !!}
                                </div>
                            </div>
                        </div> 
                    @endforeach
                @endif
                <div class="text-center">
                    <a class="btn btn-success" href="{{ route('topics.materials', $topic->id) }}"><i class="zmdi zmdi-menu mr-2"></i> {{ __('label.manage') }} {{ __('label.learning_material') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection