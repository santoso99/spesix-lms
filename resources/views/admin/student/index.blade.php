@extends('layouts.master')
@section('title')
{{ __('section-title.student_data') }}
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
                <h2><strong><i class="zmdi zmdi-accounts"></i> {{ __("label.student") }}</strong></h2>
                @hasrole('Admin')
                <ul class="header-dropdown">
                    <li>
                        <a role="button" class="btn btn-success" href="{{\LaravelLocalization::localizeURL('admin/students/create')}}"><i class="zmdi zmdi-plus text-light"></i> {{ __('label.add') }} {{ __('label.student') }}</a>
                    </li>
                </ul>
                @endhasrole
            </div>
            <div class="body">
                <div class="table-responsive">
                    <form action="{{route('student.batch.delete')}}" method="POST">
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
                                    <th>{{ __('label.student_reg_number') }}</th>
                                    <th>{{ __('label.name') }}</th>
                                    <th>{{ __('label.class') }}</th>
                                    <th>{{ __('label.account_created') }}</th>
                                    @hasrole('Admin')
                                    <th class="no-sort"><i class="zmdi zmdi-settings"></i> {{ __('label.action') }}</th>
                                    @endhasrole
                                </tr>
                            </thead>
                            <tbody>
                                @php($no=0)
                                @foreach($students as $student)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" value="{{$student->id}}" name="student_id[]" class="form-check-input">
                                            <label class="form-check-label">{{++$no}}</label>
                                        </div>
                                    </td>
                                    <td>{{$student->identity_number}}</td>
                                    <td>{{$student->name}}</td>
                                    <td>{{$student->grade}}</td>
                                    <td>
                                        @if($student->is_account_created == 1)
                                            <span class="text-success">{{ __('label.account_exist') }}</span>
                                        @else
                                            <span class="text-danger">{{ __('label.account_not_exist') }}</span>
                                        @endif
                                    </td>
                                    @hasrole('Admin')
                                    <td>
                                        <a class="text-success mr-2" href="{{\LaravelLocalization::localizeURL('admin/students/'.$student->id.'/edit')}}" title="{{ __('label.edit') }}">
                                            <i class="zmdi zmdi-edit"></i>
                                        </a>
                                        @if($student->is_account_created == 1)
                                            <a class="text-success" href="{{\LaravelLocalization::localizeURL('admin/students/'.$student->user->id.'/parents/create')}}" title="{{ __('label.create_parent_account') }}">
                                                <i class="zmdi zmdi-account-add"></i>
                                            </a>
                                        @endif
                                    </td>
                                    @endhasrole
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @hasrole('Admin')
                        <div class="col-lg-3 col-12">
                            <button type="submit" class="btn btn-warning btn-block btn-raised waves-effect">{{ __('button-label.batch_delete') }}</button>
                        </div>
                        @endhasrole
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
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