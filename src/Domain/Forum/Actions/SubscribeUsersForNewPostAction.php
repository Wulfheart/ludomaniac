<?php

namespace Domain\Forum\Actions;

use Domain\Forum\Models\Post;
use Domain\Forum\Models\Subscription;

class SubscribeUsersForNewPostAction
{
    public function __construct(
        protected SubscribeUserToThreadAction $subscribeUserToThreadAction,
    ) {
    }

    public function execute(Post $post): void
    {
        /** @var array<Subscription> $subscriptions */
        $post->thread->category->subscriptions()->chunk(200, function (array $subscriptions) use ($post) {
            foreach ($subscriptions as $subscription) {
                // This would be more efficient if it was a bulk insert or an insert select
                $this->subscribeUserToThreadAction->execute($subscription->user, $post->thread);
            }
        });
    }
}
