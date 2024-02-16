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
            'unitkerja_id' => $this->faker->numberBetween(1,1),
            'provinsi_id' => $this->faker->numberBetween(1,1),
            'walikota_id' => $this->faker->numberBetween(1,6),
            'admin_id' => $this->faker->numberBetween(1,10),
        ];
    }
}
