<?php

namespace App\Http\Controllers\Announcement;

use App\Announcement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnnouncementBatchDeleteController extends Controller
{
    public function __invoke(Request $request)
    {
        $announcement_ids = $request->announcement_id;

        if($announcement_ids == null){
            return back();
        }

        Announcement::whereIn('id', $announcement_ids)->delete();
        return back()->with('status', __('messages.announcement_data_deleted'));
    }
}
