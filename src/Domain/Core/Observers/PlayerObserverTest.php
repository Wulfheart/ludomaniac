<?php

namespace Domain\Core\Observers;

use Domain\Core\Models\Player;
use Domain\Users\Models\User;
use Tests\GameTestCase;

class PlayerObserverTest extends GameTestCase
{
    public function testNmrCountIsResetWhenUserIsChanged()
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
        $player->nmr_count = 3;
        $player->save();
        $player->user_id = User::factory()->create()->id;
        $player->save();
        $this->assertEquals(0, $player->nmr_count);


    }

}
