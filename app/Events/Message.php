<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Message implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $username;
    public $message;
    public $receiverId;
    public $chatRoomId;

    /**
     * Create a new event instance.
     */
    public function __construct($username, $message, $receiverId, $chatRoomId)
    {
        $this->username = $username;
        $this->message = $message;
        $this->receiverId = $receiverId;
        $this->chatRoomId = $chatRoomId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('chat.'.$this->chatRoomId),
            // new Channel('chat.'.$this->chatRoomId),
        ];
    }

    public function broadcastAs(){
        return 'message';
    }

    public function broadcastWith(){
        return [
            'username' => $this->username,
            'message' => $this->message,
            'chatRoom' => $this->chatRoomId
        ];
    }
}
