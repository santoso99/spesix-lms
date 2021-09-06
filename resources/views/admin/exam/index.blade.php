@extends('layouts.master')

@section('title')
    {{ __('section-title.evaluation_data') }}
@endsection
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
@stop
@section('content')
<div class="row clearfix">
    <div class="col-lg-12 col-12">
        <div class="alert alert-success alert-dismissible show fade mb-5" @if(!session('status'))style="display:none"@endif role="alert">
            {{ session('status') ?? null }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="alert alert-danger alert-dismissible show fade mb-5" style="display:none" role="alert">
            
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="card">
            <div class="header">
                <h2><strong><i class="zmdi zmdi-assignment"></i> {{ __('section-title.evaluation_data') }}</strong></h2>
                @hasrole("Pengajar")
                <ul class="header-dropdown">
                    <li>
                        <a role="button" class="btn btn-success" href="{{\LaravelLocalization::localizeURL('admin/exams/create')}}"><i class="zmdi zmdi-plus text-light"></i> {{ __('section-title.evaluation_create') }}</a>
                    </li>
                </ul>
                @endhasrole
            </div>
            <div class="body">
                <form action="{{route('exams.batch.delete')}}" method="POST">
                    @csrf
                    @method('delete')
                    <div class="table-responsive">
                        <table class="table table-hover dataTable c_table theme-color">
                            <thead>
                                <tr>
                                    <th class="no-sort">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input checkAll">
                                            <label class="form-check-label">-</label>
                                        </div>
                                    </th>
                                    <th>
                                        {{ __('label.name')}}
                                    </th>
                                    <th class="no-sort"><i class="zmdi zmdi-settings"></i> {{ __('label.action')}}</th>
                                    @hasrole("Pengajar")
                                    <th>{{ __('label.status')}}</th>
                                    <th>{{ __('label.publish_result?')}}</th>
                                    @endhasrole
                                    <th>{{ __('label.access_code')}}</th>
                                    <th>{{ __('label.subject')}}</th>
                                    <th>{{ __('label.class') }}</th>
                                    <th>{{ __('label.question_count')}}</th>
                                    <th>{{ __('label.date')}}</th>
                                    <th>{{ __('label.clock')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($exams as $exam)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" value="{{$exam->id}}" name="exam_id[]" class="form-check-input">
                                        </div>
                                    </td>
                                    <td>
                                        {{$exam->title}}
                                    </td>
                                    <td class="header">
                                        <ul class="header-dropdown">
                                            <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                                <ul class="dropdown-menu dropdown-menu-left slideUp">
                                                    <li>
                                                        <a href="{{\LaravelLocalization::localizeURL('admin/exams/'.$exam->id.'/edit')}}"><i class="zmdi zmdi-edit action-icon"></i>{{ __('button-label.edit_evaluation_and_question')}}</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{\LaravelLocalization::localizeURL('admin/exams/'.$exam->id.'/results')}}"><i class="zmdi zmdi-chart action-icon"></i>{{ __('button-label.show_evaluation_result')}}</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{\LaravelLocalization::localizeURL('admin/exams/'.$exam->id.'/results/responses')}}"><i class="zmdi zmdi-assignment action-icon"></i>{{ __('button-label.student_response_recap')}}</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </td>
                                    @hasrole("Pengajar")
                                    <td>
                                        @if($exam->status == 1)
                                            <button type="button" class="btn btn-toggle status-toggle active" data-toggle="button" aria-pressed="true" autocomplete="off" data-exam-id="{{$exam->id}}">
                                                <div class="handle"></div>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-toggle status-toggle" data-toggle="button" aria-pressed="false" autocomplete="off" data-exam-id="{{$exam->id}}">
                                                <div class="handle"></div>
                                            </button>
                                        @endif
                                    </td>
                                    <td>
                                        @if($exam->publish_status == 1)
                                            <button type="button" class="btn btn-toggle publish-status-toggle active" data-toggle="button" aria-pressed="true" autocomplete="off" data-exam-id="{{$exam->id}}">
                                                <div class="handle"></div>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-toggle publish-status-toggle" data-toggle="button" aria-pressed="false" autocomplete="off" data-exam-id="{{$exam->id}}">
                                                <div class="handle"></div>
                                            </button>
                                        @endif
                                    </td>
                                    @endhasrole
                                    <td><span class="ml-3 text-success">{{$exam->enroll_code}}</span></td>
                                    <td>{{$exam->subject->name}}</td>
                                    <td>
                                        @foreach($exam->grades as $grade)
                                            {{$grade->name.', '}}
                                        @endforeach
                                    </td>
                                    <td>{{$exam->total_question}}</td>
                                    <td>{{$exam->date->format('l d F Y')}}</td>
                                    <td>{{$exam->time_start.' - '.$exam->time_end}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @hasrole("Pengajar")
                        <div class="col-lg-3 col-12 mb-3">
                            <button type="submit" class="btn btn-warning btn-raised waves-effect">{{ __('button-label.batch_delete')}}</button>
                        </div>
                        @endhasrole
                    </div>
                </form>
                @hasrole("Pengajar")
                <div class="mt-5">
                    <h4 class="font-weight-bold">{{ __('label.information') }}</h4>
                    <p>{!! __('messages.evaluation_publish_info', ['status' => __('label.status'), 'publish' => __('label.publish_result?')]) !!}</p>
                </div>
                @endhasrole
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
            let exam_id = $(this).data("exam-id")

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                url: '{!! \LaravelLocalization::localizeURL("/") !!}/admin/exams/'+exam_id+'/status/change',
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
                    $('.alert-danger').text("{!! __('messages.evaluation_status_unchanged') !!}")
                },
            })
        });

        $('.publish-status-toggle').on('click',function(){

            let status = $(this).attr("aria-pressed")
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content')
            let exam_id = $(this).data("exam-id")

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                url: '{!! \LaravelLocalization::localizeURL("/") !!}/admin/exams/'+exam_id+'/publish/change',
                type: 'patch',
                dataType: 'json',
                data: {
                    publish_status: status,
                },
                success: function(response){
                    $('.alert-danger').slideUp(500)
                    $('.alert-success').slideDown(500).delay(1000).slideUp()
                    $('.alert-success').text(response['message'])
                },
                error: function(response){
                    $('.alert-success').slideUp(500)
                    $('.alert-danger').slideDown(500).delay(1000).slideUp()
                    $('.alert-danger').text("{!! __('messages.evaluation_status_unchanged') !!}")
                },
            })
        });
    });
</script>
@endpush