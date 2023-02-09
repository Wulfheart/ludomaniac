<?php

namespace App\Listeners;

use app\Enums\GameStateEnum;
use app\Events\GameStartedEvent;
use app\Events\UserAssignedToGameEvent;
use app\Models\Game;

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
