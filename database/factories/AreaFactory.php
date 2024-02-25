<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AreaFactory extends Factory
{

    public function definition(): array
    {
        return [
            'provinsi_id' => '1',
            'walikota_id' => '1',
            'kecamatan_id' => $this->faker->numberBetween(1,2),
            'kelurahan_id' => $this->faker->numberBetween(1,3),
            'pulau_id' => $this->faker->numberBetween(1,3),
        ];
    }
}
