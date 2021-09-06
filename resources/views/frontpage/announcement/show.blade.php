@extends('layouts.home-template')

@section('title')
    {{$announcement->title}}
@endsection

@section('before-styles')
{{-- Full Calendar --}}
<link rel="stylesheet" href="{{asset('css/fullcalendar.min.css')}}">
@endsection

@section('content')
<div id="main" class="content">
    <div class="container">
        <div id="announcementWrapper" class="row dashboard-card-six">
            <div class="col-lg-4 col-sm-12 card-body">
                <div class="calender-wrap pb-5 mb-5" style="border-bottom: 1px solid #ccc;">
                    <div id="fc-calender" class="fc-calender"></div>
                </div>
                <h3 class="mb-0">{{ __('section-title.announcement_list')}} <span id="selectedDate" class="badge badge-pill badge-success">{{ __('label.today') }}</span></h3>
                <small><i>{{ __('messages.click_date_to_show_agenda') }}</i></small>
                <div class="notice-box-wrap mt-5">
                    <div class="announcement-wrapper">
                        @include('frontpage.announcement.list')
                    </div>
                </div>
            </div>
            <div id="announcementContent" class="col-lg-8 col-sm-12">
                @include('frontpage.announcement.single')
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Moment Js -->
<script src="{{asset('js/moment.min.js')}}"></script>
{{-- Full Calendar Js --}}
<script src="{{ asset('js/fullcalendar.min.js') }}"></script>
<script>
  $(document).ready(function(){
    /*-------------------------------------
        Calender initiate 
    -------------------------------------*/
    if ($.fn.fullCalendar !== undefined) {
      $('#fc-calender').fullCalendar({
        header: {
          center: 'basicDay,basicWeek,month',
          left: 'title',
          right: 'prev,next',
        },
        fixedWeekCount: true,
        navLinks: false, // can click day/week names to navigate views
        editable: false,
        eventLimit: false, // allow "more" link when too many events
        aspectRatio: 1.8,
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
    }

  });
</script>
@endpush