<?php

namespace App\Http\Controllers;

use App\Announcement;
use App\LearningTopic;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{

    public function index()
    {
        $announcements = Announcement::select('id','title','excerpt','date','start_time')
                            ->orderBy('date','asc')
                            ->get();
        
        $specific_date_announcements = $announcements->where('date',date('Y-m-d'))->all();
        
        $topics = Cache::remember('recent_topics', config('cache.duration.short'), function(){
            return LearningTopic::with('user','subject','basicCompetencies')->last5();
        });

        $calendar_data = $announcements->map(function($items){
            $data['title'] = $items->title;
            $data['start'] = $items->start;
            return $data;
        });

        return view('home', compact('topics','specific_date_announcements','calendar_data'));
    }
}
