<?php

namespace Domain\Core\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserAssignedToGameEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public int $gameId,
        public int $userId,
    ) {
    }
}
