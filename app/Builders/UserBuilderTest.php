<?php

namespace App\Builders;

use App\Actions\InitializeGameAction;
use App\Models\Game;
use App\Models\User;
use App\Models\Variant;
use Database\Seeders\VariantSeeder;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class UserBuilderTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testWhereNotPlayinInGame(): void
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

    public function testWhereNotSignedUpForGame(): void
    {
        // Setup
        $this->seed(VariantSeeder::class);
        User::factory(10)->create();

        $game = Game::factory()->create(['variant_id' => Variant::first()->id]);
        /** @var InitializeGameAction $action */
        $action = app(InitializeGameAction::class);
        $action->execute($game);

        $this->markTestIncomplete();
        // Test
        //$users = User::query()->whereNotPlayingInGame($game->id)->get();
        //$this->assertCount(10, $users);
        //
        //$assignedUser = $users->first();
        //$game->players()->first()->update(['user_id' => $assignedUser->id]);
        //
        //$users = User::query()->whereNotPlayingInGame($game->id)->get();
        //$this->assertCount(9, $users);
        //$this->assertNotContains($assignedUser, $users);
        //
        //$this->assertTrue(true);
    }
}
