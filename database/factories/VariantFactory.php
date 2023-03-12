<?php

namespace Database\Factories;

use App\Models\Variant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Variant>
 */
class VariantFactory extends Factory
{
    protected $model = Variant::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
        ];
    }
}
