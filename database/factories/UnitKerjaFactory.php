<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitKerjaFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => 'Unit Kerja Teknis 2',
            'code' => 'UKT 2',
            'provinsi_id' => 1,
            'walikota_id' => 1,
            'admin_id' => $this->faker->numberBetween(1,10),
        ];
    }
}
