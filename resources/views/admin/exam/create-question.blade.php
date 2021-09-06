@extends('layouts.master')

@section('title')
    {{ __('section-title.question_create') }}
@endsection
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>{{ __('section-title.question_create') }}</strong></h2>
            </div>
            <div class="body">
                <form action="{{\LaravelLocalization::localizeURL('admin/exams/'.$exam->id.'/questions')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-3 col-12 form-group">
                            <label for="questionTypeSelect">{{ __('label.question_type') }} <span class="text-danger">*</span></label>
                            <select id="questionTypeSelect" class="form-control show-tick" name="question_type_id">
                                @foreach ($question_types as $question_type)
                                    <option value="{{$question_type->id}}">{{$question_type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="subject_id" value="{{$exam->subject_id}}">
                    </div>
                    <div class="form-group">
                        <label>{{ __('label.question_name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="title" placeholder="contoh: Soal perkalian aljabar" class="form-control" value="{{old('title') ?? null}}">
                        @error('title')
                        <div class="form-group">
                            <span class="text-danger" role="alert">
                                {{$message}}
                            </span>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="question">{{ __('label.question_text') }} <span class="text-danger">*</span></label>
                        <textarea name="question" id="question" class="form-control" rows="10">{{old('question') ?? null}}</textarea>
                        @error('question')
                        <div class="form-group">
                            <span class="text-danger" role="alert">
                                {{$message}}
                            </span>
                        </div>
                        @enderror
                    </div>
                    <ol id="answerChoiceWrapper" class="mt-3">
                        <p class="font-weight-bold">{{ __('label.answer_option') }}</p>
                        @for($i=1;$i<=5;$i++)
                        <li class="answer-choice-item-wrapper">
                            <div class="row mt-3">
                                <div class="col-1 text-center">
                                    <input type="radio" name="is_answer" value="{{$i}}">
                                </div>
                                <div class="col-7">
                                    <input type="text" name="answers[]" class="form-control" style="height: 40px;font-size:1.6rem">
                                </div>
                            </div>
                        </li>
                        @endfor
                    </ol>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function(){
        $("#questionTypeSelect").on("change", function(){
            let type = parseInt($(this).val());

            if(type == 2){
                $('#answerChoiceWrapper').hide();
            }
            else if(type == 1){
                $('#answerChoiceWrapper').show();
            }
        });
    });
</script>
@endpush