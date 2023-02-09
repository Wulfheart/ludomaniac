<?php

namespace App\Actions;

use App\Models\NMR;
use App\Models\Player;

class AddNMRForPlayerAction
{
    public function execute(Player $player)
    {
        $player->nmr_count++;
        $player->save();
        NMR::create([
            'user_id' => $player->user_id,
            'game_id' => $player->game_id,
        ]);
    }
}
