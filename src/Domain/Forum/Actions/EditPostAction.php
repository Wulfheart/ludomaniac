<?php

namespace Domain\Forum\Actions;

use Domain\Forum\Models\Post;

class EditPostAction
{
    public function execute(Post $post, string $text): void
    {
        Post::update([
            'text' => $text,
        ]);
    }
}
