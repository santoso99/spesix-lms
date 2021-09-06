@extends('layouts.master')

@section('title')
    {{ __('section-title.learning_topic_data') }}
@endsection
@push('after-styles')
    <link rel="stylesheet" href="{{asset('css/custom-icon-style.css')}}">
@endpush
@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <div>
                    <h2><strong><i class="zmdi zmdi-file-text"></i> {{ __('section-title.learning_topic_data') }}</strong></h2>
                        <div id="breadcumbWrapper">
                            {{-- <a href="#" id="schoolYearLink">Tahun Ajaran 2019/2020</a>
                            <span class="">/ <a href="#" id="gradeSemesterLink">X - Semester 1</a></span>
                            <span class="">/ <a href="#" id="gradeLink">XB</a></span>
                            <span class="">/ <a href="#" id="subjectLink">Biologi</a></span> --}}
                            <span class="school-year-breadcumb"></span>
                            <span class="grade-semester-breadcumb"></span>
                            <span class="grade-breadcumb"></span>
                            <span class="subject-breadcumb"></span>
                        </div>
                </div>
                <ul class="header-dropdown">
                    <li>
                        <button href="#" class="btn btn-link link-back hide"><i class="zmdi zmdi-arrow-left"></i> {{ __('label.back') }}</button>
                    </li>
                </ul>
            </div>
            <div class="body">
                @if(count($school_years) == 0)
                    <h4 class="text-secondary text-center">{{ __('label.no_data')}} <i class="zmdi zmdi-block ml-2"></i></h4>
                @else
                    <div id="folderWrapper" class="row" data-view-order="1">
                        <div id="loadingLayer"></div>
                        @for($i=0;$i<count($school_years);$i++)
                        <div class="col-md-3 col-sm-12 mb-5">
                            <a href="#" class="folder-link school-year-folder" data-school-year="{{$school_years[$i]}}">
                                <div class="d-flex text-center flex-column">
                                    <i class="zmdi zmdi-folder folder-icon"></i>
                                    <span class="folder-name">{{ __('label.school_year') }} {{$school_years[$i]}}</span>
                                </div>
                            </a>
                        </div>
                        @endfor
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@push('after-scripts')
<script>
    $(document).ready(function(){
        let school_year, grade_level, semester, grade_id, prev_folder_view_2, prev_folder_view_3, prev_folder_view_4, folder_name, breadcumb;
        let loadingLayer = $('#loadingLayer')
        loadingLayer.hide()
        let prev_folder_view_1 = $("#folderWrapper").html()

        $(document).on('click','.link-back',function(e){
            e.preventDefault()
            view_order = $('#folderWrapper').data('view-order')

            switch (view_order) {
                case 2:
                    prev_folder_view = prev_folder_view_1
                    $('#folderWrapper').data('view-order',1)
                    $('.school-year-breadcumb').text("")
                    break;
                case 3:
                    prev_folder_view = prev_folder_view_2
                    $('#folderWrapper').data('view-order',2)
                    $('.grade-semester-breadcumb').text("")
                    break;
                case 4:
                    prev_folder_view = prev_folder_view_3
                    $('#folderWrapper').data('view-order',3)
                    $('.grade-breadcumb').text("")
                    break;
                case 5:
                    prev_folder_view = prev_folder_view_4
                    $('#folderWrapper').data('view-order',4)
                    $('.subject-breadcumb').text("")
                    break;
            }

            $('#folderWrapper').html(prev_folder_view)
            
            view_order = $('#folderWrapper').data('view-order')
            if(view_order == '1')
            {
                $('.link-back').hide()
            }
        })

        $(document).on('click','.school-year-folder',function(e){
            e.preventDefault()
            school_year = $(this).data("school-year")
            link = $(this)
            folder_name = link.find('.folder-name').text()
            $('#folderWrapper').data('view-order',2)

            $.ajax({
                url: "{!! \LaravelLocalization::localizeURL('/admin/topics/grade-semester-label') !!}",
                type: 'get',
                data: {
                    school_year: school_year,
                },
                beforeSend: function(){
                    $('#folderWrapper').prepend(loadingLayer)
                    loadingLayer.show()
                },
                success: function(response){
                    $("#folderWrapper").html(response['content'])
                    prev_folder_view_2 = $("#folderWrapper").html()
                    $('.school-year-breadcumb').text(folder_name)
                    $('.link-back').show()
                },
                error: function(){},
            })
        })

        $(document).on('click','.grade-semester-folder',function(e){
            e.preventDefault()
            school_year = $(this).data("school-year")
            grade_level = $(this).data("grade-level")
            semester = $(this).data("semester")
            link = $(this)
            folder_name = link.find('.folder-name').text()
            $('#folderWrapper').data('view-order',3)

            $.ajax({
                url: "{!! \LaravelLocalization::localizeURL('/admin/topics/grade-label') !!}",
                type: 'get',
                data: {
                    school_year: school_year,
                    grade_level: grade_level,
                    semester: semester,
                },
                beforeSend: function(){
                    $('#folderWrapper').prepend(loadingLayer)
                    loadingLayer.show()
                },
                success: function(response){
                    $("#folderWrapper").html(response['content'])
                    prev_folder_view_3 = $("#folderWrapper").html()
                    $('.grade-semester-breadcumb').text(' / '+folder_name)
                    // $('.link-back').show()
                },
                error: function(){},
            })
        })

        $(document).on('click','.grade-folder',function(e){
            e.preventDefault()
            prev_folder_view = $('#folderWrapper').html()
            school_year = $(this).data("school-year")
            grade_id = $(this).data("label-id")
            semester = $(this).data("semester")
            link = $(this)
            folder_name = link.find('.folder-name').text()
            $('#folderWrapper').data('view-order',4)

            $.ajax({
                url: "{!! \LaravelLocalization::localizeURL('/admin/topics/subject-label') !!}",
                type: 'get',
                data: {
                    school_year: school_year,
                    grade_id: grade_id,
                    semester: semester,
                },
                beforeSend: function(){
                    $('#folderWrapper').prepend(loadingLayer)
                    loadingLayer.show()
                },
                success: function(response){
                    $("#folderWrapper").html(response['content'])
                    prev_folder_view_4 = $("#folderWrapper").html()
                    $('.grade-breadcumb').text(' / '+folder_name)
                },
                error: function(response){},
            })
        })

        $(document).on('click','.subject-folder',function(e){
            e.preventDefault()
            school_year = $(this).data("school-year")
            grade_id = $(this).data("grade-id")
            semester = $(this).data("semester")
            let subject_id = $(this).data("label-id")
            link = $(this)
            folder_name = link.find('.folder-name').text()
            $('#folderWrapper').data('view-order',5)

            $.ajax({
                url: "{!! \LaravelLocalization::localizeURL('/admin/topics/specified') !!}",
                type: 'get',
                data: {
                    school_year: school_year,
                    grade_id: grade_id,
                    semester: semester,
                    subject_id: subject_id,
                },
                beforeSend: function(){
                    $('#folderWrapper').css('min-height','250px')
                    $('#folderWrapper').prepend(loadingLayer)
                    loadingLayer.show()
                },
                success: function(response){
                    $("#folderWrapper").html(response['content'])
                    prev_folder_view_5 = $("#folderWrapper").html()
                    $('.subject-breadcumb').text(' / '+folder_name)
                },
                error: function(response){},
            })
        })

    });
</script>
@endpush