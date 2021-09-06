@extends('layouts.master')

@section('title')
    {{ __('section-title.task_submission_data')}}
@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
@stop

@section('content')
<div class="row clearfix">
    <div class="col-lg-12 col-12">
        <div class="card">
            <div class="header">
                <h2><strong>{{ __('section-title.task_submission_data')}}</strong></h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table dataTable text-nowrap">
                        <thead>
                            <tr>
                                <th class="no-sort">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input checkAll">
                                        <label class="form-check-label">-</label>
                                    </div>
                                </th>
                                <th>{{ __('label.number')}}</th>
                                <th>{{ __('label.name')}}</th>
                                <th>{{ __('label.submit_time')}}</th>
                                <th>{{ __('label.status')}}</th>
                                <th>{{ __('label.grade')}}</th>
                                @hasrole('Siswa')
                                <th class="no-sort"><i class="zmdi zmdi-settings"></i> {{ __('label.action')}}</th>
                                @endhasrole
                            </tr>
                        </thead>
                        <tbody>
                            @php($no=0)
                            @foreach($submissions as $submission)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" value="{{$submission->id}}" name="submission_id[]" class="form-check-input">
                                            <label class="form-check-label"></label>
                                        </div>
                                    </td>
                                    <td>{{++$no}}</td>
                                    <td>{{$submission->task->name}}</td>
                                    <td>{{($submission->updated_at != null) ? $submission->updated_at : $submission->created_at}}</td>
                                    <td>
                                        @if($submission->status == 1)
                                            <span class="badge badge-pill badge-success">{{ __('label.on_time')}}</span>
                                        @elseif($submission->status == 2)
                                            <span class="badge badge-pill badge-warning">{{ __('label.late')}}</span>
                                        @else
                                            <span class="badge badge-pill badge-secondary">{{ __('label.not_submit_yet')}}</span>
                                        @endif
                                    </td>
                                    <td>{{$submission->mark}}</td>
                                    @hasrole('Siswa')
                                    <td>
                                        <a class="text-success" href="{{\LaravelLocalization::localizeURL('tasks/'.$submission->task_id)}}"><i class="zmdi zmdi-eye mr-2"></i>{{ __('label.show')}}</a>
                                    </td>
                                    @endhasrole
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
@stop