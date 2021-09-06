<!-- Remidial Score Input Modal -->
<div class="modal fade" id="remedScoreInputModal" tabindex="-1" role="dialog" aria-labelledby="remedScoreInputModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form>
            <div class="modal-header">
                <h5 class="modal-title" id="remedScoreInputModalTitle">{{ __('section-title.remed_score_input')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body row">
                <div class="form-group col-md-4 col-sm-12">
                    <label for="">{{ __('label.remed_score')}} <span class="text-danger">*</span></label>
                </div>
                <div class="form-group col-md-4 col-sm-12">
                    <input id="remedialScoreInput" type="text" class="form-control" name="remedial_score" value="">
                </div>
                <div class="form-group col-md-4 col-sm-12">
                    <select id="remedialSelect" name="is_remedial" class="form-control">
                        <option value="1">{{ __('label.failed')}}</option>
                        <option value="0">{{ __('label.passed')}}</option>
                    </select>
                    <button id="btnSaveRemedialScore" type="submit" class="btn btn-primary btn-raised btn-round waves-effect float-right mt-3">{{ __('button-label.save')}}</button>
                </div>
            </div>
        </form>
    </div>
    </div>
</div>
{{-- Score Summary per Competency --}}
<div class="modal fade" id="scorePerCompetencyModal" tabindex="-1" role="dialog" aria-labelledby="scorePerCompetencyModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
        <form class="new-added-form">
            <div class="modal-header">
                <h5 class="modal-title" id="scorePerCompetencyModalTitle">{{ __('section-title.score_per_competency')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('label.basic_competency')}}</th>
                            <th>{{ __('label.question_count')}}</th>
                            <th>{{ __('label.correct_answer')}}</th>
                            <th>{{ __('label.score')}}</th>
                        </tr>
                    </thead>
                    <tbody id="competencyScoreSummaryWrapper">
                        
                    </tbody>
                </table>
            </div>
        </form>
    </div>
    </div>
</div>