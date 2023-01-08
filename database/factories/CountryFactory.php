<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Domain\Core\Models\Country;

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
