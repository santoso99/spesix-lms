@if(sizeof($exams) == 0)
    <div class="text-center">
        <p>{{ __('label.no_evaluation')}}</p>
    </div>
@else
    @foreach($exams as $exam)
        <div class="card card-topic">
            <div class="card-body p-0">
                <div class="exam-item row align-items-end">
                    <div class="exam-info col-lg-9 col-12">
                        <h4><i class="fa fa-clipboard-list text-dark mr-3"></i> {{$exam->title}}</h4>
                        <p><b>{{$exam->subject->name}}</b> | {{$exam->user->name}} | {{$exam->date->format('d F Y')}} | {{$exam->time_start.' - '.$exam->time_end}}</p>
                        <span class="text-secondary">{{ __('label.question_count')}}: {{$exam->total_question}}</span>
                    </div>
                    <div class="col-lg-3 col-12 topic-action">
                        <div class="btn-group" role="group">
                            <button class="btn btn-lg bg-light-purple text-light action-icon"><i class="fa fa-play"></i></button>
                            @if(Auth::check())
                                @if(Auth::user()->roles[0]->name == "Siswa")
                                    <a href="{{\LaravelLocalization::localizeURL('exams/'.$exam->id.'/create')}}" class="btn bg-purple text-light action-text">{{ __('button-label.take_exam')}}</a>
                                @else
                                    <button disabled class="btn bg-purple text-light action-text">{{ __('button-label.take_exam')}}</button>
                                @endif
                            @else
                                <button disabled class="btn bg-purple text-light action-text">{{ __('button-label.take_exam')}}</button>
                            @endif()
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif