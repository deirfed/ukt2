<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Walikota>
 */
class WalikotaFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => $this->faker->city,
            'code' => $this->faker->unique()->regexify('[A-Z]{2}[0-9]{2}'),
            'provinsi_id' => $this->faker->numberBetween(1,10),
            'admin_id' => $this->faker->numberBetween(1,10),
        ];
    }
}
