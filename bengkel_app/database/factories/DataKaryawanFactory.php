<?php

namespace Database\Factories;
use App\Models\DataKaryawan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DataKaryawan>
 */
class DataKaryawanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create(); // bikin user baru

        return [
            'id_user' => $user->id,
            'email' => $user->email,
            'nama' => $this->faker->name(),
            'jabatan' => $this->faker->jobTitle(),
            'no_hp' => $this->faker->phoneNumber(),
            'alamat' => $this->faker->address(),
            'tanggal_masuk' => $this->faker->date(),
            'status' => $this->faker->randomElement(['aktif', 'tidak aktif']),
        ];
    }
}
