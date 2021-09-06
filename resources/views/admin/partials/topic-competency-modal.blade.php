<!-- Competency Data Modal -->
<div class="modal fade" id="KdDataModal" tabindex="-1" role="dialog" aria-labelledby="KdDataModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="KdDataModalTitle">{{ __('section-title.competency_data') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form>
                <div class="row">
                    <div class="col-md-6 col-12 form-group">
                        <label>{{ __('label.subject') }} <span class="text-danger">*</span></label>
                        <select class="form-control show-tick" name="subject_id" id="subjectSelectBox">
                            @foreach ($subjects as $subject)
                                <option value="{{$subject->id}}">{{$subject->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-12 form-group">
                        <label>{{ __('label.class') }} <span class="text-danger">*</span></label>
                        <select class="form-control show-tick" name="grade_level" id="gradeSelectBox">
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                        </select>
                    </div>
                    <div class="col-md-2 col-12 form-group">
                        <label class="text-light d-none d-md-block">-</label>
                        <button type="submit" id="btnFilterKd" class="btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.show') }}</button>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <form>
                    @csrf
                    <div id="KdData">
                        @include('admin.partials.competency-data')
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>
{{-- New KD Modal --}}
<div class="modal fade" id="createKdModal" tabindex="-1" role="dialog" aria-labelledby="createKdModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('section-title.competency_add') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-8 col-12 form-group">
                            <label>{{ __('label.subject') }} <span class="text-danger">*</span></label>
                            <select class="form-control show-tick" name="subject_id" id="addSubjectSelectBox">
                                @foreach ($subjects as $subject)
                                    <option value="{{$subject->id}}">{{$subject->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-12 form-group">
                            <label>{{ __('label.class') }} <span class="text-danger">*</span></label>
                            <select class="form-control show-tick" name="grade_level" id="addGradeSelectBox">
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                            </select>
                        </div>
                        <div class="col-12 form-group">
                            <label>{{ __('label.basic_competency') }} <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="competency" id="addCompetencyInput"></textarea>
                            <span class="text-danger" id="competencyError"></span>
                        </div>
                    </div>
                    <div class="form-group text-right mg-t-8">
                        <button id="btnCreateKd" class="btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>