@isset($questions)
<table class="table">
    <thead>
        <tr>
            <th>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input checkAll">
                    <label class="form-check-label">-</label>
                </div>
            </th>
            <th>
                {{ __('label.number')}}
            </th>
            <th>{{ __('label.type')}}</th>
            <th>{{ __('label.question')}}</th>
        </tr>
    </thead>
    <tbody>
        @php($no=0)
        @foreach($questions as $question)
        <tr>
            <td>
                <div class="form-check">
                    <input type="checkbox" name="question_id[]" value="{{$question->id}}" class="form-check-input">
                    <label class="form-check-label">-</label>
                </div>
            </td>
            <td>
                {{++$no}}
            </td>
            <td>
                {{$question->questionType->name}}
            </td>
            <td>
                <div id="question-item-wrapper">
                    <h6 class="mb-0">{{$question->title}}</h6>
                    <span>{!!$question->excerpt!!}</span>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="col-lg-4 col-12">
    <button id="btnAddQuestionToExam" type="submit" class="btn btn-primary btn-raised btn-round waves-effect">{{ __('button-label.add_to_evaluation')}}</button>
</div>
<div class="col-lg-6 col-12 mt-3 float-right">
    {!! $questions->render() ?? null !!}
</div>
@endisset