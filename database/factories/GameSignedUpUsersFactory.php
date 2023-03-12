<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\GameSignedUpUsers;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GameSignedUpUsers>
 */
class GameSignedUpUsersFactory extends Factory
{
    protected $model = GameSignedUpUsers::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create()->id,
            'game_id' => Game::factory()->create()->id,
        ];
    }

    public function forGame(Game $game): self
    {
        return $this->state(function (array $attributes) use ($game) {
            return [
                'game_id' => $game->id,
            ];
        });
    }

    public function forUser(User $user): self
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'user_id' => $user->id,
            ];
        });
    }
}
