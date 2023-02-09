<?php

namespace app\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\GameTestCase;

class PlayerTest extends GameTestCase
{
    use RefreshDatabase;

    public function testNmrsRelation()
    {
        $game = $this->initializeGame();
        $game->loadMissing('players');

        $game->players->each(function (Player $player) {
            $player->user_id = User::factory()->create()->id;
            $player->save();
        });

        $game->refresh();
        $game->load('players');
        $player = $game->players()->first();

        $player->load('NMRs');
        $this->assertCount(0, $player->NMRs);

        NMR::create([
            'game_id' => $game->id,
            'user_id' => $player->user_id,
        ]);
        $player->refresh();
        $player->load('NMRs');
        $this->assertCount(1, $player->NMRs);

        $secondGame = Game::factory()->create(['variant_id' => Variant::first()->id]);

        NMR::create([
            'game_id' => $secondGame->id,
            'user_id' => $player->user_id,
        ]);
        $player->load('NMRs');
        $this->assertCount(1, $player->NMRs);
    }
}
