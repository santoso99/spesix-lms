<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Cache;
use Illuminate\Support\Carbon;

class TopicAccessUserActivity
{
    public function handle($request, Closure $next)
    {
        if(Auth::check())
        {
            $expiresAt = Carbon::now()->addMinutes(2);

            $topic_user_active = [];
            if(Cache::has('topic-user-active'))
            {
                $topic_user_active = Cache::get('topic-user-active');
            }

            $user = Auth::user();
            if(!in_array($user, $topic_user_active))
            {
                array_push($topic_user_active, $user);
                Cache::put('topic-user-active', $topic_user_active, $expiresAt);
            }
        }
        return $next($request);
    }
}
