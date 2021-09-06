<!-- Modal -->
<div class="modal fade" id="questionBankModal" tabindex="-1" role="dialog" aria-labelledby="questionBankModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="questionBankModalTitle">{{ __('label.question_bank')}} {{ __('label.subject')}} {{$exam->subject->name}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-success alert-dismissible show fade" style="display:none" role="alert">
                
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="alert alert-danger alert-dismissible show fade" style="display:none" role="alert">
                
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <p>{{ __('label.select_from_quest_bank')}}</p>
            <div class="table-responsive">
                <form action="{{route('exams.questions.add', $exam->id)}}" method="POST">
                    @csrf
                    <div id="questionData">
                        @include('admin.exam.question-bank-data')
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>
{{-- New Question Modal --}}
<div class="modal fade" id="createQuestionModal" tabindex="-1" role="dialog" aria-labelledby="createQuestionModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('section-title.question_create') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="p-5">
                <form action="{{\LaravelLocalization::localizeURL('admin/exams/'.$exam->id.'/questions')}}" method="POST">
                    @csrf
                    @include('admin.question.form')
                    <div class="form-group text-right mg-t-8">
                        <button type="submit" class="btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>