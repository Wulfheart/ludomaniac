<?php

namespace App\Forum\ViewModels\Structs;

use Domain\Users\Models\User;

class UserStruct
{
    public function __construct(
        public string $link,
        public string $name,
    ) {
    }

    public static function fromUser(User $user): self
    {
        return new self(
            link: route(''),
            name: $user->name,
        );
    }
}
