@if(isset($announcement))
<h2 class="title mb-1">
    {{$announcement->title}} 
    @auth()
        @if(Auth::user()->id == $announcement->user->id) 
            <a href="{{\LaravelLocalization::localizeURL('admin/announcements/'.$announcement->id.'/edit')}}" class="ml-3" title="Edit"><i class="fa fa-pencil-alt"></i></a> 
        @endif
    @endauth
</h2>
<div class="announcement-time">
    <span class="text-secondary mr-5"><i class="far fa-calendar-alt mr-2"></i> {{ $announcement->formatted_date }}</span>
    <span class="text-secondary"><i class="far fa-clock mr-2"></i> {{ $announcement->formatted_start_time }}</span>
</div>
<div class="py-3 my-3">
    {!! $announcement->content !!}
</div>
@endif