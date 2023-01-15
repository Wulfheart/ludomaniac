<?php

namespace Domain\Forum\Actions;

use Domain\Forum\Events\ThreadCreatedEvent;
use Domain\Forum\Models\Category;
use Domain\Forum\Models\Thread;
use Domain\Users\Models\User;

class CreateThreadAction
{
    public function __construct(
        protected CreatePostAction $createPostAction,
    ) {
    }

    public function execute(Category $category, User $user, string $title, string $firstText): void
    {
        $thread = Thread::create([
            'title' => $title,
            'category_id' => $category->id,
        ]);

        $this->createPostAction->execute($thread, $user, $firstText);

        ThreadCreatedEvent::dispatch($thread->id);
    }
}
