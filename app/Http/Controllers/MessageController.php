<?php

namespace App\Http\Controllers;

use App\Events\Message;
use App\Models\Chat;
use App\Models\Message as ModelsMessage;
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
}
