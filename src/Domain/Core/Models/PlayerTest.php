<?php

namespace Domain\Core\Models;

use Database\Seeders\VariantSeeder;
use Domain\Core\Actions\InitializeGameAction;
use Domain\Users\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\GameTestCase;
use Tests\TestCase;

class PlayerTest extends GameTestCase {
    use RefreshDatabase;

    public function testNmrsRelation(){
        $game = $this->initializeGame();
        $game->loadMissing('players');

        $game->players->each(function(Player $player){
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
