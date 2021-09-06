<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>{{ __('label.type') }}</th>
                <th>{{ __('label.title') }}</th>
                <th>{{ __('label.deadline') }}</th>
            </tr>
        </thead>
        <tbody>
            @if($tasks != null)
                @foreach($tasks as $task)
                <tr>
                    <td>
                        {!! ($task->status == 0) ? '<i class="fa fa-minus-circle"></i>' : '<i class="fa fa-check-circle"></i>' !!}
                    </td>
                    @if($task->status == 0)
                        <td>{{$task->name}}</td>
                    @else
                        <td><a href="{{\LaravelLocalization::localizeURL('tasks/'.$task->id)}}">{{$task->name}}</a></td>
                    @endif
                    <td>{{$task->deadline}}</td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3" class="text-center py-3 text-secondary">{{ __('label.no_data')}} <i class="fas fa-folder-open ml-2"></i></td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
<div class="mt-3">
    <p>{{ __('label.status') }}:</p>
    <span class="mr-3"><i class="fa fa-minus-circle"></i> Closed</span><span><i class="fa fa-check-circle"></i> Open</span>
</div>