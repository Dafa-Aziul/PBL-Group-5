<?php

namespace Database\Factories;

use App\Models\JenisKendaraan;
use App\Models\Kendaraan;
use App\Models\Pelanggan;
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

    public function configure(): static
    {
        return $this->afterCreating(function (Pelanggan $pelanggan) {
            Kendaraan::create([
                'pelanggan_id' => $pelanggan->id,
                'jenis_kendaraan_id' => JenisKendaraan::inRandomOrder()->first()->id,
                'no_polisi' => $this->faker->unique()->regexify('[A-Z]{1,2}[0-9]{1,4}[A-Z]{0,3}'), // contoh no polisi random
                'tipe_kendaraan' => $this->faker->word(),
                'odometer' => $this->faker->numberBetween(1000, 200000),
            ]);
        });
    }
}
