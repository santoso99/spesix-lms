@for($j=0;$j<count($labels);$j++)
<div class="col-md-3 col-sm-12 mb-5">
    <a href="#" class="folder-link {{$label_category}}-folder" data-school-year="{{$topic_data['school_year']}}" data-semester="{{$topic_data['semester']}}" data-label-id="{{$labels[$j]['id']}}" data-grade-id="{{$topic_data['grade_id'] ?? null}}">
        <div class="d-flex text-center flex-column">
            <i class="zmdi zmdi-folder folder-icon"></i>
            <span class="folder-name">{{$labels[$j]['name']}}</span>
        </div>
    </a>
</div>
@endfor