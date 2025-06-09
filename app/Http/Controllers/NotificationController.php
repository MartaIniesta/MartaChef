<?php

namespace App\Http\Controllers;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user()->refresh();
        $notifications = $user->notifications()->latest()->paginate(20);
        $unreadCount = $user->unreadNotifications()->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    public function destroy($id)
    {
        $notification = DatabaseNotification::find($id);

        if ($notification && $notification->notifiable_id === Auth::id()) {
            $notification->markAsRead();
            $notification->delete();
        }

        return redirect()->back()->with('status', 'Notificación eliminada');
    }
}
