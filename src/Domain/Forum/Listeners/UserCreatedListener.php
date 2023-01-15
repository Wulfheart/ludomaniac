<?php

namespace Domain\Forum\Listeners;

use Domain\Forum\Events\ForumUserCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserCreatedListener implements ShouldQueue
{
    public function __construct()
    {
    }

    public function handle(ForumUserCreatedEvent $event)
    {
    }
}
