<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JenisKendaraan>
 */
class JenisKendaraanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       return [
            'nama_jenis' => $this->faker->randomElement(['Mobil', 'Motor', 'Truk', 'Bus']),
            'tipe_kendaraan' => $this->faker->randomElement([
                'Avanza', 'Xenia', 'Brio', 'Fortuner', 'Civic', 'Jazz', 'Vario', 'Beat', 'Nmax'
            ]),
            'deskripsi' => $this->faker->sentence(10),
        ];
    }
}
