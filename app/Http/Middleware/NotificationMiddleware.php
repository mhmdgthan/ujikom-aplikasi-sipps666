<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\NotificationService;
use Illuminate\Support\Facades\View;

class NotificationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            // Share notification data with all views
            $unreadCount = NotificationService::getUnreadCount($user->id);
            $recentNotifications = NotificationService::getRecentNotifications($user->id);
            
            View::share('notificationCount', $unreadCount);
            View::share('recentNotifications', $recentNotifications);
        }
        
        return $next($request);
    }
}