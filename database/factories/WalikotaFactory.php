<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WalikotaFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => $this->faker->city,
            'code' => $this->faker->unique()->regexify('[A-Z]{2}[0-9]{2}'),
        ];
    }
}
