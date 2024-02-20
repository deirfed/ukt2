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
        ];
    }
}
