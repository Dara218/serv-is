<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Models\AvailedUser;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Undefined;

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

    public function storeNotificationToCustomer(Request $request)
    {
        $fromUser = Auth::user();

        $toUser = User::where('id', $request->fromUserId)->first();

        $isAccepted = $request->is_Accepted;
        $acceptOrReject = '';

        if($isAccepted)
        {
            $acceptOrReject = 'accepted';
        }
        else{
            $acceptOrReject = 'rejected';
        }

        $notificationMessage = "$fromUser->username has $acceptOrReject your request.";
        $notificationType = 2; // 2 = normal notification

        event(new NotificationEvent(
            $fromUser->username,
            $toUser->id,
            $notificationMessage,
            $notificationType
        ));

        Notification::create([
            'user_id' => $toUser->id,
            'from_user_id' => $toUser->id,
            'username' => $fromUser->username,
            'message' => $notificationMessage,
            'is_unread' => true,
            'status' => 3, // 3 = normal notification
            'type' => 2 // 2 = normal notification
        ]);

        return response()->json($request);
    }

    public function updateAvailedUserAccepted(Notification $notification, Request $request)
    {
        $isAccepted = $request->is_Accepted;
        $accepted = false;

        if($isAccepted)
        {
            $accepted = true;
        }
        AvailedUser::where('notification_id', $notification->id)->update(['is_accepted' => $accepted]);
        return response()->json(($request));
    }

    public function storeNegotiateAgenda(Request $request){

        $fromUser = Auth::user();
        $notificationMessage = "$fromUser->username made an offer of P$request->counterPrice.";
        $notificationType = 1;

        event(new NotificationEvent(
            $fromUser->username, // from
            $request->userId, // to
            $notificationMessage,
            $notificationType
        ));

        Notification::create([
            'user_id' => $request->userId,
            'from_user_id' => $fromUser->id,
            'username' => $fromUser->username,
            'message' => $notificationMessage,
            'is_unread' => true,
            'status' => 0, // 0 = no option chosen
            'type' => $notificationType // 2 = normal notification
        ]);

        return response()->json($request);
    }
}
