<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StrukturFactory extends Factory
{
    public function definition(): array
    {
        return [
            'unitkerja_id' => 1,
            'seksi_id' => $this->faker->numberBetween(1,2),
            'tim_id' => $this->faker->numberBetween(1,4),
        ];
    }
}
