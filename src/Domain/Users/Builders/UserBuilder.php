<?php

namespace Domain\Users\Builders;

use Illuminate\Database\Eloquent\Builder;

class UserBuilder extends Builder
{
    public function whereNotPlayingInGame(int $gameId): self
    {
        return $this->whereDoesntHave('playsIn', function (Builder $query) use ($gameId) {
            $query->where('game_id', $gameId);
        });
    }
}
