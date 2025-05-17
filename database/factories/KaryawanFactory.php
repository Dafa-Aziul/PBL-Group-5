<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Database\Eloquent\Factories\Factory;

class KaryawanFactory extends Factory
{
    protected $model = Karyawan::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Membuat user baru otomatis
            'nama' => $this->faker->name(),
            'jabatan' => $this->faker->jobTitle(),
            'no_hp' => $this->faker->phoneNumber(),
            'alamat' => $this->faker->address(),
            'tgl_masuk' => $this->faker->date(),
            'status' => $this->faker->randomElement(['aktif', 'tidak aktif']),
            // Untuk foto, jangan langsung simpan ke storage di faker, cukup kasih nama file dummy
            'foto' => 'default.png', // atau bisa buat file dummy di folder storage
        ];
    }
}
