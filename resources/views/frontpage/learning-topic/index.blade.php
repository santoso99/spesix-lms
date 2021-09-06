@extends('layouts.home-template')

@section('title')
{{ __('section-title.learning_topic_data')}}
@endsection

@section('before-styles')
<!-- Select 2 CSS -->
<link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
<!-- Treeview Gijgo CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/css/gijgo.min.css">
@endsection

@section('content')
<div id="main" class="content">
    <div class="container">
        <div class="row">
            <div id="course-side-nav" class="col-md-3 col-sm-12">
                <h4 class="font-weight-bold">{{ __('section-title.topic_index')}}</h4>
                @include('frontpage.topic-sidebar')
            </div>
            <div class="col-md-9 col-sm-12">
                <form action="{{\LaravelLocalization::localizeURL('topics/filter')}}" method="GET">
                    <div class="row mb-5">
                        <div class="col-md-6 col-sm-12 form-group">
                            <p><b>{{ __('label.subject')}}</b></p>
                            <select id="mapelSelectBox" name="subject_id" class="select2">
                                <option value="">{{ __('label.select')}}</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{$subject->id}}">{{$subject->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-12 form-group">
                            <p><b>{{ __('label.school_year')}}</b></p>
                            <select name="school_year" class="select2">
                                <option value="">{{ __('label.select')}}</option>
                                @if(isset($school_years))
                                    @for($i=0;$i<count($school_years);$i++)
                                        <option value="{{ $school_years[$i] }}">{{ $school_years[$i] }}</option>
                                    @endfor
                                @endif
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-12 form-group">
                            <p class="text-light d-none d-md-block">-</p>
                            <button type="submit" class="btn btn-lg btn-filter-topic"><i class="fas fa-filter mr-2"></i> Filter</button>
                        </div>
                    </div>
                </form>
                <h2 class="title">{{ __('section-title.learning_topic_data')}}{{ isset($subject_name) ? ' - '.$subject_name : null }}{{ isset($grade_level) ? ' - '.__('label.class').' '.$grade_level : null }}{{ isset($school_year) ? ' - '.__('label.school_year').' '.$school_year : null }}</h2>
                @include('frontpage.learning-topic.content')
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<!-- Select 2 Js -->
<script src="{{asset('js/select2.min.js')}}"></script>
<!-- Treeview Gijgo -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/js/gijgo.min.js"></script>
<!-- Sweet Alert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endpush

@push('after-scripts')
<script>
    $('.btn-add-collection').on('click', function(){
        
        let button_content = $(this).html()
        $(this).text('Loading...')
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')
        let topic_id = $(this).data('topic-id')
        let button = $(this)

        $.ajax({
            headers : {
                'X-CSRF-TOKEN' : CSRF_TOKEN
            },
            url: '{!! \LaravelLocalization::localizeURL("/my-topics") !!}',
            type: 'post',
            dataType: 'json',
            data: {
                topic_id: topic_id,
            },
            success: function(response){
                button.html(button_content)
                button.hide()
                button.siblings('.btn-remove-collection').show()
                swal({
                    text: response['message'],
                    icon: "success",
                });
            },
            error: function(response){
                swal({
                    text: "{!! __('messages.topic_fail_added') !!}",
                    icon: "error",
                });
            },
        });
    });

    $('.btn-remove-collection').on('click', function(){

        let button_content = $(this).html()
        $(this).text('Loading...')
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')
        let topic_id = $(this).data('topic-id')
        let button = $(this)

        $.ajax({
            headers : {
                'X-CSRF-TOKEN' : CSRF_TOKEN
            },
            url: '{!! \LaravelLocalization::localizeURL("/my-topics") !!}/'+topic_id,
            type: 'delete',
            dataType: 'json',
            success: function(response){
                button.html(button_content)
                button.hide()
                button.siblings('.btn-add-collection').show()
                swal({
                    text: response['message'],
                    icon: "success",
                });
            },
            error: function(response){
                swal({
                    text: "{!! __('messages.topic_fail_removed') !!}",
                    icon: "error",
                });
            },
        });
    });
</script>
@endpush