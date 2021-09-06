@extends('layouts.master')

@section('title')
    {{ __('section-title.learning_step_data')}}
@endsection
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
@stop
@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {!! session('status') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="card">
            <div class="header">
                <h2><strong></strong></h2>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-lg-6 col-12 form-group">
                        <a href="{{\LaravelLocalization::localizeURL('admin/topics/'.$topic->id.'/steps/create')}}" class="btn btn-success btn-raised waves-effect"><i class="zmdi zmdi-plus action-icon"></i>{{ __('section-title.learning_step_add')}}</a>
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
                <h2><strong>{{ __('section-title.learning_step_topic')}}</strong>: <span class="text-success">{{$topic->name}} - {{$topic->subject->name}} / {{ __('label.class')}} {{$topic->grade_level}} / {{ __('label.semester')}} {{$topic->semester}}</span></h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <form action="{{route('steps.batch.delete')}}" method="POST">
                        @csrf
                        @method('delete')
                        <table class="table table-striped dataTable text-nowrap">
                            <thead>
                                <tr>
                                    <th class="no-sort">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input checkAll">
                                            <label class="form-check-label">-</label>
                                        </div>
                                    </th>
                                    <th>{{ __('label.number')}}</th>
                                    <th>{{ __('label.title')}}</th>
                                    <th class="no-sort"><i class="zmdi zmdi-settings"></i> {{ __('label.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($no=0)
                                @foreach($steps as $step)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" value="{{$step->id}}" name="step_id[]" class="form-check-input">
                                                <label class="form-check-label"></label>
                                            </div>
                                        </td>
                                        <td>{{++$no}}</td>
                                        <td><b>{{$step->title}}</b></td>
                                        <td>
                                            <a class="text-success" href="{{\LaravelLocalization::localizeURL('admin/steps/'.$step->id.'/edit')}}"><i class="zmdi zmdi-edit mr-2"></i>{{ __('label.edit')}}</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-lg-3 col-12">
                            <button type="submit" class="btn btn-warning btn-raised btn-round waves-effect">{{ __('button-label.batch_delete')}}</button>
                        </div>
                    </form>
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