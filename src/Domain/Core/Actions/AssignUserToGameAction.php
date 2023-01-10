<?php

namespace Domain\Core\Actions;

use Domain\Core\Events\UserAssignedToGameEvent;
use Domain\Core\Models\Player;
use Domain\Users\Models\User;

class AssignUserToGameAction
{
    public function execute(Player $player, User $user)
    {
        $player->user_id = $user->id;
        $player->save();

        UserAssignedToGameEvent::dispatch($player->game_id, $user->id);
    }
}
