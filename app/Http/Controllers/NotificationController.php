<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Models\AvailedUser;
use App\Models\Notification;
use App\Models\SentRequest;
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

    public function updateNotificationAccept(Notification $notification, Request $request)
    {
        $userNotification = Notification::where('id', $notification->id)->update(['status' => 1]);
        SentRequest::where('request_by', $request->fromUserId)->where('request_to', Auth::user()->id)->update(['status' => 1]);
        return response()->json($userNotification);
    }

    public function updateNotificationReject(Notification $notification, Request $request){
        $userNotification = Notification::where('id', $notification->id)->update(['status' => 2]);
        SentRequest::where('request_by', $request->fromUserId)->where('request_to', Auth::user()->id)->update(['status' => 1]);
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

        $notification = Notification::create([
            'user_id' => $toUser->id,
            'from_user_id' => $toUser->id,
            'username' => $fromUser->username,
            'message' => $notificationMessage,
            'is_unread' => true,
            'status' => 3, // 3 = normal notification
            'type' => 2 // 2 = normal notification
        ]);

        event(new NotificationEvent(
            $fromUser->username,
            $toUser->id,
            $notificationMessage,
            $notificationType,
            $notification->id,
            $fromUser->id
        ));

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
        $type = $request->type;
        $notificationMessage = "$fromUser->username wants to take your agenda.";

        if($type == 1){
            $notificationMessage = "$fromUser->username made an offer of P$request->counterPrice.";
        }

        $notificationType = 3;

        $notification = Notification::create([
            'user_id' => $request->userId,
            'from_user_id' => $fromUser->id,
            'username' => $fromUser->username,
            'message' => $notificationMessage,
            'is_unread' => true,
            'status' => 0, // 0 = no option chosen
            'type' => $notificationType // 3 (accept or reject) negotiate
        ]);

        SentRequest::create([
            'request_by' => $fromUser->id,
            'request_to' => $request->userId,
            'type' => 1,
            'status' => 1
        ]);

        event(new NotificationEvent(
            $fromUser->username, // from
            $request->userId, // to
            $notificationMessage,
            $notificationType,
            $notification->id,
            $fromUser->id
        ));

        return response()->json($request);
    }
}
