<?php

namespace Tests;

use app\Actions\InitializeGameAction;
use app\Models\Game;
use app\Models\User;
use app\Models\Variant;
use Database\Seeders\VariantSeeder;

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
