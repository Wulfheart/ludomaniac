<?php

namespace Domain\Forum\Actions;

use Domain\Forum\Events\PostCreatedEvent;
use Domain\Forum\Models\Post;
use Domain\Forum\Models\Thread;
use Domain\Users\Models\User;

class CreatePostAction
{
    public function execute(Thread $thread, User $user, string $text): void
    {
        $firstPost = $thread->posts()->count() === 0;

        $post = Post::create([
            'body' => $text,
            'thread_id' => $thread->id,
            'user_id' => $user->id,
        ]);

        PostCreatedEvent::dispatch($post->id, $firstPost);


    }
}
