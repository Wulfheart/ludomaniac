<?php

namespace Domain\Core\Actions;

use Domain\Core\Models\NMR;
use Domain\Core\Models\Player;

class AddNMRForPlayerAction
{
    public function execute(Player $player)
    {
        NMR::create([
            'user_id' => $player->user_id,
            'game_id' => $player->game_id,
        ]);
    }
}
