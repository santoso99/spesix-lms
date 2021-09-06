@for($i=0;$i<count($competency_score_summary);$i++)
    <tr>
        <td>{{$competency_score_summary[$i]['competency']}}</td>
        <td>{{$competency_score_summary[$i]['total_question']}}</td>
        <td>{{$competency_score_summary[$i]['correct_answer']}}</td>
        <td>{{$competency_score_summary[$i]['score']}}</td>
    </tr>
@endfor
<tr class="font-weight-bold">
    <td><b>Total</b></td>
    <td>{{$exam_result->exam->total_question}}</td>
    <td>{{$exam_result->total_correct_answer}}</td>
    <td>{{$exam_result->score}}</td>
</tr>