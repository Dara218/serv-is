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

class NotificationEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

     public $username;
     public $userIdToReceive;

     public $notificationMessage;

     public $notificationType;

    public function __construct($username, $userIdToReceive, $notificationMessage, $notificationType)
    {
        $this->username = $username;
        $this->userIdToReceive = $userIdToReceive;
        $this->notificationMessage = $notificationMessage;
        $this->notificationType = $notificationType;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('notifications.'.$this->userIdToReceive),
        ];
    }

    public function broadcastAs(){
        return 'user.notif';
    }
}
