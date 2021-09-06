@extends('layouts.master')

@section('title')
    {{ __('section-title.learning_step_edit')}}
@endsection

@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2>{{ __('label.topic') }}: <strong>{{$material->learningTopic->name}}</strong></h2>
            </div>
            <div class="body">
                <form enctype="multipart/form-data" method="POST" action="{{route('materials.update', $material->id)}}">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="learning_topic_id" value="{{$material->learningTopic->id}}">
                    <div class="row">
                        @include('admin.learning-material.form')
                        <div class="col-12 form-group text-right">
                            <button type="submit" id="btnSubmit" class="btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.update')}}</button>
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