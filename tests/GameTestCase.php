<?php

namespace Tests;

use App\Actions\InitializeGameAction;
use App\Models\Game;
use App\Models\User;
use App\Models\Variant;
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
