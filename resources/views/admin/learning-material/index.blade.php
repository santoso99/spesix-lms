@extends('layouts.master')

@section('title')
    {{ __('section-title.learning_materials')}}
@endsection

@section('page-style')
<!-- Fontawesome CSS -->
<link rel="stylesheet" href="{{asset('css/all.min.css')}}">
<link rel="stylesheet" href="{{asset('css/custom-icon-style.css')}}">
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
                <h2><strong>{{ __('label.learning_material') }}</strong></h2>
            </div>
            <div class="body">
                <div>
                    @if(sizeof($materials) == 0)
                    <div id="emptyMaterialWrapper" class="text-center">
                        <p class="text-secondary"><i class="zmdi zmdi-layers-off mr-2"></i>{{ __('label.no_learning_material')}}</p>
                    </div>
                    @else
                        @foreach($materials as $learning_material)
                        <div class="sub-topic-material">
                            <div class="material-icon-wrapper">
                                <a href="{{($learning_material->file_path != null) ? asset('storage/'.$learning_material->file_path) : '#' }}" class="material-icon link-icon"></a>
                            </div>
                            <div class="material-content">
                                <a href="{{($learning_material->file_path != null) ? asset('storage/'.$learning_material->file_path) : '#' }}">{{$learning_material->name}}</a>
                                <div>
                                    {!! $learning_material->content !!}
                                </div>
                            </div>
                            <div class="material-action">
                                <a href="{{route('materials.edit',$learning_material->id)}}" class="text-primary mr-1" title="{{ __('button-label.edit_learning_material')}}"><i class="zmdi zmdi-edit link-action-icon"></i></a>
                                <form action="{{route('materials.destroy',$learning_material->id)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-link text-warning p-0 mt-0 mx-2" title="{{ __('button-label.delete_learning_material')}}"><i class="zmdi zmdi-delete link-action-icon"></i></button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>{{ __('section-title.learning_material_add')}}</strong></h2>
            </div>
            <div class="body">
                <form  enctype="multipart/form-data" method="POST" action="{{route('materials.store')}}">
                    @csrf
                    <input type="hidden" name="learning_topic_id" value="{{$topic->id}}">
                    <div class="row flex-column">
                        @include('admin.learning-material.form')
                        <div class="col-12 form-group mg-t-8 text-right">
                            <button type="submit" id="btnSubmit" class="btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.save')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.11/tinymce.min.js"></script>
<script src="{{asset('js/custom/tinymce-init.js')}}"></script>
@stop