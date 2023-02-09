<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;

class UserBuilder extends Builder
{
    public function whereNotPlayingInGame(int $gameId): self
    {
        return $this->whereDoesntHave('playsIn', function (Builder $query) use ($gameId) {
            $query->where('game_id', $gameId);
        });
    }

    // TODO: Test
    public function whereNotSignedUpForGame(int $gameId): self
    {
        return $this->whereDoesntHave('signedUpGames', function (Builder $query) use ($gameId) {
            $query->where('game_id', $gameId);
        });
    }

    // TODO: Test
    public function whereSignedUpForGame(int $gameId): self
    {
        return $this->whereHas('signedUpGames', function (Builder $query) use ($gameId) {
            $query->where('game_id', $gameId);
        });
    }

    public function whereIsGameMaster(): self
    {
        return $this->where('is_game_master', true);
    }
}
