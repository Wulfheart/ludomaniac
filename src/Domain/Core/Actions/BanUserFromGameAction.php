<?php

namespace Domain\Core\Actions;

use Domain\Core\Models\BanLog;
use Domain\Core\Models\Player;

class BanUserFromGameAction
{
    public function execute(Player $player): void
    {
        $oldUserId = $player->user_id;
        $player->user_id = null;
        $player->nmr_count = 0;
        $player->save();

        BanLog::create([
            'user_id' => $oldUserId,
            'game_id' => $player->game_id,
        ]);
    }
}
