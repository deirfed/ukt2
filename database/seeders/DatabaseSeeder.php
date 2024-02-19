<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\SeksiSeeder;
use Database\Seeders\ProvinsiSeeder;
use Database\Seeders\WalikotaSeeder;
use Database\Seeders\UnitKerjaSeeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->call([
            ProvinsiSeeder::class,
            WalikotaSeeder::class,
            UnitKerjaSeeder::class,
            SeksiSeeder::class,
        ]);

        Role::create([
            'name' => 'Superadmin',
            'code'  => 'SA'
        ]);
        Role::create([
            'name' => 'Admin',
            'code'  => 'A'
        ]);
        Role::create([
            'name' => 'User',
            'code'  => 'U'
        ]);
    }
}
