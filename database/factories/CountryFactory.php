<?php

namespace Database\Factories;

use Domain\Core\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Country>
 */
class CountryFactory extends Factory
{
    protected $model = Country::class;

    public function definition()
    {
        return [
            //
        ];
    }
}
