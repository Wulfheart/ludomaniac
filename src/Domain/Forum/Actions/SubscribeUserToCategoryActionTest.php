<?php

namespace Domain\Forum\Actions;

use Domain\Forum\Models\Category;
use Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscribeUserToCategoryActionTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateSubscription()
    {
        $user = User::factory()->create();
        /** @var Category $category */
        $category = Category::factory()->create();

        $this->assertDatabaseCount('subscriptions', 0);

        (new SubscribeUserToCategoryAction())->execute($user, $category);

        $this->assertDatabaseCount('subscriptions', 1);
    }

    public function testSubscriptionNotCreatedTwiceWithSameValues(): void
    {
        $user = User::factory()->create();
        /** @var Category $category */
        $category = Category::factory()->create();

        $this->assertDatabaseCount('subscriptions', 0);

        (new SubscribeUserToCategoryAction())->execute($user, $category);

        $this->assertDatabaseCount('subscriptions', 1);
        (new SubscribeUserToCategoryAction())->execute($user, $category);
        $this->assertDatabaseCount('subscriptions', 1);
    }

    public function testSubscriptionCanBeCreatedForMultipleUsers(): void
    {
        $user = User::factory()->createQuietly();
        /** @var Category $category */
        $category = Category::factory()->create();

        $this->assertDatabaseCount('subscriptions', 0);

        (new SubscribeUserToCategoryAction())->execute($user, $category);

        $this->assertDatabaseCount('subscriptions', 1);

        $user2 = User::factory()->createQuietly();
        (new SubscribeUserToCategoryAction())->execute($user2, $category);
        $this->assertDatabaseCount('subscriptions', 2);
    }
}
