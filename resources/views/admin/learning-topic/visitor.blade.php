@extends('layouts.master')

@section('title')
    {{ __('section-title.learning_topic_visitor') }}
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
                <h2>{{ __('section-title.learning_topic_visitor') }} <strong>{{$topic->name}}</strong></h2>
            </div>
            <div class="body">
                <div class="table-responsive result-table-box">
                    <table class="table table-bordered table-striped table-hover dataTable">
                        <thead>
                            <tr>
                                <th>{{ __('label.number') }}</th>
                                <th>{{ __('label.name') }}</th>
                                <th>{{ __('label.type') }}</th>
                                <th>{{ __('label.class') }}</th>
                                <th>{{ __('label.last_visit') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($no=0)
                            @foreach($topic->visitors as $visitor)
                                <tr>
                                    <td>{{++$no}}</td>
                                    <td>{{$visitor->name}}</td>
                                    <td>{{$visitor->roles[0]->name}}</td>
                                    <td>{{$visitor->grade->name ?? ""}}</td>
                                    <td>{{$visitor->pivot->updated_at}}</td>
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
@push('after-scripts')
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
@endpush