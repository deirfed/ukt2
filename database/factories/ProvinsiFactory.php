<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProvinsiFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => 'DKI Jakarta',
            'code' => 'DKI',
            'address' => 'Jakarta',
            'admin_id' => $this->faker->numberBetween(1,10),
        ];
    }
}
