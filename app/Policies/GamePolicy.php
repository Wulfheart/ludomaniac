<?php

namespace app\Policies;

use app\Models\Game;
use app\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GamePolicy
{
    use HandlesAuthorization;

    public function before(User $user): void
    {
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Game $game): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Game $game): bool
    {
        return $user->is_admin || ($game->game_master_id !== null && $game->game_master_id === $user->id);
    }

    public function updateGameMaster(User $user, Game $game): bool
    {
        return $user->is_admin;
    }

    public function updateName(User $user, Game $game): bool
    {
        return $user->is_admin;
    }

    public function delete(User $user, Game $game): bool
    {
        return false;
    }

    public function restore(User $user, Game $game): bool
    {
        return false;
    }

    public function forceDelete(User $user, Game $game): bool
    {
        return false;
    }
}
