<?php

namespace App\Http\Controllers\Frontpage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\LearningTopic;

class LearningTopicSearchController extends Controller
{

    public function __invoke(Request $request)
    {
        if($request->ajax())
        {
            try {
                
                if($request->topic_name != "")
                {
                    $topics = LearningTopic::with(['user','subject','basicCompetencies'])->where('name','LIKE','%'.$request->topic_name.'%')->get();
                }
                else {
                    $topics = LearningTopic::with(['user','subject','basicCompetencies'])->last5();
                }

                if(sizeof($topics) == 0)
                {
                    return "<p class='text-center'>".__('label.topic_not_found')."</p>";
                }
                else {
                    return view('frontpage.learning-topic.content', compact('topics'))->render();
                }
            } catch (\Throwable $th) {
                return response()->json(['error' => $th]);
            }
        }
    }
}
