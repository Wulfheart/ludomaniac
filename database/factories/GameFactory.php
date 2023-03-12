<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Game>
 */
class GameFactory extends Factory
{
    protected $model = Game::class;

    public function definition()
    {
        return [
            'name' => fake()->name(),
            'description' => null,
            'variant_id' => Variant::factory()->create()->id,
        ];
    }

    public function forVariant(Variant $variant): self
    {
        return $this->state(function (array $attributes) use ($variant) {
            return [
                'variant_id' => $variant->id,
            ];
        });
    }

    public function forGameMaster(User $user): self
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'game_master_id' => $user->id,
            ];
        });
    }
}
