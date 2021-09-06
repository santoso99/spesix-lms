@if(!isset($exam_finish))
<div class="exam-sidebar mb-3">
    <p class="text-center">{{ __('messages.finish_evaluation_click') }}</p>
    <form method="post" action="{{\LaravelLocalization::localizeURL('exams/'.$exam->id.'/finish')}}">
        @csrf
        @method('patch')
        <button type="submit" class="btn btn-success btn-lg w-100 text-uppercase"><i class="fa fa-check-circle mr-3 text-light"></i> {{ __('label.done') }}</button>
    </form>
</div>
@endif
<div class="exam-sidebar mb-3">
    <div id="exam-info">
        <h4 class="font-weight-bold mb-4">{{$exam->title}}</h4>
        <p><i class="fa fa-journal-whills"></i> {{$exam->subject->name}}</p>
        <p><i class="fa fa-calendar-alt"></i> {{$exam->date->format('d F Y')}}</p>
        <p><i class="far fa-clock"></i> {{$exam->time_start.' - '.$exam->time_end}}</p>
    </div>
    <div id="student-info">
        <img src="{{ Auth::user()->avatar ? asset('storage/'.Auth::user()->avatar) : asset('img/avatar/default-user.jpg') }}" class="rounded-circle" width="75px">
        <p class="title">{{Auth::user()->name}}</p>
        <small class="text-secondary">{{ __('label.class') }} {{Auth::user()->grade->name}}</small><br>
        <small class="text-secondary">{{Auth::user()->member->identity_number}}</small>
    </div>
</div>