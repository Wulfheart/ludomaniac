<?php

namespace Domain\Core\Actions;

use Domain\Core\Models\Player;

class BanUserFromGameAction
{
    public function execute(Player $player)
    {
        $player->user_id = null;
        $player->save();
    }
}
