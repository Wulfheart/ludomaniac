<?php

namespace App\Actions;

use App\Events\UserAssignedToGameEvent;
use App\Models\Player;
use App\Models\User;

class AssignUserToGameAction
{
    public function execute(Player $player, User $user)
    {
        $player->user_id = $user->id;
        $player->save();

        UserAssignedToGameEvent::dispatch($player->game_id, $user->id);
    }
}
