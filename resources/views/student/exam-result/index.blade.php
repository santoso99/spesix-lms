@extends('layouts.master')

@section('title')
    {{ __('section-title.evaluation_result')}}
@endsection
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
@stop
@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        @if(session('status'))
        <div class="alert alert-warning alert-dismissible fade show mb-5" role="alert">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="card">
            <div class="header">
                <h2><strong>{{ __('section-title.evaluation_result')}}</strong></h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-hover dataTable text-nowrap">
                        <thead>
                            <tr>
                                <th>
                                    {{ __('label.number')}}
                                </th>
                                <th>{{ __('label.evaluation')}}</th>
                                <th>{{ __('label.subject')}}</th>
                                <th>{{ __('label.time')}}</th>
                                <th>{{ __('label.grade')}}</th>
                                <th>{{ __('label.note') }}</th>
                                @hasrole('Siswa')
                                <th class="no-sort"><i class="zmdi zmdi-settings"></i> {{ __('label.action')}}</th>
                                @endhasrole
                            </tr>
                        </thead>
                        <tbody>
                            @php($no=0)
                            @foreach($exam_results as $exam_result)
                                <tr>
                                    <td>
                                        {{++$no}}
                                    </td>
                                    <td><b>{{$exam_result->exam->title}}</b></td>
                                    <td>{{$exam_result->exam->subject->name}}</td>
                                    <td>
                                        {{$exam_result->exam->date->format('d F Y')}}
                                    </td>
                                    @if($exam_result->correction_status == 0)
                                        <td>
                                            <span class="text-warning font-weight-bold">Grading...</span>
                                        </td>
                                        <td>
                                            -
                                        </td>
                                        @hasrole('Siswa')
                                        <td>
                                            <a><i class="zmdi zmdi-eye-off text-success"></i></a>
                                            <a class="ml-3" href="{{\LaravelLocalization::localizeURL('exams/'.$exam_result->exam->id)}}" title="{{ __('label.open_evaluation')}}"><i class="zmdi zmdi-caret-right-circle text-success"></i></a>
                                        </td>
                                        @endhasrole
                                    @else
                                        <td>
                                            <b>{{$exam_result->score}}</b> / {{$exam_result->exam->max_score}}
                                        </td>
                                        <td class="is-remedial">
                                            @if($exam_result->is_remedial == 0)
                                                @if($exam_result->remedial_score == 0)
                                                    <span class="text-success">{{ __('label.passed') }}</span>
                                                @else
                                                    <span class="text-success">{{ __('label.pass_with_remedial') }}</span>
                                                @endif
                                            @else
                                                <span class="text-danger">{{ __('label.failed') }}</span>
                                            @endif
                                        </td>
                                        @hasrole('Siswa')
                                        <td>
                                            <a href="{{\LaravelLocalization::localizeURL('student/exams/results/'.$exam_result->id)}}" title="{{ __('label.show')}}"><i class="zmdi zmdi-eye text-success"></i></a>
                                        </td>
                                        @endhasrole
                                    @endif
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