@extends('layouts.master')

@section('title')
    {{ __('section-title.student_promotion') }}
@endsection

@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/sweetalert/sweetalert.css')}}"/>
@stop

@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>{{ __('section-title.student_promotion') }}</strong></h2>
            </div>
            <div class="body">
                <form>
                    @csrf
                    <p>{{ __('messages.student_promotion') }}</p>
                    <div class="row">
                        <div class="col-lg-6 col-12 form-group">
                            <label>{{ __('form-label.promotion_select_class') }} <span class="text-danger">*</span></label>
                            <select class="form-control show-tick" id="gradeFromSelect" name="grade_from">
                                @foreach ($grades as $grade)
                                    <option value="{{$grade->id}}">{{$grade->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6 col-12 form-group">
                            <label>{{ __('form-label.promotion_class_to') }} <span class="text-danger">*</span></label>
                            <select class="form-control show-tick" id="gradeToSelect" name="grade_to">
                                @foreach ($grades as $grade)
                                    <option value="{{$grade->id}}">{{$grade->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 form-group">
                            <button id="btnPromote" type="button" class="btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.apply')}}</button>
                            <button id="btnSpinner" class="btn btn-primary btn-raised btn-round" type="button" disabled style="display:none;">
                                Loading...
                            </button>
                        </div>
                    </div>
                    <span><b>{{ __('label.note') }}</b></span><br>
                    <span>{{ __('messages.student_promotion_note') }}</span>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="row clearfix">
    <div class="col-lg-12">
        @if(session('set-grade-status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('set-grade-status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="card">
            <div class="header">
                <h2><strong>{{ __('form-label.student_edit_individu') }}</strong></h2>
                <ul class="header-dropdown">
                    <li>
                        <a role="button" class="btn btn-info btn-refresh text-light"><i class="zmdi zmdi-refresh text-light"></i> Refresh</a>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <form method="POST" action="{{\LaravelLocalization::localizeURL('admin/students/set-grade')}}">
                        @csrf
                        @method('patch')
                        <p>{{ __('messages.student_class_edit_instruction') }}</p>
                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable c_table theme-color">
                            <thead>
                                <tr>
                                    <th class="no-sort">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input checkAll">
                                            <label class="form-check-label">{{ __('label.number') }}</label>
                                        </div>
                                    </th>
                                    <th>{{ __('label.name') }}</th>
                                    <th>{{ __('label.class') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" name="student_id[]" value="{{$student->id}}" class="form-check-input">
                                            <label class="form-check-label">{{$student->identity_number}}</label>
                                        </div>
                                    </td>
                                    <td>{{$student->name}}</td>
                                    <td>{{$student->grade}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row mt-5">
                            <div class="col-12">
                                <h3>{{ __('form-label.student_edit') }}</h3>
                            </div>
                            <div class="col-12">
                                <label>{{ __('form-label.student_edit_select_class') }}</label>
                            </div>
                            <div class="col-lg-6 col-12 form-group">
                                <select class="form-control show-tick" name="grade_id">
                                    @foreach ($grades as $grade)
                                        <option value="{{$grade->id}}">{{$grade->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3 col-12 form-group">
                                <button type="submit" class="btn btn-primary btn-raised waves-effect">{{ __('button-label.apply') }}</button>
                            </div>
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
<script src="{{asset('assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
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
<script>
    $(document).ready(function(){

        $(".btn-refresh").on("click", function(e){
            e.preventDefault();
            location.reload();
            return false;
        });

        $("#btnPromote").on('click', function(e){
            e.preventDefault();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $(this).css('display','none');
            $('#btnSpinner').css('display','block');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                type: "patch",
                url: "{!! \LaravelLocalization::localizeURL('/admin/students/promote') !!}",
                data: {
                    _token: CSRF_TOKEN,
                    grade_from: $("#gradeFromSelect").val(),
                    grade_to: $("#gradeToSelect").val(),
                },
                dataType: "json",
                success: function(){
                    swal({
                        title: "Success!",
                        text: "{!! __('messages.student_class_changed') !!}",
                        icon: "success",
                    });
                    $("#btnPromote").css('display','block');
                    $("#btnSpinner").css('display','none');
                },
                error: function(){
                    swal({
                        title: "Error :(",
                        text: "{{ __('messages.student_class_unchanged')}}",
                        icon: "error",
                    });
                },
            });
        });
    });
</script>
@stop