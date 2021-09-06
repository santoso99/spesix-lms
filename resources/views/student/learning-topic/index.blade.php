@extends('layouts.master')

@section('title')
    {{ __('label.material') }}
@endsection
@section('page-style')
<!-- Fontawesome CSS -->
<link rel="stylesheet" href="{{asset('css/all.min.css')}}">
@stop
@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>{{ __('label.material') }}</strong></h2>
                <ul class="header-dropdown">
                    <li>
                        <form action="" class="form-inline">
                            <div class="form-group">
                              <button class="btn btn-round-search"><i class="fas fa-search"></i></button>
                              <input id="topicSearchInput" class="form-control form-round-search" type="search" placeholder="{{ __('label.search_topic') }}" name="topic_name" aria-label="search">
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
            <div class="body topic-list-wrapper py-1">
                <h3 id="searchTitle"></h3>
                @include('frontpage.learning-topic.content')
            </div>
            {{-- <div id="loadMoreWrapper" class="text-center">
                <a href="{{\LaravelLocalization::localizeURL('topics')}}" class="btn btn-sm btn-primary btn-show-more"><i class="fas fa-circle-notch mr-2"></i> {{ __('button-label.show_more') }}</a>
            </div> --}}
        </div>
    </div>
</div>
@endsection
@section('page-script')
<!-- Sweet Alert -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
</script>
@stop