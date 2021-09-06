@extends('layouts.master')

@section('title')
    {{ __('section-title.learning_step_edit')}}
@endsection

@section('page-style')
<!-- Fontawesome CSS -->
<link rel="stylesheet" href="{{asset('css/all.min.css')}}">
<link rel="stylesheet" href="{{asset('css/custom-icon-style.css')}}">
@endsection

@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="alert alert-success alert-dismissible show fade" style="display:none" role="alert">
                    
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="alert alert-danger alert-dismissible show fade" style="display:none" role="alert">
            
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="card">
            <div class="header">
                <h2><strong>{{$topic->name}}</strong></h2>
                <ul class="header-dropdown">
                    <a role="button" href="{{\LaravelLocalization::localizeURL('admin/topics/'.$topic->id.'/steps')}}"><i class="zmdi zmdi-arrow-left"></i> {{ __('section-title.learning_step_data')}}</a>
                </ul>
            </div>
            <div class="body">
                <div class="sub-topic-title">
                    <h4 id="stepTitle">{{$step->title}}</h4>
                </div>
                <form class="learning-step-title-edit-form">
                    @csrf
                    <span>{{ __('label.title')}}</span>
                    <div class="row">
                        <div class="col-lg-10 col-12 form-group">
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" placeholder="ex. Pendahuluan / Kegiatan Belajar 1 dsb" value="{{$step->title}}" required>
                            @error('title')
                            <div class="form-group">
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-2 col-12 form-group">
                            <button type="submit" id="btnStepUpdate" class="btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.update')}}</button>
                        </div>
                    </div>
                </form>
                <div>
                    @if(sizeof($materials) == 0)
                    <div id="emptyMaterialWrapper" class="text-center">
                        <h3 class="text-secondary">{{ __('label.no_learning_material')}}</h3>
                    </div>
                    @endif
                    @if(session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
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
                            <a href="{{route('materials.edit',$learning_material->id)}}" class="link-round bg-light-blue" title="{{ __('button-label.edit_learning_material')}}"><i class="zmdi zmdi-edit"></i></a>
                            <form action="{{route('materials.destroy',$learning_material->id)}}" method="post">
                                @csrf
                                @method('delete')
                                <button type="submit" class="link-round bg-warning" title="{{ __('button-label.delete_learning_material')}}"><i class="zmdi zmdi-delete text-light"></i></button>
                            </form>
                        </div>
                    </div>
                    @endforeach
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
                    <input type="hidden" name="learning_phase_id" value="{{$step->id}}">
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
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script src="{{asset('js/custom/tinymce-init.js')}}"></script>
<script>
    $(document).ready(function(){

        $('#btnStepUpdate').on('click',function(e){
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')
            let new_title = $('input[name="title"]').val()
            e.preventDefault()

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                url: '{!! route("steps.update",$step->id) !!}',
                type: 'patch',
                dataType: 'json',
                data: {
                    title: new_title,
                },
                beforeSend: function(){
                    $("#btnStepUpdate").prop("disabled",true)
                    $("#btnStepUpdate").html("Loading...")
                },
                success: function(response){
                    $('#stepTitle').text(new_title)
                    $('.alert-danger').slideUp(500)
                    $('.alert-success').slideDown(500)
                    $('.alert-success').text(response['message'])
                    $("#btnStepUpdate").prop("disabled",false)
                    $("#btnStepUpdate").html({{ __('button-label.update')}})
                },
                error: function(response){
                    $("#btnStepUpdate").prop("disabled",false)
                    $("#btnStepUpdate").html({{ __('button-label.update')}})
                    $('.alert-success').slideUp(500)
                    $('.alert-danger').slideDown(500)
                    $('.alert-danger').text({{ __('messages.learning_step_fail_update')}})
                    
                },
            })
        });
    });
</script>
@stop