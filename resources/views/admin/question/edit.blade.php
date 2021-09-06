@extends('layouts.master')

@section('title')
    {{ __('section-title.question_edit') }}
@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop

@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>{{ __('section-title.question_edit') }}</strong></h2>
            </div>
            <div class="body">
                <form action="{{\LaravelLocalization::localizeURL('admin/questions/'.$question->id)}}" method="POST">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <label>{{ __('label.question_name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{$question->title}}">
                        @error('title')
                        <div class="form-group">
                            <span class="text-danger" role="alert">
                                {{$message}}
                            </span>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="question">{{ __('label.question') }}</label>
                        <textarea name="question" id="editor" class="form-control" rows="10">{!! $question->question !!}</textarea>
                        @error('question')
                        <div class="form-group">
                            <span class="text-danger" role="alert">
                                {{$message}}
                            </span>
                        </div>
                        @enderror
                    </div>
                    @if($question->question_type_id == 1)
                    <ol id="answerChoiceWrapper">
                        <p class="font-weight-bold">{{ __('label.answer_option') }}</p>
                        @foreach($answer_choices as $answer_choice)
                        <li class="answer-choice-item-wrapper">
                            <div class="row mt-3">
                                <div class="col-1 text-center">
                                    <input type="radio" name="is_answer" required value="{{$answer_choice->id}}" @if($answer_choice->is_answer == 1) checked @endif>
                                </div>
                                <div class="col-7">
                                    <input type="text" name="answers[]" class="form-control" style="height: 40px;" required value="{{$answer_choice->text}}">
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ol>
                    @endif
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.update') }}</button>
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