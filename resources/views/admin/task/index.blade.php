@extends('layouts.master')

@section('title')
    {{ __('section-title.task_data') }}
@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
@stop

@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="alert alert-success alert-dismissible show fade" @if(!session('status'))style="display:none"@endif role="alert">
            {{ session('status') ?? null }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="alert alert-danger alert-dismissible show fade" style="display:none" role="alert">
            
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="card">
            <div class="header">
                <h2><strong><i class="zmdi zmdi-assignment-check"></i> {{ __('section-title.task_data') }}</strong></h2>
                @hasrole('Pengajar')
                @php($topic_id = isset($topic) ? $topic->id : null)
                <ul class="header-dropdown">
                    <li>
                        <a role="button" class="btn btn-success" href="{{\LaravelLocalization::localizeURL('admin/tasks/create/'.$topic_id)}}"><i class="zmdi zmdi-plus text-light"></i> {{ __('section-title.task_add')}}</a>
                    </li>
                </ul>
                @endhasrole
            </div>
            <div class="body">
                <div class="table-responsive">
                    @hasrole('Pengajar')
                    <form action="{{\LaravelLocalization::localizeURL('admin/tasks')}}" method="POST">
                        @csrf
                        @method('delete')
                        @endhasrole
                        <table class="table table-hover dataTable c_table theme-color">
                            <thead>
                                <tr>
                                    <th class="no-sort">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input checkAll">
                                            <label class="form-check-label">-</label>
                                        </div>
                                    </th>
                                    <th>{{ __('label.name') }}</th>
                                    @unlessrole('Siswa')
                                    <th class="no-sort text-right"><i class="zmdi zmdi-settings"></i> {{ __('label.action') }}</th>
                                    @endunlessrole
                                    @hasrole('Pengajar')
                                    <th>{{ __('label.status') }}</th>
                                    @endhasrole
                                    <th>{{ __('label.deadline') }}</th>
                                    <th>{{ __('label.topic') }}</th>
                                    <th>{{ __('label.subject') }}</th>
                                    <th>{{ __('label.teacher') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" value="{{$task->id}}" name="task_id[]" class="form-check-input">
                                                <label class="form-check-label font-weight-bold"></label>
                                            </div>
                                        </td>
                                        <td><a href="{{\LaravelLocalization::localizeURL('admin/tasks/'.$task->id.'/submissions')}}">{{$task->name}}</a></td>
                                        @unlessrole('Siswa')
                                        <td class="header">
                                            <ul class="header-dropdown">
                                                <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                                    <ul class="dropdown-menu dropdown-menu-left slideUp">
                                                        @hasrole('Pengajar')
                                                        <li>
                                                            <a href="{{\LaravelLocalization::localizeURL('tasks/'.$task->id)}}"><i class="zmdi zmdi-eye action-icon"></i>{{ __('label.show') }}</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{\LaravelLocalization::localizeURL('admin/tasks/'.$task->id.'/edit')}}"><i class="zmdi zmdi-edit action-icon"></i>{{ __('label.edit') }}</a>
                                                        </li>
                                                        @endhasrole
                                                        <li>
                                                            <a href="{{\LaravelLocalization::localizeURL('admin/tasks/'.$task->id.'/submissions')}}"><i class="zmdi zmdi-chart action-icon"></i>{{ __('label.task_report') }}</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </td>
                                        @endunlessrole
                                        @hasrole('Pengajar')
                                        <td>
                                            @if($task->status == 1)
                                                <button type="button" class="btn btn-toggle status-toggle active" data-toggle="button" aria-pressed="true" autocomplete="off" data-task-id="{{$task->id}}">
                                                    <div class="handle"></div>
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-toggle status-toggle" data-toggle="button" aria-pressed="false" autocomplete="off" data-task-id="{{$task->id}}">
                                                    <div class="handle"></div>
                                                </button>
                                            @endif
                                        </td>
                                        @endhasrole
                                        <td>{{$task->deadline}}</td>
                                        <td>{{$task->learningTopic->name}}</td>
                                        <td>{{$task->subject->name}}</td>
                                        <td>{{$task->user->name}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @hasrole('Pengajar')
                        <div class="col-lg-3 col-12 mb-3">
                            <button type="submit" class="btn btn-warning btn-raised waves-effect">{{ __('button-label.batch_delete') }}</button>
                        </div>
                    </form>
                    @endhasrole
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page-script')
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
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
@endsection
@push('after-scripts')
<script>
    $(document).ready(function(){
        $('.status-toggle').on('click',function(){

            let status = $(this).attr("aria-pressed")
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')
            let task_id = $(this).data("task-id")

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                url: '{!! \LaravelLocalization::localizeURL("/") !!}/admin/tasks/'+task_id+'/status/change',
                type: 'patch',
                dataType: 'json',
                data: {
                    status: status,
                },
                success: function(response){
                    $('.alert-danger').slideUp(500)
                    $('.alert-success').slideDown(500).delay(1000).slideUp()
                    $('.alert-success').text(response['message'])
                },
                error: function(response){
                    $('.alert-success').slideUp(500)
                    $('.alert-danger').slideDown(500).delay(1000).slideUp()
                    $('.alert-danger').text("{!! __('messages.task_status_unchanged') !!}")
                },
            })
        });
    })
</script>
@endpush