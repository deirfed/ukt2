<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'nip' => $this->faker->numerify('##########'),
            'phone' => $this->faker->phoneNumber,
            'gender' => $this->faker->randomElement(['Laki-Laki', 'Perempuan']),
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => $this->faker->date,
            'alamat' => 'Kepulauan Seribu',
            'role_id' => $this->faker->numberBetween(1, 3),
            'jabatan_id' => 2,
            'employee_type_id' => $this->faker->numberBetween(1, 3),
            'area_id' => $this->faker->numberBetween(1, 10),
            'struktur_id' => $this->faker->numberBetween(1, 4),
            'bio' => $this->faker->paragraph,
        ];
    }
}
