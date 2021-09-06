@extends('layouts.master')

@section('title')
    {{ __('section-title.learning_topic_data') }}
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
                <h2><strong><strong><i class="zmdi zmdi-file-text"></i> {{ __('section-title.learning_topic_data') }}</strong></h2>
                @hasrole('Pengajar')
                <ul class="header-dropdown">
                    <li>
                        <a role="button" class="btn btn-success" href="{{\LaravelLocalization::localizeURL('admin/topics/create')}}"><i class="zmdi zmdi-plus text-light"></i> {{ __('label.add') }} {{ __('label.topic') }}</a>
                    </li>
                </ul>
                @endhasrole
            </div>
            <div class="body">
                @include('admin.learning-topic.overview.topic-table')
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