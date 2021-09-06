@extends('layouts.master')

@section('title')
    {{ __('section-title.parent_account') }}
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
                <h2><strong>Parent</strong> Account </h2>
            </div>
            <div class="body">
                <p>{{ __('messages.parent_account_can_be_created_through_student_action_button') }} <a href="{{\LaravelLocalization::localizeURL('admin/students')}}" class="ml-2">{{ __('label.create') }}</a></p>
                <div class="table-responsive">
                    <form action="{{route('parents.batch.delete')}}" method="POST">
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
                                    <th>{{ __('label.name') }}</th>
                                    <th>{{ __('label.student') }}</th>
                                    <th>{{ __('label.email') }}</th>
                                    <th>{{ __('label.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($no=0)
                                @foreach($parents as $parent)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" name="parent_id[]" value="{{$parent->id}}" class="form-check-input">
                                            <label class="form-check-label"></label>
                                        </div>
                                    </td>
                                    <td>{{++$no}}</td>
                                    <td>{{$parent->name}}</td>
                                    <td>{{$parent->student->name}}</td>
                                    <td>{{$parent->email}}</td>
                                    <td>
                                        <a class="text-success" href="{{\LaravelLocalization::localizeURL('admin/parents/'.$parent->id.'/edit')}}"><i
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