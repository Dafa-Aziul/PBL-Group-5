<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pelanggan>
 */
class PelangganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama'       => $this->faker->name,
            'email'      => $this->faker->unique()->safeEmail,
            'no_hp'      => $this->faker->phoneNumber,
            'alamat'     => $this->faker->address,
            'keterangan' => $this->faker->randomElement(['perusahaan', 'pribadi']),
        ];
    }
}
