@extends('layouts.master')

@section('title')
    {{ __('section-title.learning_step_add')}}
@endsection

@section('content')
<div class="row clearfix">
    <div class="alert alert-success alert-dismissible show fade" style="display:none" role="alert">
        {!! session('status') ?? null !!}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="alert alert-danger alert-dismissible show fade" style="display:none" role="alert">
        
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>{{$topic->name}}</strong></h2>
                <ul class="header-dropdown">
                    <li>
                        <a role="button" href="{{\LaravelLocalization::localizeURL('admin/topics/'.$topic->id.'/steps')}}"><i class="zmdi zmdi-arrow-left"></i> {{ __('section-title.learning_step_data')}}</a>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="sub-topic-title">
                    <h4 id="stepTitle">{{ __('label.learning_step')}}</h4>
                </div>
                <form class="learning-step-title-edit-form">
                    @csrf
                    <input type="hidden" name="learning_topic_id" value="{{$topic->id}}">
                    <span>{{ __('label.title') }}</span>
                    <div class="row">
                        <div class="col-lg-10 col-12 form-group">
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" placeholder="ex. Pendahuluan / Kegiatan Belajar 1 dsb" required>
                            @error('title')
                            <div class="form-group">
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            </div>
                            @enderror
                        </div>
                        <div class="col-lg-2 col-12 form-group">
                            <button type="submit" id="btnStepSave" class="btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.save')}}</button>
                            <button type="submit" id="btnStepUpdate" class="btn btn-primary btn-raised btn-round waves-effect hide">{{ __('button-label.update')}}</button>
                        </div>
                        <div class="col-12">
                            <span><i><span class="text-danger">*</span> {{ __('messages.learning_step_input_notice') }}</i></span>
                        </div>
                    </div>
                </form>
                <div>
                    <div id="emptyMaterialWrapper" class="text-center">
                        <h3>{{ __('label.no_learning_material')}}</h3>
                    </div>
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
                <form enctype="multipart/form-data" method="POST" action="{{route('materials.store')}}">
                    @csrf
                    <input type="hidden" id="stepId" name="learning_phase_id" value="{{ old('learning_phase_id') ?? null }}">
                    <div class="row flex-column">
                        @include('admin.learning-material.form')
                        <div class="col-12 form-group text-right">
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
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')

        $('#btnStepSave').on('click',function(e){
            e.preventDefault()
            let title = $('input[name="title"]').val()
            let learning_topic_id = $('input[name="learning_topic_id"]').val()

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                url: '{!! route("steps.store") !!}',
                type: 'post',
                dataType: 'json',
                data: {
                    title: title,
                    learning_topic_id: learning_topic_id,
                },
                beforeSend: function(){
                    $("#btnStepSave").prop("disabled",true)
                    $("#btnStepSave").html("Loading...")
                },
                success: function(response){
                    $('#stepTitle').text(title)
                    $('.alert-danger').slideUp(500)
                    $('.alert-success').slideDown(500)
                    $('.alert-success').text(response['message'])
                    $('#stepId').val(response['step_id'])
                    $("#btnStepSave").prop("disabled",false)
                    $("#btnStepSave").html("{!! __('button-label.save') !!}")
                    $("#btnStepSave").addClass('hide')
                    $("#btnStepUpdate").removeClass('hide')
                },
                error: function(response){
                    $("#btnStepSave").prop("disabled",false)
                    $("#btnStepSave").html("{!! __('button-label.save') !!}")
                    $('.alert-success').slideUp(500)
                    $('.alert-danger').slideDown(500)
                    $('.alert-danger').text("{!! __('messages.learning_material_unsaved') !!}")
                    
                },
            })
        });

        $('#btnStepUpdate').on('click',function(e){
            e.preventDefault()
            let title = $('input[name="title"]').val()
            let step_id = $('#stepId').val()

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                url: '{!! \LaravelLocalization::localizeURL("/") !!}/admin/steps/'+step_id,
                type: 'patch',
                dataType: 'json',
                data: {
                    title: title,
                },
                beforeSend: function(){
                    $("#btnStepUpdate").prop("disabled",true)
                    $("#btnStepUpdate").html("Loading...")
                },
                success: function(response){
                    $('#stepTitle').text(title)
                    $('.alert-danger').slideUp(500)
                    $('.alert-success').slideDown(500)
                    $('.alert-success').text(response['message'])
                    $("#btnStepUpdate").prop("disabled",false)
                    $("#btnStepUpdate").html("{!! __('button-label.update') !!}")
                },
                error: function(response){
                    $("#btnStepUpdate").prop("disabled",false)
                    $("#btnStepUpdate").html("{!! __('button-label.update') !!}")
                    $('.alert-success').slideUp(500)
                    $('.alert-danger').slideDown(500)
                    $('.alert-danger').text("{!! __('messages.learning_material_unsaved') !!}")
                    
                },
            })
        });
    });
</script>
@stop