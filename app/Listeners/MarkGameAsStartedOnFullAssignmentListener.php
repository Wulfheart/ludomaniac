<?php

namespace App\Listeners;

use App\Enums\GameStateEnum;
use App\Events\GameStartedEvent;
use App\Events\UserAssignedToGameEvent;
use App\Models\Game;

class MarkGameAsStartedOnFullAssignmentListener
{
    public function __construct()
    {
    }

    public function handle(UserAssignedToGameEvent $userAssignedToGameEvent): void
    {
        $game = Game::with('players')->findOrFail($userAssignedToGameEvent->gameId);

        if ($game->currentState() === GameStateEnum::STARTED) {
            return;
        }

        if ($game->players()->whereDoesntHaveAnAssignedUser()->exists()) {
            return;
        }

        $game->started_at = now();
        $game->save();
        GameStartedEvent::dispatch($game->id);
    }
}
