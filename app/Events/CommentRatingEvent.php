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

class CommentRatingEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $agentId;
    public $serviceTypeId;
    public $starRating;
    public $message;

    public $review;

    /**
     * Create a new event instance.
     */
    public function __construct($userId, $agentId, $serviceTypeId, $starRating, $message, $review)
    {
        $this->userId = $userId;
        $this->agentId = $agentId;
        $this->serviceTypeId = $serviceTypeId;
        $this->starRating = $starRating;
        $this->message = $message;
        $this->review = $review;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('reviews.'.$this->agentId)
        ];
    }

    public function broadcastAs(){
        return 'rating';
    }
}
