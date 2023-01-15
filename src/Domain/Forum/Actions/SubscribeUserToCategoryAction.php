<?php

namespace Domain\Forum\Actions;

use Domain\Forum\Models\Category;
use Domain\Users\Models\User;

class SubscribeUserToCategoryAction
{
    public function execute(User $user, Category $category): void
    {
        $category->subscriptions()->updateOrCreate(['user_id' => $user->id]);
    }
}
