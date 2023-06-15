<?php

namespace App\Http\Controllers;

use App\Events\Message;
use App\Events\NotificationEvent;
use App\Events\NotificationMessageBadgeEvent;
use App\Models\AvailedPricingPlan;
use App\Models\AvailedUser;
use App\Models\Chat;
use App\Models\Message as ModelsMessage;
use App\Models\Notification;
use App\Models\SentRequest;
use App\Models\User;
use Carbon\Carbon;
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
            'chat_room_id' => $chatRoom->id
        ]);

        event(new NotificationMessageBadgeEvent(
            $receiver->id,
            $sender->id,
            $chatRoom->id
        ));

        /*
            ---1. make column on chat named has_unread
            ---2. add if else on blade if has_unread is true, show new message badge
            3. if new meesage, append it on chat head where sender == receiver and receiver == sender
        */

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


        SentRequest::create([
            'request_by' => $authUserId,
            'request_to' => $request->fromUserId,
            'type' => 2,
            'status' => 1
        ]);
    }

    public function updateMessageRead(Request $request)
    {
        $sender = $request->receiverId;
        $receiver = Auth::user();

        if($receiver->user_type == 2){
            $sender = $request->senderId;
        }

        ModelsMessage::where('receiver_id', $receiver->id)
                    ->where('chat_room_id', $request->id)
                    ->where('is_unread', true)
                    ->update([
                        'is_unread' => false
                    ]);

        $availedPricingPlan = AvailedPricingPlan::where(function ($query) use ($sender, $receiver) {
            $query->where('availed_to_id', $sender)
                    ->where('availed_by_id', $receiver->id);
        })->orWhere(function ($query) use ($sender, $receiver) {
            $query->where('availed_to_id', $receiver->id)
                    ->where('availed_by_id', $sender);
        })->first();

         $isExpired = false;

        if($receiver->user_type == 2 || $receiver->user_type == 3)
        {
            $deadline = Carbon::parse($availedPricingPlan->updated_at)->addDay();
            $remainingTime = Carbon::now()->diff($deadline);

            if($availedPricingPlan->is_expired == true)
            {
                $isExpired = true;
            }
        }
        else{
            $remainingTime = 0;
            $isExpired = false;
        }
        return response()->json([
            'remainingTime' => $remainingTime,
            'isExpired' => $isExpired
        ]);
    }

    public function getUnreadMessages()
    {
        $unreadMessages = ModelsMessage::where('receiver_id', Auth::user()->id)->where('is_unread', true)->get();
        $sentBy = [];

        foreach($unreadMessages as $unreadMessage){
            $sentBy[] = $unreadMessage->receiver->id;
        }

        return response()->json($sentBy);
    }
}
