@extends('layouts.master')

@section('title')
    {{ __('section-title.subject_data') }}
@endsection
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
@stop
@section('content')
@role('Admin')
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
                <h2><strong>{{ __('section-title.subject_add') }}</strong></h2>
            </div>
            <div class="body">
                <form action="{{\LaravelLocalization::localizeURL('admin/subjects')}}" method="POST">
                    @csrf
                    <div class="row clearfix">
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <input type="text" placeholder="{{ __('label.subject_name')}}" name="name" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.save') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endrole
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong><strong><i class="zmdi zmdi-collection-bookmark"></i> {{ __('section-title.subject_data') }}</strong></h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <form action="{{route('subject.batch.delete')}}" method="POST">
                        @csrf
                        @method('delete')
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
                                    {{-- <th>Jumlah Topik Pembelajaran dibuat</th> --}}
                                    @hasrole('Admin')
                                    <th class="no-sort"><i class="zmdi zmdi-settings"></i> {{ __('label.action') }}</th>
                                    @endhasrole
                                </tr>
                            </thead>
                            <tbody>
                                @php($no=0)
                                @foreach($subjects as $subject)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" name="subject_id[]" value="{{$subject->id}}" class="form-check-input">
                                                <label class="form-check-label">{{++$no}}</label>
                                            </div>
                                        </td>
                                        <td>{{$subject->name}}</td>
                                        {{-- <td>--</td> --}}
                                        @hasrole('Admin')
                                        <td>
                                            <a class="text-success" href="{{\LaravelLocalization::localizeURL('admin/subjects/'.$subject->id.'/edit')}}"><i
                                                class="zmdi zmdi-edit action-icon"></i>{{ __('label.edit') }}</a>
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
<!-- All Subjects Area End Here -->
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