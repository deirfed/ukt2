<?php

namespace Database\Seeders;

use App\Models\Seksi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeksiSeeder extends Seeder
{

    public function run(): void
    {
        Seksi::factory(10)->create();
    }
}
