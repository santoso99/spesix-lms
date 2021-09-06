<!-- Modal -->
<div class="modal fade" id="announcementDetailModal" tabindex="-1" role="dialog" aria-labelledby="announcementDetailModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="announcementDetailModalTitle">{{$announcement->title}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="announcement-time mb-5">
                <span class="text-secondary mr-5"><i class="far fa-calendar-alt mr-2"></i> {{ $announcement->formatted_date }}</span>
                <span class="text-secondary"><i class="far fa-clock mr-2"></i> {{ $announcement->formatted_start_time }}</span>
            </div>
            <div class="announcement-content">
                {!! $announcement->content !!}
            </div>
        </div>
    </div>
    </div>
</div>