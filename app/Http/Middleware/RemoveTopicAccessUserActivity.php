<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Cache;

class RemoveTopicAccessUserActivity
{

    public function handle($request, Closure $next)
    {
        if(Auth::check())
        {
            Cache::forget('topic-user-active');
        }
        return $next($request);
    }
}
