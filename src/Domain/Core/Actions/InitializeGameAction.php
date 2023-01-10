<?php

namespace Domain\Core\Actions;

use Domain\Core\Models\Game;
use Domain\Core\Models\Player;
use Domain\Core\Models\Power;

// Info: This needs to be an extra class and not a listener because we need to
//       be able to initialize it manually and preview the changes directly
//       in the admin panel.
class InitializeGameAction
{
    public function execute(Game $game): void
    {
        $game->load('variant.powers')->variant->powers->each(
            fn (Power $power) => Player::create([
                'game_id' => $game->id,
                'power_id' => $power->id,
                'user_id' => null,
            ])
        );
    }
}
