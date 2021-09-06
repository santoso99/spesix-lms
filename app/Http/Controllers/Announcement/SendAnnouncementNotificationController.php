<?php

namespace App\Http\Controllers\Announcement;

use App\Announcement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SendAnnouncementNotificationController extends Controller
{
    
    public function __invoke(Announcement $announcement, Request $request)
    {
        $content = array(
            "en" => $request->notification_content ?? "Content",
        );
        $heading = array(
            "en" => $request->notification_title ?? "Title",
        );
        
        $fields = array(
            'app_id' => config('services.onesignal.app_id'),
            'included_segments' => array(
                'All'
            ),
            'data' => array(
                "foo" => "bar"
            ),
            'url' => \LaravelLocalization::localizeURL('announcements/'.$announcement->id),
            'contents' => $content,
            'headings' => $heading,
        );
        
        $fields = json_encode($fields);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic '.config('services.onesignal.rest_api_key'),
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        return $response;
    }
}
