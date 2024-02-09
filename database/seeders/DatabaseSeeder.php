<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CompanySeeder;
use Database\Seeders\DivisionSeeder;
use Database\Seeders\DirectorySeeder;
use Database\Seeders\DepartmentSeeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call([
            ProvinsiSeeder::class,
            WalikotaSeeder::class,
        ]);
    }
}
