<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Message implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $username;
    public $message;
    public $receiver_hidden;

    /**
     * Create a new event instance.
     */
    public function __construct($username, $message, $receiver_hidden)
    {
        $this->username = $username;
        $this->message = $message;
        $this->receiver_hidden = $receiver_hidden;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            // new PrivateChannel('chat'),
            new Channel('chat'),
        ];
    }

    public function broadcastAs(){
        return 'message';
    }
}
