<?php

namespace Database\Seeders;

use App\Models\Tim;
use App\Models\Role;
use App\Models\Pulau;
use App\Models\Seksi;
use App\Models\Jabatan;
use App\Models\Provinsi;
use App\Models\Walikota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\UnitKerja;
use App\Models\EmployeeType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {

        $role = [
            ['Superadmin', 'SA'],
            ['Admin', 'A'],
            ['User', 'U'],
        ];

        $provinsi = [
            ['DKI Jakarta', 'DKI'],
        ];

        $walikota = [
            ['Kepulauan Seribu', 'KS'],
        ];

        $seksi = [
            ['Pencahayaan', 'PC'],
            ['Pertamanan', 'PT'],
        ];

        $unitKerja = [
            ['Unit Kerja Teknis 2', 'UKT 2'],
        ];

        $kelurahan = [
            ['Kelurahan Maju Jaya', 'MJ'],
            ['Kelurahan Maju Mundur', 'MM'],
            ['Kelurahan Maju Selalu', 'MS'],
        ];

        $kecamatan = [
            ['Kecamatan Kep. Seribu Selatan', 'KS'],
            ['Kecamatan Kep. Seribu Utara', 'KU'],
        ];

        $tim = [
            ['Tim Pencahayaan I', 'TPC I'],
            ['Tim Pencahayaan II', 'TPC II'],
            ['Tim Pertamanan I', 'TPT I'],
            ['Tim Pertamanan II', 'TPT II'],
        ];

        $pulau = [
            ['Untung Jawa', 'UJ'],
            ['Tidung', 'TD'],
            ['Karya', 'KY'],
        ];

        $jabatan = [
            ['Kepala Seksi', 'KS'],
            ['Staff', 'S'],
        ];

        $employeeType = [
            ['Pegawai Negeri Sipil', 'PNS'],
            ['Koordinator', 'K'],
            ['Penyedia Lainnya Jasa Perorangan', 'PJLP'],
        ];

        $this->seedData(Role::class, $role);
        $this->seedData(Provinsi::class, $provinsi);
        $this->seedData(Walikota::class, $walikota);
        $this->seedData(Seksi::class, $seksi);
        $this->seedData(UnitKerja::class, $unitKerja);
        $this->seedData(Kelurahan::class, $kelurahan);
        $this->seedData(Kecamatan::class, $kecamatan);
        $this->seedData(Tim::class, $tim);
        $this->seedData(Pulau::class, $pulau);
        $this->seedData(Jabatan::class, $jabatan);
        $this->seedData(EmployeeType::class, $employeeType);
    }

    private function seedData($modelClass, $data)
    {
        foreach ($data as $item) {
            $modelClass::create(['name' => $item[0], 'code' => $item[1]]);
        }
    }

}
