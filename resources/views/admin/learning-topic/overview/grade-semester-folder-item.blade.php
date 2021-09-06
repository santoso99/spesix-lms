@for($j=1;$j<=6;$j++)
    <div class="col-md-3 col-sm-12 mb-5">
        @if($j<=2)
            <a href="#" class="folder-link grade-semester-folder" data-school-year="{{$school_year}}" data-grade-level="7" data-semester="{{$j}}">
                <div class="d-flex text-center flex-column">
                    <i class="zmdi zmdi-folder folder-icon"></i>
                    <span class="folder-name">VII - Semester {{$j}}</span>
                </div>
            </a>
        @elseif($j<=4)
            <a href="#" class="folder-link grade-semester-folder" data-school-year="{{$school_year}}" data-grade-level="8" data-semester="{{$j}}">
                <div class="d-flex text-center flex-column">
                    <i class="zmdi zmdi-folder folder-icon"></i>
                    <span class="folder-name">VIII - Semester {{$j}}</span>
                </div>
            </a>
        @else
            <a href="#" class="folder-link grade-semester-folder" data-school-year="{{$school_year}}" data-grade-level="9" data-semester="{{$j}}">
                <div class="d-flex text-center flex-column">
                    <i class="zmdi zmdi-folder folder-icon"></i>
                    <span class="folder-name">IX - Semester {{$j}}</span>
                </div>
            </a>
        @endif
    </div>
@endfor