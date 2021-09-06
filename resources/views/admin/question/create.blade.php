@extends('layouts.master')

@section('title')
    {{ __('section-title.question_add') }}
@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop

@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>{{ __('section-title.question_add') }}</strong></h2>
            </div>
            <div class="body">
                <form action="{{\LaravelLocalization::localizeURL('admin/questions')}}" method="POST">
                    @csrf
                    @include('admin.question.form')
                    <div class="form-group text-right mg-t-8">
                        <button type="submit" class="btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.save') }}</button>
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
<script>
    $(document).ready(function(){
        let answer_choice_list = $('#answerChoiceList');

        $("#questionTypeSelect").on("change", function(){
            let type = parseInt($(this).val());

            if(type == 2){
                $('#answerChoiceWrapper').empty();
            }
            else if(type == 1){
                $('#answerChoiceWrapper').append(answer_choice_list);
            }
        });
    });
</script>
@stop