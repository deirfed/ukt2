<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProvinsiFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => $this->faker->city,
            'code' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{2}'),
            'address' => $this->faker->address,
            'admin_id' => $this->faker->numberBetween(1,10),
        ];
    }
}
