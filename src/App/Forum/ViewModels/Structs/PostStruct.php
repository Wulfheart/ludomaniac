<?php

namespace App\Forum\ViewModels\Structs;

use Domain\Forum\Models\Post;

class PostStruct
{
    public function __construct(
        public string $link,
        public string $content,
        public string $createdAt,
        public UserStruct $user,
    ) {
    }

    public static function fromPost(Post $post): self
    {
        $pd = new \Parsedown();
        $pd->setSafeMode(true);

        return new self(
            link: route(''),
            content: $pd->text($post->body),
            createdAt: $post->created_at->translatedFormat(config('forum.date_time_format')),
            user: UserStruct::fromUser($post->user),
        );
    }
}
