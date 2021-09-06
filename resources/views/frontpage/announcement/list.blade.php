@if(sizeof($specific_date_announcements) == 0)
    <p class="text-secondary text-center">{{ __('label.no_data')}} <i class="fas fa-folder-open ml-2 text-secondary"></i></p>
@else
    @foreach($specific_date_announcements as $announcement)
    <div class="notice-list">
        <h6 class="notice-title"><a class="announcement-title" href="{{\LaravelLocalization::localizeURL('announcements/'.$announcement->id)}}" data-id={{$announcement->id}}>{{$announcement->title}}</a></h6>
        <div class="mt-3">
            {!! $announcement->excerpt !!}
        </div>
        <div class="announcement-time d-flex flex-column">
            <span class="text-secondary mb-1"><i class="zmdi zmdi-calendar far fa-calendar-alt"></i> {{ $announcement->formatted_date }}</span>
            <span class="text-secondary"><i class="zmdi zmdi-time far fa-clock"></i> {{ $announcement->formatted_start_time }}</span>
        </div>
    </div>
    @endforeach
@endif