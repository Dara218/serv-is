<?php

namespace App\Http\Controllers;

use App\Events\Message;
use App\Events\NotificationEvent;
use App\Events\NotificationMessageBadgeEvent;
use App\Models\AvailedUser;
use App\Models\Chat;
use App\Models\Message as ModelsMessage;
use App\Models\Notification;
use App\Models\SentRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function handleMessage(Request $request){

        $sender = Auth::user();
        $receiver = User::where('username', $request->receiver_hidden)->first();

        $chatRoom = Chat::where(function ($query) use ($sender, $receiver) {
                    $query->where('sender_id', $sender->id)
                          ->where('receiver_id', $receiver->id);
                })->orWhere(function ($query) use ($sender, $receiver) {
                    $query->where('sender_id', $receiver->id)
                          ->where('receiver_id', $sender->id);
                })->first();

        ModelsMessage::create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'message' => $request->message,
        ]);

        event(new NotificationMessageBadgeEvent(
            $receiver->id,
        ));

        //toOthers() prevent sender from getting appends after sending.
        broadcast(new Message(
            $sender->username,
            $request->message,
            $receiver->id,
            $chatRoom->id
        ));

        $appendMessageContent = [$request->message, $sender->username];

        return [$appendMessageContent];
    }

    public function storeChatAfterNegotiate(Request $request){

        $notificationMessage = "You can now pay $request->username. Kindly check your inbox.";
        $notificationType = 2;
        $authUserId = $request->currentUserId;

        $notification = Notification::create([
            'user_id' => $authUserId, // to
            'from_user_id' => $request->fromUserId, // from
            'username' => $request->username,
            'message' => $notificationMessage,
            'is_unread' => true,
            'status' => 3,
            'type' => $notificationType
        ]);

        event(new NotificationEvent(
            'Ser-is Assistant',
            $authUserId, // wrong
            $notificationMessage,
            $notificationType,
            $notification->id,
            $authUserId
        ));

        // AvailedUser::create([
        //     'availed_by' => $authUserId,
        //     'availed_to' => $request->fromUserId,
        //     'is_accepted' => false,
        //     'notification_id' => $request->notificationId
        // ]);

        SentRequest::create([
            'request_by' => $authUserId,
            'request_to' => $request->fromUserId,
            'type' => 2,
            'status' => 1
        ]);
    }
}
