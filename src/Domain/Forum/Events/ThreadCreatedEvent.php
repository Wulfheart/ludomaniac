<?php

namespace Domain\Forum\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ThreadCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public int $threadId,
    )
    {
    }
}
