@extends('layouts.master')
@section('title')
    {{ __('section-title.user_data') }}
@endsection
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
@stop
@section('content')
<!-- Basic Examples -->
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
                <h2><strong>Account</strong> Data </h2>
                <ul class="header-dropdown">
                    <li>
                        <a role="button" class="btn btn-success" href="{{\LaravelLocalization::localizeURL('admin/users/create')}}"><i class="zmdi zmdi-plus text-light"></i> {{ __('label.add') }} {{ __('label.account') }}</a>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <form action="{{route('user.batch.delete')}}" method="POST">
                        @csrf
                        @method('delete')
                        <table class="table table-hover dataTable">
                            <thead>
                                <tr>
                                    <th class="no-sort">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input checkAll">
                                            <label class="form-check-label">-</label>
                                        </div>
                                    </th>
                                    <th>{{ __('label.number') }}</th>
                                    <th>{{ __('label.reg_number') }}</th>
                                    <th>{{ __('label.name') }}</th>
                                    <th>{{ __('label.email') }}</th>
                                    <th>{{ __('label.level') }}</th>
                                    <th>{{ __('label.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($no=0)
                                @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" name="user_id[]" value="{{$user->id}}" class="form-check-input">
                                            <label class="form-check-label"></label>
                                        </div>
                                    </td>
                                    <td>{{++$no}}</td>
                                    <td>{{$user->member->identity_number ?? null}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->roles[0]['name']}}</td>
                                    <td>
                                        <a class="text-success" href="{{\LaravelLocalization::localizeURL('admin/users/'.$user->id.'/edit')}}"><i
                                            class="zmdi zmdi-edit"></i> {{ __('label.edit') }}</a>
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

@stop
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