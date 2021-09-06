@extends('layouts.master')

@section('title')
    {{ __('section-title.sop_data') }}
@endsection
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/dropify/css/dropify.min.css')}}"/>
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
                <h2><strong>{{ __('section-title.sop_add') }}</strong></h2>
            </div>
            <div class="body">
                <form action="{{\LaravelLocalization::localizeURL('admin/sops')}}" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('admin.sop.form')
                    <div class="row clearfix">
                        <div class="col-sm-8 offset-sm-2">
                            <button type="submit" class="btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>{{ __('section-title.sop_data') }}</strong></h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <form action="{{\LaravelLocalization::localizeURL('admin/sops')}}" method="POST">
                        @csrf
                        @method("delete")
                        <table class="table table-hover dataTable">
                            <thead>
                                <tr>
                                    <th class="no-sort">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input checkAll">
                                            <label class="form-check-label">{{ __('label.number') }}</label>
                                        </div>
                                    </th>
                                    <th>{{ __('label.name') }}</th>
                                    <th>{{ __('label.uploaded_by') }}</th>
                                    <th class="no-sort text-right"><i class="zmdi zmdi-settings"></i> {{ __('label.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($no=0)
                                @foreach($sops as $sop)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" name="sop_id[]" value="{{$sop->id}}" class="form-check-input">
                                                <label class="form-check-label">{{++$no}}</label>
                                            </div>
                                        </td>
                                        <td>{{$sop->filename}}</td>
                                        <td>{{$sop->user->name}}</td>
                                        <td class="header">
                                            <ul class="header-dropdown">
                                                <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                                    <ul class="dropdown-menu dropdown-menu-right slideUp">
                                                        <li>
                                                            <a href="{{\LaravelLocalization::localizeURL('admin/sops/'.$sop->id.'/edit')}}"><i class="zmdi zmdi-edit action-icon"></i> {{ __('label.edit') }}</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{asset('storage/'.$sop->file_path)}}" download><i
                                                                class="zmdi zmdi-cloud-download action-icon"></i> {{ __('label.download') }}</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-lg-3 col-12">
                            <button type="submit" class="btn btn-warning btn-raised waves-effect">{{ __('button-label.batch_delete') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('after-scripts')
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('assets/plugins/dropify/js/dropify.min.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/dropify.js')}}"></script>
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