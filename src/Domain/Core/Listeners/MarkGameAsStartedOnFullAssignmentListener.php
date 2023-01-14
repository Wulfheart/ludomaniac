<?php

namespace Domain\Core\Listeners;

use Domain\Core\Enums\GameStateEnum;
use Domain\Core\Events\GameStartedEvent;
use Domain\Core\Events\UserAssignedToGameEvent;
use Domain\Core\Models\Game;

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
