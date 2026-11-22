<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Poll for unread notifications count + latest notifications
     */
    public function poll()
    {
        $user  = Auth::user();
        $count = $user->notifications()->whereNull('read_at')->count();

        $notifications = $user->notifications()
            ->with('fromUser')
            ->latest()
            ->take(10)
            ->get()
            ->map(fn($n) => [
                'id'        => $n->id,
                'type'      => $n->type,
                'title'     => $n->title,
                'body'      => $n->body,
                'url'       => $n->url,
                'read'      => $n->read_at !== null,
                'time'      => $n->created_at->diffForHumans(),
                'from_name' => $n->fromUser?->name,
            ]);

        return response()->json([
            'count'         => $count,
            'notifications' => $notifications,
        ]);
    }

    /**
     * Mark a notification as read
     */
    public function markRead(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    /**
     * Mark all as read
     */
    public function markAllRead()
    {
        Auth::user()->notifications()
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }
}
