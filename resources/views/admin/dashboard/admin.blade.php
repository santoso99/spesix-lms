@extends('layouts.master')
@section('title')
    {{ __('menu-label.dashboard') }}
@endsection

@section('page-style')
<!-- Fontawesome CSS -->
<link rel="stylesheet" href="{{asset('css/all.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/fullcalendar/fullcalendar.min.css')}}" />
@stop

@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card mb-0">
            <div class="header">
                <h2><strong><i class="zmdi zmdi-chart"></i> Statistics</strong></h2>
            </div>
            <div class="mb-2">
                <div class="row clearfix">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card w_data_1">
                            <div class="body">
                                <div class="w_icon cyan"><i class="zmdi zmdi-accounts"></i></div>
                                <h4 class="mt-3">{{ $student_count }}</h4>
                                <span class="text-muted">{{ __('label.student') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card w_data_1">
                            <div class="body">
                                <div class="w_icon pink"><i class="zmdi zmdi-account-box"></i></div>
                                <h4 class="mt-3">{{ $teacher_count }}</h4>
                                <span class="text-muted">{{ __('label.teacher') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card w_data_1">
                            <div class="body">
                                <div class="w_icon orange"><i class="zmdi zmdi-collection-bookmark"></i></div>
                                <h4 class="mt-3">{{ $subject_count }}</h4>
                                <span class="text-muted">{{ __('label.subject') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card w_data_1">
                            <div class="body">
                                <div class="w_icon green"><i class="zmdi zmdi-file-text"></i></div>
                                <h4 class="mt-3">{{ $topic_count }}</h4>
                                <span class="text-muted">{{ __('label.topic') }}</span>
                            </div>
                        </div>
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
                <h2><strong><i class="zmdi zmdi-calendar-note"></i> Event</strong> Calendar</h2>
            </div>
            <div class="body mb-2">
                <div class="row clearfix">
                    <div class="col-md-12 col-lg-8 col-xl-8">
                        <div class="card">
                            <div class="body">                            
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4 col-xl-4">
                        <div class="card">
                            <div class="event_list">
                                @hasrole('Admin')
                                <a class="btn btn-info btn-block waves-effect" href="{{\LaravelLocalization::localizeURL('admin/announcements/create')}}">{{ __('section-title.announcement_add') }}</a>
                                @endhasrole
                                <div class="py-3" style="border-bottom: 1px solid #ccc;">
                                    <p class="font-weight-bold mb-0">{{ __('section-title.announcement_list')}} <span id="selectedDate" class="badge badge-pill badge-success">{{ __('label.today') }}</span></p>
                                    <small><i>{{ __('messages.click_date_to_show_agenda') }}</i></small>
                                </div>
                                <div class="announcement-wrapper mt-3">
                                    @include('frontpage.announcement.list')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="announcementModalWrapper">
    </div>
</div>

@stop

@push('after-scripts')
<script src="{{asset('assets/bundles/fullcalendarscripts.bundle.js')}}"></script>
<script>
    $(document).ready(function(){

        let today = new Date();
        let dd = today.getDate();
        let mm = today.getMonth()+1; //January is 0!
        let yyyy = today.getFullYear();

        if(dd<10) { dd = '0'+dd }

        if(mm<10) { mm = '0'+mm } 

        let current = yyyy + '-' + mm + '-';

        let calendar = $('#calendar');

        calendar.fullCalendar({

            header: {

                left: 'title',

                center: '',

                right: 'month, agendaWeek, agendaDay, prev, next'

            },

            editable: false,

            droppable: false,

            eventLimit: false, // allow "more" link when too many events

            selectable: false,

            events: {!! json_encode($calendar_data) !!}
        });

        $(document).on("click", "td.fc-day-top",function(){

            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            const selected_date = $(this).data("date");

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                url: `{!! \LaravelLocalization::localizeURL('/announcements/date') !!}`,
                type: 'get',
                dataType: 'json',
                data: {
                    date: selected_date,
                },
                beforeSend: function(){
                    $(".announcement-wrapper").html("<p class='text-center'>Loading...</p>");
                },
                success: function(response){
                    $(".announcement-wrapper").html(response.content);
                    $("#selectedDate").text(response.selected_date);
                },
                error: function(response){
                    $(".announcement-wrapper").html(response.content);
                    $("#selectedDate").text(response.selected_date);
                },
            });

        });

        $(document).on("click", ".announcement-title",function(e){
            e.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            const announcement_id = $(this).data("id");

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                url: `{!! \LaravelLocalization::localizeURL('/announcements') !!}/${announcement_id}`,
                type: 'get',
                dataType: 'json',
                success: function(response){
                    $("#announcementModalWrapper").html(response.content);
                    $('#announcementDetailModal').modal('show');
                },
                error: function(response){
                    $("#announcementModalWrapper").html(response.content);
                    $('#announcementDetailModal').modal('show');
                },
            });

        });
    });
</script>
@endpush