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

class NotificationMessageBadgeEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

    public $receiverId;
    public $senderId;
    public $chatRoomId;

    public function __construct($receiverId, $senderId, $chatRoomId)
    {
        $this->receiverId = $receiverId;
        $this->senderId = $senderId;
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
            new PrivateChannel('message-badge.'.$this->receiverId),
        ];
    }

    public function broadcastAs(){
        return 'message.badge';
    }
}
