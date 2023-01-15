<?php

namespace Domain\Forum\Actions;

use Domain\Forum\Models\Thread;
use Domain\Users\Models\User;

class SubscribeUserToThreadAction
{
    public function execute(User $user, Thread $thread): void
    {
        $thread->subscriptions()->updateOrCreate(['user_id' => $user->id]);
    }
}
