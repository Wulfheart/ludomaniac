<?php

namespace Database\Factories;

use app\Models\Game;
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
        ];
    }
}
