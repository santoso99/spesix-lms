@extends('layouts.master')

@section('title')
    {{ __('section-title.teacher_data') }}
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
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="card">
            <div class="header">
                <h2><strong><i class="zmdi zmdi-account-box"></i> {{ __('label.teacher') }}</strong></h2>
                @hasrole('Admin')
                <ul class="header-dropdown">
                    <li>
                        <a role="button" class="btn btn-success" href="{{\LaravelLocalization::localizeURL('admin/teachers/create')}}"><i class="zmdi zmdi-plus text-light"></i> {{ __('label.add') }} {{ __('label.teacher') }}</a>
                    </li>
                </ul>
                @endhasrole
            </div>
            <div class="body">
                <div class="table-responsive">
                    <form action="{{route('teacher.batch.delete')}}" method="POST">
                        @csrf
                        @method('delete')
                        <table class="table table-hover js-basic-example dataTable">
                            <thead>
                                <tr>
                                    <th class="no-sort">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input checkAll">
                                            <label class="form-check-label">{{ __('label.number') }}</label>
                                        </div>
                                    </th>
                                    <th>{{ __('label.employee_reg_number') }}</th>
                                    <th>{{ __('label.name') }}</th>
                                    <th>{{ __('label.account_created') }}</th>
                                    @hasrole('Admin')
                                    <th class="no-sort"><i class="zmdi zmdi-settings"></i> {{ __('label.action') }}</th>
                                    @endhasrole
                                </tr>
                            </thead>
                            <tbody>
                                @php($no=0)
                                @foreach($teachers as $teacher)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" value="{{$teacher->id}}" name="teacher_id[]" class="form-check-input">
                                            <label class="form-check-label">{{++$no}}</label>
                                        </div>
                                    </td>
                                    <td>{{$teacher->identity_number}}</td>
                                    <td>{{$teacher->name}}</td>
                                    <td>
                                        @if($teacher->is_account_created == 1)
                                            <span class="text-success">{{ __('label.account_exist') }}</span>
                                        @else
                                            <span class="text-danger">{{ __('label.account_not_exist') }}</span>
                                        @endif
                                    </td>
                                    @hasrole('Admin')
                                    <td>
                                        <a class="text-success" href="{{\LaravelLocalization::localizeURL('admin/teachers/'.$teacher->id.'/edit')}}"><i class="zmdi zmdi-edit"></i> {{ __('label.edit') }}</a>
                                    </td>
                                    @endhasrole
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
@endsection
@push('after-scripts')
<script src="{{asset('assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
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