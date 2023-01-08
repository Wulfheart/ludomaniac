<?php

namespace Domain\Core\Actions;

use Domain\Core\Models\Game;
use Domain\Core\Models\Player;
use Domain\Users\Models\User;

class BanUserFromGameAction
{
    public function execute(Player $player)
    {
        $player->user_id = null;
        $player->save();
    }
}
