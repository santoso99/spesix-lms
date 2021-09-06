@extends('layouts.master')
@section('title')
    {{ __('menu-label.dashboard') }}
@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/fullcalendar/fullcalendar.min.css')}}" />
@stop

@section('content')
<div class="row clearfix">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="card project_list">
            <div class="header">
                <h2><strong><i class="zmdi zmdi-file-text"></i> {{ __('label.topic') }}</strong></h2>
            </div>
            <div class="table-responsive" style="overflow-x: unset;">
                <table class="table table-hover c_table theme-color">
                    <thead>
                        <tr>
                            <th>{{ __('label.name') }}</th>
                            <th class="no-sort text-right"><i class="zmdi zmdi-settings"></i> {{ __('label.action') }}</th>
                            <th>{{ __('label.subject') }}</th>
                            <th>{{ __('label.class') }}</th>
                            <th>{{ __('label.semester') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($topics)>0)
                            @foreach($topics as $topic)
                                <tr>
                                    <td><a href="{{\LaravelLocalization::localizeURL('admin/topics/'.$topic->id)}}">{{$topic->name}}</a></td>
                                    <td class="header">
                                        <ul class="header-dropdown">
                                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                                <ul class="dropdown-menu dropdown-menu-left slideUp">
                                                @hasrole('Admin|Supervisor')
                                                    <li>
                                                        <a target="_blank" href="{{\LaravelLocalization::localizeURL('topics/'.$topic->id)}}">
                                                            <i class="zmdi zmdi-eye action-icon"></i>{{ __('label.show') }}
                                                        </a>
                                                    </li>
                                                @endhasrole
                                                @hasrole('Pengajar')
                                                    <li>
                                                        <a target="_blank" href="{{\LaravelLocalization::localizeURL('admin/topics/'.$topic->id)}}">
                                                            <i class="zmdi zmdi-eye action-icon"></i>{{ __('label.show') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a target="_blank" href="{{\LaravelLocalization::localizeURL('admin/topics/'.$topic->id.'/edit')}}">
                                                            <i class="zmdi zmdi-edit action-icon"></i>{{ __('label.edit') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a target="_blank" href="{{route('topics.materials',$topic->id)}}">
                                                            <i class="zmdi zmdi-format-list-bulleted action-icon"></i>{{ __('label.learning_material') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a target="_blank" href="{{\LaravelLocalization::localizeURL('admin/topics/'.$topic->id.'/tasks')}}">
                                                            <i class="zmdi zmdi-assignment-check action-icon"></i>{{ __('label.task') }}
                                                        </a>
                                                    </li>
                                                @endhasrole
                                                @hasanyrole('Admin|Supervisor|Pengajar')
                                                    <li>
                                                        <a target="_blank" href="{{\LaravelLocalization::localizeURL('admin/topics/'.$topic->id.'/visitors')}}">
                                                            <i class="zmdi zmdi-accounts action-icon"></i>{{ __('label.visitor') }}
                                                        </a>
                                                    </li>
                                                @endhasanyrole
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{$topic->subject->name}}</td>
                                    <td class="trimmed-last">
                                        @foreach($topic->grades as $grade)
                                            {{$grade->name.' - '}}
                                        @endforeach
                                    </td>
                                    <td>{{$topic->semester}}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">{{ __('label.no_data') }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
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
                                <a class="btn btn-info btn-block waves-effect" href="{{\LaravelLocalization::localizeURL('admin/announcements/create')}}">{{ __('section-title.announcement_add') }}</a>
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