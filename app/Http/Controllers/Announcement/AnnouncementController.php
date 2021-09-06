<?php

namespace App\Http\Controllers\Announcement;

use App\Announcement;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\AnnouncementFormRequest;

class AnnouncementController extends Controller
{

    public function index()
    {
        $announcements = Announcement::select('id','title','date','start_time')->orderBy('date','asc')->get();
        return view('admin.announcement.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcement.create');
    }

    public function store(AnnouncementFormRequest $request)
    {
        Announcement::create([
            'title' => $request->title,
            'user_id' => Auth::user()->id,
            'excerpt' => $request->content,
            'content' => $request->content,
            'date' => $request->date,
            'start_time' => $request->start_time,
        ]);

        return redirect('admin/announcements')->with('status',__('messages.announcement_data_published'));
    }

    public function show(Request $request, Announcement $announcement)
    {
        if($request->ajax()){
            $content = view('frontpage.announcement.modal', compact('announcement'))->render();

            return response()->json(['success' => true, 'content' => $content]);
        }

        $announcements = Announcement::select('id','title','excerpt','date','start_time')
                            ->orderBy('date','asc')
                            ->get();
        
        $specific_date_announcements = $announcements->where('date',date('Y-m-d'))->all();

        $calendar_data = $announcements->map(function($items){
            $data['title'] = $items->title;
            $data['start'] = $items->start;
            return $data;
        });

        return view('frontpage.announcement.show',compact('announcement','specific_date_announcements','calendar_data'));

    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcement.edit', compact('announcement'));
    }

    public function update(AnnouncementFormRequest $request, Announcement $announcement)
    {
        $announcement->update([
            'title' => $request->title,
            'user_id' => Auth::user()->id,
            'excerpt' => $request->content,
            'content' => $request->content,
            'date' => $request->date,
            'start_time' => $request->start_time,
        ]);

        return redirect('admin/announcements')->with('status',__('messages.announcement_data_updated'));
    }

    public function indexByDate(Request $request)
    {
        if(!$request->ajax()){
            return response()->json("Direct Access Disallowed");
        }

        try {
            $specific_date_announcements = Announcement::select('id','title','excerpt','date','start_time')
                                        ->whereDate('date', $request->date)
                                        ->orderBy('date','asc')
                                        ->get();

            $content = view('frontpage.announcement.list',compact('specific_date_announcements'))->render();

            return response()->json(array('success' => true, 'content' => $content, 'selected_date' => Carbon::parse($request->date)->format('d F Y')));

        } catch (\Throwable $e) {
            return response()->json(array('error' => true, 'message' => $e));
        }
    }
}
