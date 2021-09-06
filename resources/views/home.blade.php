@extends('layouts.home-template')

@section('title')
{{ __('menu-label.home')}}
@endsection

@section('before-styles')
{{-- Full Calendar --}}
<link rel="stylesheet" href="{{asset('css/fullcalendar.min.css')}}">
@endsection

@section('content')
<div id="main" style="position:relative;">
    <div id="showcase-wrapper">
      <div id="showcase">
        <div class="container">
          <div class="showcase-text">
            <h3 class="font-weight-bold">{{config('app.name')}}</h3>
            <h3>SMP N 6 Semarang</h3>
            <h1>Learn effectively on any schedule</span></h1>
            <p>{{ __('label.motto')}}</p>
            <a href="{{\LaravelLocalization::localizeURL('topics')}}" class="btn btn-lg btn-pastel-orange btn-rounded text-light"><i class="fas fa-search"></i> {{ __('button-label.browse_topics')}}</a>
          </div>
          <img class="showcase-img img-fluid" src="{{ asset('img/showcase.png') }}" alt="SMP N 6 Semarang">
        </div>
      </div>
    </div>

    <div id="course" class="content">
      <div class="container">
        <div class="title-wrapper mb-5">
          <div>
            <h3><i class="fa fa-layer-group mr-2"></i> {{ __('label.material')}}</h3>
          </div>
          <form action="" class="form-inline">
            <div class="form-group">
              <button class="btn btn-round-search"><i class="fas fa-search"></i></button>
              <input id="topicSearchInput" class="form-control form-round-search" type="search" placeholder="{{ __('label.search_topic') }}" name="topic_name" aria-label="search">
            </div>
          </form>
        </div>
        <h3 id="searchTitle"></h3>
        <div id="topicItemWrapper">
          @include('frontpage.learning-topic.content')
        </div>
        <div id="loadMoreWrapper" class="text-center mt-5">
          <a href="{{\LaravelLocalization::localizeURL('topics')}}" class="btn btn-lg btn-primary btn-show-more"><i class="fas fa-circle-notch mr-2"></i> {{ __('button-label.show_more') }}</a>
        </div>
      </div>
    </div>

    <section id="announcement-section">
      <div class="card dashboard-card-six">
          <div class="card-body p-5">
              <div class="row">
                <div class="col-lg-6">
                  <div class="heading-layout1 mb-5">
                    <div class="item-title">
                        <h3>{{ __('section-title.calendar')}}</h3>
                    </div>
                  </div>
                  <div class="calender-wrap">
                    <div id="fc-calender" class="fc-calender"></div>
                  </div>
                </div>
                <div class="col-lg-6 notice-box-wrap">
                  <div class="heading-layout1 mb-5">
                    <div class="item-title">
                        <h3>{{ __('section-title.announcement_list')}} <span id="selectedDate" class="badge badge-pill badge-success">{{ __('label.today') }}</span></h3>
                        <small><i>{{ __('messages.click_date_to_show_agenda') }}</i></small>
                    </div>
                  </div>
                  <div class="announcement-wrapper">
                    @include('frontpage.announcement.list')
                  </div>
                </div>
              </div>
          </div>
      </div>
      <div id="announcementModalWrapper">
      </div>
    </section>

</div>
@endsection

@push('scripts')
<!-- Moment Js -->
<script src="{{asset('js/moment.min.js')}}"></script>
{{-- Full Calendar Js --}}
<script src="{{ asset('js/fullcalendar.min.js') }}"></script>
<script>
  $(document).ready(function(){

    const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    let timeout;
    let searchTxt;
    let searchTitle = "{!! __('label.search_result_for') !!}"

    $("#topicSearchInput").on("keyup", function(){

      window.clearTimeout(timeout);

      timeout = window.setTimeout(() => {

        searchTxt = $(this).val();

        $.ajax({
          headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN
            },
            url: `{!! \LaravelLocalization::localizeURL('/topics/search') !!}`,
            type: 'get',
            dataType: 'json',
            data: {
              topic_name: searchTxt,
            },
            beforeSend: function(){
                $("#topicItemWrapper").html("<p class='text-center'>Loading...</p>");
                $("#loadMoreWrapper").css("display","none");
            },
            success: function(response){

                if(searchTxt != "") {
                  $("#searchTitle").text(`${searchTitle} "${searchTxt}"`);
                }
                else {
                  $("#searchTitle").text("");
                  $("#loadMoreWrapper").css("display","block");
                }

                $("#topicItemWrapper").html(response.responseText)
            },
            error: function(response){

                if(searchTxt != ""){
                  $("#searchTitle").text(`${searchTitle} "${searchTxt}"`);
                }
                else {
                  $("#searchTitle").text("");
                  $("#loadMoreWrapper").css("display","block");
                }

                $("#topicItemWrapper").html(response.responseText)
            },
        });
      }, 500);

    });

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
      }

  });
</script>
@endpush()