<?php

namespace App\Http\Controllers;

use App\Member;
use App\Subject;
use App\LearningTopic;
use App\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $student_count = Member::whereNotNull('grade')->count();
        $teacher_count = Member::whereNull('grade')->count();
        $subject_count = Subject::count();
        $topic_count = LearningTopic::count();

        $announcements = Announcement::select('id','title','excerpt','date','start_time')
                            ->orderBy('date','asc')
                            ->get();
        
        $specific_date_announcements = $announcements->where('date',date('Y-m-d'))->all();

        $calendar_data = $announcements->map(function($items){
            $data['title'] = $items->title;
            $data['start'] = $items->start;
            return $data;
        });

        return view('admin.dashboard.admin', compact('student_count','teacher_count','subject_count','topic_count','specific_date_announcements','calendar_data'));
    }

    public function indexTeacher()
    {
        $topics = Auth::user()->learningTopics->take(5);
        $tasks = Auth::user()->tasks;
        $exams = Auth::user()->exams;

        $announcements = Announcement::select('id','title','excerpt','date','start_time')
                            ->orderBy('date','asc')
                            ->get();
        
        $specific_date_announcements = $announcements->where('date',date('Y-m-d'))->all();

        $calendar_data = $announcements->map(function($items){
            $data['title'] = $items->title;
            $data['start'] = $items->start;
            return $data;
        });

        return view('admin.dashboard.teacher', compact('topics','tasks','exams','specific_date_announcements','calendar_data'));
    }
}
