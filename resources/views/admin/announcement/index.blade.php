@extends('layouts.master')

@section('title')
    {{ __('section-title.announcement_data') }}
@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}">
@stop

@section('content')
<!-- Send Notification Modal -->
<div class="modal fade" id="sendAnnouncementNotificationModal" tabindex="-1" role="dialog" aria-labelledby="sendAnnouncementNotificationModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form>
            <div class="modal-header">
                <h5 class="modal-title" id="sendAnnouncementNotificationModalTitle">{{ __('label.notify')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body row">
                <div class="form-group col-12">
                    <label for="">{{ __('label.title')}} <span class="text-danger">*</span></label>
                    <input id="notifTitleInput" type="text" class="form-control" placeholder="{{ __('label.title')}}">
                </div>
                <div class="form-group col-12">
                    <label for="">{{ __('label.content')}} <span class="text-danger">*</span></label>
                    <textarea id="notifContentInput" type="text" class="form-control" rows="10" placeholder="{{ __('label.content')}}"></textarea>
                </div>
                <div class="form-group col-12">
                    <button id="btnBroadcastNotification" data-announcement-id="" type="submit" class="btn btn-primary btn-raised btn-round waves-effect float-right mt-3">{{ __('button-label.send')}}</button>
                </div>
            </div>
        </form>
    </div>
    </div>
</div>
<!-- All Announcements Area Start Here -->
<div class="row clearfix">
    <div class="col-lg-12">
        @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="card">
            <div class="header">
                <h2><strong><i class="zmdi zmdi-notifications"></i> {{ __('section-title.announcement_data') }}</strong></h2>
                <ul class="header-dropdown">
                    <li>
                        <a role="button" class="btn btn-success" href="{{\LaravelLocalization::localizeURL('admin/announcements/create')}}"><i class="zmdi zmdi-plus text-light"></i> {{ __('section-title.announcement_add') }}</a>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <form action="{{route('announcement.batch.delete')}}" method="POST">
                        @csrf
                        @method('delete')
                        <table class="table table-hover dataTable">
                            <thead>
                                <tr>
                                    <th class="no-sort">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input checkAll">
                                            <label class="form-check-label">{{ __('label.number') }}</label>
                                        </div>
                                    </th>
                                    <th>{{ __('label.title') }}</th>
                                    <th>{{ __('label.date') }}</th>
                                    <th>{{ __('label.time') }}</th>
                                    <th class="no-sort text-right"><i class="zmdi zmdi-settings"></i> {{ __('label.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($no=0)
                                @foreach($announcements as $announcement)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" name="announcement_id[]" value="{{$announcement->id}}" class="form-check-input">
                                                <label class="form-check-label">{{++$no}}</label>
                                            </div>
                                        </td>
                                        <td>{{$announcement->title}}</td>
                                        <td>{{$announcement->formatted_date}}</td>
                                        <td>{{$announcement->formatted_start_time}}</td>
                                        <td class="header">
                                            <ul class="header-dropdown">
                                                <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                                    <ul class="dropdown-menu dropdown-menu-right slideUp">
                                                        <li>
                                                            <a href="{{\LaravelLocalization::localizeURL('announcements/'.$announcement->id)}}">
                                                                <i class="zmdi zmdi-eye action-icon"></i>{{ __('label.show') }}
                                                            </a>
                                                        </li>
                                                    @hasrole('Admin')
                                                        <li>
                                                            <a href="{{\LaravelLocalization::localizeURL('admin/announcements/'.$announcement->id.'/edit')}}">
                                                                <i class="zmdi zmdi-edit action-icon"></i>{{ __('label.edit') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#" data-toggle="modal" data-target="#sendAnnouncementNotificationModal" data-announcement-id="{{$announcement->id}}" class="btn-send-notification" title="{{ __('label.notify')}}">
                                                                <i class="zmdi zmdi-notifications action-icon"></i>{{ __('label.notify') }}
                                                            </a>
                                                        </li>
                                                    @endhasrole
                                                    </ul>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @hasrole('Admin')
                        <div class="col-lg-3 col-12">
                            <button type="submit" class="btn btn-warning btn-raised waves-effect">{{ __('button-label.batch_delete') }}</button>
                        </div>
                        @endhasrole
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- All Announcements Area End Here -->
@endsection
@push('after-scripts')
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script>
    $('.dataTable').dataTable( {
            "columnDefs": [ {
            "targets": 'no-sort',
            "orderable": false,
        } ]
    } );

    /*-------------------------------------
        All Checkbox Checked
    -------------------------------------*/
    $(".checkAll").on("click", function () {
        $(this).parents('.table').find('input:checkbox').prop('checked', this.checked);
    });
</script>
<script>
    const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')

    $(".btn-send-notification").on("click", function(){
        let announcement_id = $(this).data("announcement-id")
        $("#btnBroadcastNotification").data("announcement-id", announcement_id)
    });

    $(document).on("click","#btnBroadcastNotification",function(e){

        e.preventDefault()
        let announcement_id = $(this).data("announcement-id")
        let notification_title = $("#notifTitleInput").val()
        let notification_content = $("#notifContentInput").val();

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": CSRF_TOKEN,
            },
            url: '{!! \LaravelLocalization::localizeURL("/") !!}/admin/announcements/'+announcement_id+'/notify',
            type: 'post',
            dataType: 'json',
            data: {
                notification_title: notification_title,
                notification_content: notification_content,
            },
            beforeSend: function(){
                $("#btnBroadcastNotification").prop("disabled",true)
                $("#btnBroadcastNotification").html("Loading...")
            },
            success: function(response){
                swal({
                    text: "{!! __('messages.send_notification_success') !!}",
                    icon: "success",
                });
                $("#btnBroadcastNotification").prop("disabled",false)
                $("#btnBroadcastNotification").html("{!! __('button-label.send') !!}")
            },
            error: function(response){
                swal({
                    text: "{!! __('messages.send_notification_failed') !!}",
                    icon: "error",
                });
                $("#btnBroadcastNotification").prop("disabled",false)
                $("#btnBroadcastNotification").html("{!! __('button-label.send') !!}")
            }
        })
    });
</script>
@endpush