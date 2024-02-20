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
        ];
    }
}
