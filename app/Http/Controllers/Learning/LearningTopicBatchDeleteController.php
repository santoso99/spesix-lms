<?php

namespace App\Http\Controllers\Learning;

use App\LearningTopic;
use App\LearningMaterial;
use App\Task;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class LearningTopicBatchDeleteController extends Controller
{
    public function __invoke(Request $request)
    {
        $topic_ids = $request->topic_id;

        if($topic_ids == null){
            return back();
        }

        DB::table('basic_competency_topic')->whereIn('learning_topic_id',$topic_ids)->delete();
        DB::table('learning_topic_grade')->whereIn('learning_topic_id',$topic_ids)->delete();

        $material_files = LearningMaterial::whereIn('learning_topic_id', array_filter($topic_ids))->pluck('file_path')->toArray();
        $rpp_files = LearningTopic::whereIn('id',$topic_ids)->pluck('rpp_file')->toArray();
        $task_files = Task::whereIn('id',$topic_ids)->pluck('attachment_path')->toArray();

        Storage::delete(array_filter($material_files));
        Storage::delete(array_filter($rpp_files));
        Storage::delete(array_filter($task_files));

        LearningTopic::whereIn('id', $topic_ids)->delete();

        Cache::forget('topics');
        Cache::forget('recent_topics');

        return back()->with('status', __('messages.topic_data_deleted'));
    }
}
