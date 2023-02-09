<?php

namespace App\Actions;

use App\Enums\GameEndTypeEnum;
use App\Events\GameFinishedEvent;
use App\Models\Game;
use App\Models\Player;

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
