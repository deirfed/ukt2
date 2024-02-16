<?php

namespace Database\Seeders;

use App\Models\Walikota;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WalikotaSeeder extends Seeder
{

    public function run(): void
    {
        Walikota::factory(6)->create();
    }
}
