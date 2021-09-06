@isset($competencies)
<p>{{ __('section-title.select_from_competency_data') }}</p>
<table class="table">
    <thead>
        <tr>
            <th>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input checkAll">
                    <label class="form-check-label">{{ __('label.basic_competency') }}</label>
                </div>
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($competencies as $competency)
        <tr>
            <td>
                <div class="form-check">
                    <input type="checkbox" name="competency_id[]" value="{{$competency->id}}" class="form-check-input">
                    <label class="form-check-label">{{$competency->competency}}</label>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="col-md-6 col-12">
    <button id="btnAddKdToTopic" type="submit" class="btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.add_to_learning_topic') }}</button>
</div>
<div class="col-md-6 col-12 mt-3 float-right">
    {!! $competencies->render() ?? null !!}
</div>
@endisset