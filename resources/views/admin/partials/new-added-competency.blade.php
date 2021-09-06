@isset($topic->basicCompetencies)
    @foreach ($topic->basicCompetencies as $topic_competency)
        <div class="row">
            <div class="col-md-11 col-12 form-group">
                <input type="hidden" name="competency_id[]" value="{{$topic_competency->id}}">
                <textarea class="form-control" disabled>{{$topic_competency->competency}}</textarea>
            </div>
            <div class="col-md-1 col-12 form-group">
                <button class="btn btn-danger btn-remove-competency" title="{{ __('button-label.delete') }}">
                    <span class="zmdi zmdi-delete"></span>
                </button>
            </div>
        </div>
    @endforeach
@endisset