<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SeksiFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'code' => $this->faker->unique()->regexify('[A-Z]{2}[0-9]{2}'),
        ];
    }
}
