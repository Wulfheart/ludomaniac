<?php

namespace Domain\Core\Actions;

use Domain\Core\Enums\GameEndTypeEnum;
use Domain\Core\Events\GameFinishedEvent;
use Domain\Core\Models\Game;
use Domain\Core\Models\Player;

class FinishGameAction
{
    public function execute(Game $game, GameEndTypeEnum $endType): void
    {
        $game->update([
            'finished_at' => now(),
            'game_end_type' => $endType,
        ]);

        $result = $game->players()
            ->selectRaw('id, RANK() OVER (PARTITION BY game_id ORDER BY sc_count DESC) as rank')
            ->get()
            ->toArray();
        foreach ($result as $item) {
            Player::query()->where('id', $item['id'])->update(['rank' => $item['rank']]);
        }

        GameFinishedEvent::dispatch($game->id);
    }
}
