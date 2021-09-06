@extends('layouts.master')

@section('title')
    {{ __('section-title.question_data') }}
@endsection
@section('page-style')
<link rel="stylesheet" href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
@stop
@section('content')
<div class="row clearfix">
    <div class="col-lg-12 col-12">
        <div class="card">
            <div class="header">
                <h2>{{ __('form-label.show_question_by_subject') }}</h2>
            </div>
            <div class="body">
                <form>
                    <div class="row">
                        <div class="col-lg-6 col-12 form-group">
                            <select class="form-control show-tick" id="mapelSelectBox" name="subject_id">
                                @if(isset($subject))
                                    @foreach ($subjects as $one_subject)
                                        <option value="{{\LaravelLocalization::localizeURL('admin/questions/subjects/'.$one_subject->id)}}" @if($one_subject->id == $subject->id) selected @endif>{{$one_subject->name}}</option>
                                    @endforeach
                                @else
                                    @foreach ($subjects as $one_subject)
                                        <option value="{{\LaravelLocalization::localizeURL('admin/questions/subjects/'.$one_subject->id)}}">{{$one_subject->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">
    <div class="col-lg-12 col-12">
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
                <h2><strong><i class="zmdi zmdi-pin-help"></i> {{ __('label.question_bank') }} {{isset($subject->name) ? " - ".$subject->name : ""}}</strong></h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <form action="{{route('questions.batch.delete')}}" method="POST">
                        @csrf
                        @method('delete')
                        <table class="table table-hover dataTable c_table theme-color">
                            <thead>
                                <tr>
                                    <th class="no-sort">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input checkAll">
                                            <label class="form-check-label">{{ __('label.number') }}</label>
                                        </div>
                                    </th>
                                    <th>{{ __('label.question_type') }}</th>
                                    <th>{{ __('label.question') }}</th>
                                    <th class="no-sort"><i class="zmdi zmdi-settings"></i> {{ __('label.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($no=0)
                                @foreach($questions as $question)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" name="question_id[]" value="{{$question->id}}" class="form-check-input">
                                            <label class="form-check-label">{{++$no}}</label>
                                        </div>
                                    </td>
                                    <td>
                                        @if($question->question_type_id == 1)
                                            <span class="badge badge-pill badge-primary">{{$question->questionType->name}}</span>
                                        @elseif($question->question_type_id == 2)
                                            <span class="badge badge-pill badge-warning">{{$question->questionType->name}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div id="question-item-wrapper">
                                            <h5 class="mb-0">{{$question->title}}</h5>
                                            <p>{!!$question->excerpt!!}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="material-action">
                                            @hasrole("Pengajar")
                                            <a href="{{\LaravelLocalization::localizeURL('admin/questions/'.$question->id.'/edit')}}" class="mr-3"><i class="zmdi zmdi-edit text-primary mr-1"></i>{{ __('label.edit') }}</a>
                                            @endhasrole
                                            <a href="{{\LaravelLocalization::localizeURL('admin/questions/'.$question->id)}}"><i class="zmdi zmdi-eye text-success mr-1"></i> {{ __('label.show') }}</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @hasrole('Pengajar')
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
@push('after-scripts')
<script>
    $("#mapelSelectBox").on("change", function(){
      window.location = $(this).val();
    });
</script>
@endpush