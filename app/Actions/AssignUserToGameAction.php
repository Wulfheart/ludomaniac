<?php

namespace app\Actions;

use app\Events\UserAssignedToGameEvent;
use app\Models\Player;
use app\Models\User;

class AssignUserToGameAction
{
    public function execute(Player $player, User $user)
    {
        $player->user_id = $user->id;
        $player->save();

        UserAssignedToGameEvent::dispatch($player->game_id, $user->id);
    }
}
