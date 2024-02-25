<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Struktur;
use Illuminate\Database\Seeder;
use Database\Factories\AreaFactory;

class RelasiSeeder extends Seeder
{
    public function run()
    {
        Area::factory(10)->create();
        Struktur::factory(4)->create();
    }
}
