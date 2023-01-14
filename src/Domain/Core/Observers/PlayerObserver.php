<?php

namespace Domain\Core\Observers;

use Domain\Core\Models\Player;

class PlayerObserver
{
    public function updated(Player $player): void
    {
        if ($player->wasChanged('user_id')) {
            $player->nmr_count = 0;
        }


        // WARNING: This could make problems later on as it does
        // not work with $player->save();
        // We are already in an observer and we only save to player
        // so no problem as it would trigger an endless loop.
        if($player->isDirty()){
            $player->saveQuietly();
        }
    }
}
