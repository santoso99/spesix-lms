<?php

namespace App\Http\Controllers\Announcement;

use App\Announcement;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnnouncementLoadMoreController extends Controller
{

    public function __invoke(Request $request)
    {
        if(!$request->ajax()){
            return response()->json("Direct Access Disallowed");
        }

        try {
            $announcements = Announcement::with('user')->select('id','user_id','title','date','start_time')->orderBy('date','desc')->skip($request->skip)->take(5)->get();

            return view('frontpage.announcement.list',compact('announcements'));

        } catch (\Throwable $e) {
            return response()->json(array('error' => true, 'message' => $e));
        }
    }
}
