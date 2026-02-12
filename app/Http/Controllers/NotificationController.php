<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();


        $notifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();


        $unreadCount = Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();

        return view('partials.notifications', compact('notifications', 'unreadCount'));
    }

    public function markAsRead($id)
    {
        $notification = DatabaseNotification::where('id', $id)
            ->where('notifiable_id', Auth::id())
            ->first();

        if ($notification) {
            $notification->markAsRead();
        }

        return response()->json(['status' => 'success']);
    }
}
