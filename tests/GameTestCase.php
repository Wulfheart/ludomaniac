<?php

namespace Tests;

use Database\Seeders\VariantSeeder;
use Domain\Core\Actions\InitializeGameAction;
use Domain\Core\Models\Game;
use Domain\Core\Models\Variant;
use Domain\Users\Models\User;

class GameTestCase extends TestCase
{
    public function initializeGame(): Game
    {
        // Setup
        $this->seed(VariantSeeder::class);
        User::factory(10)->create();

        $game = Game::factory()->create(['variant_id' => Variant::first()->id]);
        /** @var InitializeGameAction $action */
        $action = app(InitializeGameAction::class);
        $action->execute($game);

        return $game;
    }
}
