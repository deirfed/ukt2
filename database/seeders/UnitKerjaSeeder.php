<?php

namespace Database\Seeders;

use App\Models\UnitKerja;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UnitKerjaSeeder extends Seeder
{

    public function run(): void
    {
       UnitKerja::factory(3)->create();
    }
}
