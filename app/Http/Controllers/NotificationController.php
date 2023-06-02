<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function updateNotificationCount(Request $request)
    {
        $userNotification = Notification::where('user_id', $request->id)->update(['is_unread' => false]);
        return response()->json($userNotification);
    }

    public function updateNotificationAccept(Notification $notification)
    {
        $userNotification = Notification::where('id', $notification->id)->update(['status' => 1]);
        return response()->json($userNotification);
    }

    public function updateNotificationReject(Notification $notification){
        $userNotification = Notification::where('id', $notification->id)->update(['status' => 2]);
        return response()->json($userNotification);
    }
}
