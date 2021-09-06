@extends('layouts.master')
@section('title')
    {{ __('section-title.school_member_data') }}
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
                <h2><strong>School</strong> Member</h2>
                <ul class="header-dropdown">
                    <li>
                        <a role="button" class="btn btn-success" href="{{\LaravelLocalization::localizeURL('admin/members/create')}}"><i class="zmdi zmdi-plus text-light"></i> {{ __('menu-label.import_data') }}</a>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <form action="{{route('members.batch.delete')}}" method="POST">
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
                                    <th>{{ __('label.reg_number') }}</th>
                                    <th>{{ __('label.name') }}</th>
                                    <th>{{ __('label.pob') }}</th>
                                    <th>{{ __('label.class') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($no=0)
                                @foreach($members as $member)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" name="member_id[]" value="{{$member->id}}" class="form-check-input">
                                            <label class="form-check-label">{{++$no}}</label>
                                        </div>
                                    </td>
                                    <td>{{$member->identity_number}}</td>
                                    <td>{{$member->name}}</td>
                                    <td>{{$member->pob}}</td>
                                    <td>{{$member->grade}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-lg-3 col-12">
                            <button type="submit" class="btn btn-warning btn-block waves-effect">{{ __('button-label.batch_delete') }}</button>
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
@stop