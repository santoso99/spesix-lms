@php($no=0)
@foreach($exam_questions as $exam_question)
<tr>
    <td>
        <div class="form-check">
            <input type="checkbox" value="{{$exam_question->id}}" name="question_id[]" class="form-check-input">
        </div>
    </td>
    <td>
        {{++$no}}
    </td>
    <td>
        @if($exam_question->question_type_id == 1)
            <span class="badge badge-pill badge-primary">{{ __('label.multiple_choice')}}</span>
        @elseif($exam_question->question_type_id == 2)
            <span class="badge badge-pill badge-warning">{{ __('label.essay')}}</span>
        @endif
    </td>
    <td class="clickable-row" data-href="{{\LaravelLocalization::localizeURL('admin/questions/'.$exam_question->id)}}">
        <h6 class="mb-0">{{$exam_question->title}}</h6>
        <span>{!! $exam_question->excerpt !!}</span>
    </td>
    <td class="kd-question">
        <select data-exam-question-id="{{$exam_question->pivot->id}}" class="w-100 form-control kd-question-select">
            <option value="">{{ __('label.select')}}</option>
            @foreach($competencies as $competency)
                <option value="{{$competency->id}}" @if($exam_question->pivot->basic_competency_id == $competency->id) selected @endif>{{$competency->competency}}</option>
            @endforeach
        </select>
    </td>
</tr>
@endforeach