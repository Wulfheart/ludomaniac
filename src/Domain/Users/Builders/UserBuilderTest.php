<?php

namespace Domain\Users\Builders;

use Database\Seeders\VariantSeeder;
use Domain\Core\Actions\InitializeGameAction;
use Domain\Core\Models\Game;
use Domain\Core\Models\Variant;
use Domain\Users\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class UserBuilderTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_where_not_playing_in_game(): void
    {
        // Setup
        $this->seed(VariantSeeder::class);
        User::factory(10)->create();

        $game = Game::factory()->create(['variant_id' => Variant::first()->id]);
        /** @var InitializeGameAction $action */
        $action = app(InitializeGameAction::class);
        $action->execute($game);
        $this->assertDatabaseCount('players', 7);

        // Test
        $users = User::query()->whereNotPlayingInGame($game->id)->get();
        $this->assertCount(10, $users);

        $assignedUser = $users->first();
        $game->players()->first()->update(['user_id' => $assignedUser->id]);

        $users = User::query()->whereNotPlayingInGame($game->id)->get();
        $this->assertCount(9, $users);
        $this->assertNotContains($assignedUser, $users);

        $this->assertTrue(true);
    }

    public function test_where_not_signed_up_for_game(): void
    {
        // Setup
        $this->seed(VariantSeeder::class);
        User::factory(10)->create();

        $game = Game::factory()->create(['variant_id' => Variant::first()->id]);
        /** @var InitializeGameAction $action */
        $action = app(InitializeGameAction::class);
        $action->execute($game);

        // Test
        $users = User::query()->whereNotPlayingInGame($game->id)->get();
        $this->assertCount(10, $users);

        $assignedUser = $users->first();
        $game->players()->first()->update(['user_id' => $assignedUser->id]);

        $users = User::query()->whereNotPlayingInGame($game->id)->get();
        $this->assertCount(9, $users);
        $this->assertNotContains($assignedUser, $users);

        $this->assertTrue(true);
    }
}